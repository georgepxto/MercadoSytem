<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use App\Models\User;
use App\Providers\TenantServiceProvider;

class TenantCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenant:setup {action} {user_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gerenciar bases de dados dos tenants (create-all|create|migrate|seed)';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $action = $this->argument('action');
        $userId = $this->argument('user_id');

        switch ($action) {
            case 'create-all':
                return $this->createAllTenantDatabases();
            case 'create':
                if (!$userId) {
                    $this->error('user_id é obrigatório para criar base específica');
                    return 1;
                }
                return $this->createTenantDatabase($userId);
            default:
                $this->error('Ação inválida. Use: create-all, create');
                return 1;
        }
    }

    private function createAllTenantDatabases()
    {
        // Usar conexão main para buscar usuários
        Config::set('database.default', 'main');
        
        $users = User::all();
        $this->info("Criando bases de dados para {$users->count()} usuários...");

        foreach ($users as $user) {
            $this->createTenantDatabase($user->id);
        }

        $this->info('Todas as bases de dados foram criadas!');
        return 0;
    }

    private function createTenantDatabase($userId)
    {
        try {
            $database = TenantServiceProvider::getTenantDatabase($userId);
            
            // Usar conexão main para buscar usuário
            Config::set('database.default', 'main');
            $user = User::find($userId);
            
            if (!$user) {
                $this->error("Usuário com ID {$userId} não encontrado");
                return 1;
            }

            $this->info("Criando base para usuário: {$user->name} (ID: {$userId})");

            // Verificar se já existe
            $databases = DB::connection('main')->select("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?", [$database]);
            
            if (!empty($databases)) {
                $this->warn("Base {$database} já existe!");
                return 0;
            }

            // Criar conexão temporária sem base específica
            $tempConnection = config('database.connections.main');
            $tempConnection['database'] = null;
            Config::set('database.connections.temp', $tempConnection);

            // Criar base
            DB::connection('temp')->statement("CREATE DATABASE {$database} CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            $this->info("Base {$database} criada com sucesso!");

            // Configurar para tenant e executar migrations
            TenantServiceProvider::switchToTenantDatabase($userId);
            
            $this->info("Executando migrations para usuário ID: {$userId}");
            
            Artisan::call('migrate', [
                '--database' => 'tenant',
                '--force' => true
            ]);
            
            $this->info('Migrations executadas com sucesso!');
            
            return 0;

        } catch (\Exception $e) {
            $this->error("Erro ao criar base: " . $e->getMessage());
            return 1;
        }
    }
}
