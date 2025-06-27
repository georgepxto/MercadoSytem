<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use App\Models\User;
use App\Models\DashboardManager;
use App\Providers\TenantServiceProvider;

class DashboardManagerController extends Controller
{
    public function __construct()
    {
        // Sempre usar conexão principal para operações de admin
        Config::set('database.default', 'main');
    }

    // Middleware removido - será aplicado nas rotas

    /**
     * Show admin dashboard
     */
    public function dashboard()
    {
        $users = User::all();
        $totalUsers = $users->count();
        $activeUsers = $users->where('has_dashboard_access', true)->count();
        $inactiveUsers = $users->where('has_dashboard_access', false)->count();

        return view('admin.dashboard', compact('users', 'totalUsers', 'activeUsers', 'inactiveUsers'));
    }

    /**
     * Show users management page
     */
    public function manageUsers()
    {
        $users = User::orderBy('name')->get();
        return view('admin.users', compact('users'));
    }

    /**
     * Toggle user dashboard access
     */
    public function toggleUserAccess(Request $request, User $user)
    {
        $manager = Auth::guard('dashboard_manager')->user();
        
        if ($user->has_dashboard_access) {
            $manager->revokeDashboardAccess($user);
            $message = "Acesso ao dashboard removido para {$user->name}";
        } else {
            $manager->grantDashboardAccess($user);
            $message = "Acesso ao dashboard concedido para {$user->name}";
        }

        return back()->with('success', $message);
    }

    /**
     * Update user dashboard name
     */
    public function updateDashboardName(Request $request, User $user)
    {
        $request->validate([
            'dashboard_name' => 'required|string|max:255'
        ]);

        $user->update([
            'dashboard_name' => $request->dashboard_name
        ]);

        return back()->with('success', "Nome da dashboard atualizado para {$user->name}");
    }

    /**
     * Create new user
     */
    public function createUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'dashboard_name' => 'nullable|string|max:255',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'dashboard_name' => $request->dashboard_name ?? $request->name,
            'user_type' => 'common',
            'has_dashboard_access' => true,
        ]);

        // Criar base de dados para o novo usuário
        $this->createUserDatabase($user->id);

        return back()->with('success', "Usuário {$user->name} criado com sucesso!");
    }

    /**
     * Delete user
     */
    public function deleteUser(User $user)
    {
        $userName = $user->name;
        $userId = $user->id;
        
        // Deletar base de dados do usuário
        $this->deleteUserDatabase($userId);
        
        // Deletar usuário
        $user->delete();

        return back()->with('success', "Usuário {$userName} e seus dados removidos com sucesso!");
    }

    /**
     * Update user information
     */
    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'dashboard_name' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'dashboard_name' => $request->dashboard_name ?? $request->name,
        ];

        // Só atualiza a senha se uma nova foi fornecida
        if ($request->filled('password')) {
            $updateData['password'] = bcrypt($request->password);
        }

        $user->update($updateData);

        return back()->with('success', "Usuário {$user->name} atualizado com sucesso!");
    }

    /**
     * Create database for user
     */
    private function createUserDatabase($userId)
    {
        try {
            $database = TenantServiceProvider::getTenantDatabase($userId);
            
            // Usar conexão sem especificar base para criar nova base
            $connection = config('database.connections.main');
            $connection['database'] = null;
            Config::set('database.connections.temp', $connection);
            
            // Verificar se a base já existe usando INFORMATION_SCHEMA
            $databases = DB::connection('temp')->select("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?", [$database]);
            
            if (empty($databases)) {
                // Criar base de dados
                DB::connection('temp')->statement("CREATE DATABASE {$database} CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
                
                // Configurar conexão para a nova base
                TenantServiceProvider::switchToTenantDatabase($userId);
                
                // Executar apenas migrations (sem seeders para evitar problemas)
                try {
                    Artisan::call('migrate', [
                        '--database' => 'tenant',
                        '--force' => true
                    ]);
                    \Log::info("Migrations executadas para usuário {$userId}");
                } catch (\Exception $migrationError) {
                    \Log::error("Erro ao executar migrations para usuário {$userId}: " . $migrationError->getMessage());
                    // Não falhar por causa das migrations, a base foi criada
                }
                
                // Voltar para conexão principal
                Config::set('database.default', 'main');
            }
            
        } catch (\Exception $e) {
            \Log::error('Erro ao criar base de dados do usuário: ' . $e->getMessage());
            // Não lançar exceção para não quebrar a criação do usuário
            // A base pode ser criada manualmente depois se necessário
        }
    }

    /**
     * Delete user database
     */
    private function deleteUserDatabase($userId)
    {
        try {
            $database = TenantServiceProvider::getTenantDatabase($userId);
            
            // Usar conexão sem especificar base
            $connection = config('database.connections.main');
            $connection['database'] = null;
            Config::set('database.connections.temp', $connection);
            
            // Verificar se a base existe e deletar usando INFORMATION_SCHEMA
            $databases = DB::connection('temp')->select("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?", [$database]);
            
            if (!empty($databases)) {
                DB::connection('temp')->statement("DROP DATABASE {$database}");
            }
            
        } catch (\Exception $e) {
            \Log::error('Erro ao deletar base de dados do usuário: ' . $e->getMessage());
        }
    }
}
