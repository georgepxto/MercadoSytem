<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;

class TenantDatabaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            $user = auth()->user();
            $tenantDatabase = $this->getTenantDatabase($user->id);
            
            // Criar banco se não existir
            $this->createTenantDatabaseIfNotExists($tenantDatabase);
            
            // Configurar conexão para o banco do usuário
            $this->configureTenantDatabase($tenantDatabase);
        }

        return $next($request);
    }

    /**
     * Get tenant database name
     */
    private function getTenantDatabase($userId)
    {
        return 'mercado_user_' . $userId;
    }

    /**
     * Configure tenant database connection
     */
    private function configureTenantDatabase($database)
    {
        Config::set('database.connections.tenant', [
            'driver' => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => $database,
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ]);

        // Configurar como conexão padrão para as operações do usuário
        Config::set('database.default', 'tenant');
        
        // Limpar conexões antigas
        DB::purge('tenant');
    }    /**
     * Create tenant database if it doesn't exist
     */
    private function createTenantDatabaseIfNotExists($database)
    {
        try {
            // Usar conexão main para verificar e criar base
            $databases = DB::connection('main')->select("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?", [$database]);
            
            if (empty($databases)) {
                // Criar banco usando conexão sem base específica
                $tempConnection = config('database.connections.main');
                $tempConnection['database'] = null;
                Config::set('database.connections.temp_create', $tempConnection);
                  // Criar base de dados
                DB::connection('temp_create')->statement("CREATE DATABASE {$database} CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
                
                // Executar migrations no novo banco
                $this->runTenantMigrations($database);
            }
            
        } catch (\Exception $e) {
            \Log::error('Erro ao criar banco do usuário: ' . $e->getMessage());
        }
    }

    /**
     * Run migrations for tenant database
     */
    private function runTenantMigrations($database)
    {
        try {
            // Configurar temporariamente para o banco do tenant
            $originalDefault = Config::get('database.default');
            Config::set('database.default', 'tenant');
            
            // Executar migrations
            Artisan::call('migrate', [
                '--database' => 'tenant',
                '--force' => true
            ]);
            
            // Restaurar configuração original
            Config::set('database.default', $originalDefault);
            
        } catch (\Exception $e) {
            \Log::error('Erro ao executar migrations do tenant: ' . $e->getMessage());
        }
    }
}
