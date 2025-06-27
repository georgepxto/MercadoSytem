<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class DashboardManager extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The connection name for the model.
     */
    protected $connection = 'main';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get all users that this manager can control
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Grant dashboard access to a user
     */
    public function grantDashboardAccess(User $user): void
    {
        $user->update(['has_dashboard_access' => true]);
    }

    /**
     * Revoke dashboard access from a user
     */
    public function revokeDashboardAccess(User $user): void
    {
        $user->update(['has_dashboard_access' => false]);
    }
}
