<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\DashboardManager;

class DashboardManagerController extends Controller
{
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

        return back()->with('success', "Usuário {$user->name} criado com sucesso!");
    }

    /**
     * Delete user
     */
    public function deleteUser(User $user)
    {
        $userName = $user->name;
        $user->delete();

        return back()->with('success', "Usuário {$userName} removido com sucesso!");
    }
}
