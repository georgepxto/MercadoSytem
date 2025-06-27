<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;

class TenantServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Configurar conexão principal para usuários e admins
        $this->configureMainDatabase();
    }

    /**
     * Configure main database for users and admin management
     */
    private function configureMainDatabase()
    {
        Config::set('database.connections.main', [
            'driver' => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'mercado_sistema'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ]);
    }

    /**
     * Get tenant database name for a user
     */
    public static function getTenantDatabase($userId)
    {
        return 'mercado_user_' . $userId;
    }

    /**
     * Switch to main database (for user/admin management)
     */
    public static function switchToMainDatabase()
    {
        Config::set('database.default', 'main');
    }

    /**
     * Switch to tenant database
     */
    public static function switchToTenantDatabase($userId)
    {
        $database = self::getTenantDatabase($userId);
        
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

        Config::set('database.default', 'tenant');
    }
}
