<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */    protected $fillable = [
        'name',
        'email',
        'password',
        'dashboard_name',
        'user_type',
        'has_dashboard_access',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'has_dashboard_access' => 'boolean',
    ];

    /**
     * Check if user is admin type
     */
    public function isAdmin(): bool
    {
        return $this->user_type === 'admin';
    }

    /**
     * Check if user has dashboard access
     */
    public function hasDashboardAccess(): bool
    {
        return $this->has_dashboard_access;
    }

    /**
     * Get dashboard name (defaults to user name if not set)
     */
    public function getDashboardName(): string
    {
        return $this->dashboard_name ?? $this->name;
    }
}
