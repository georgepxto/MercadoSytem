<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'food_type',
        'description',
        'active',
        'has_cnpj',
        'cnpj'
    ];

    protected $casts = [
        'active' => 'boolean',
        'has_cnpj' => 'boolean'
    ];

    /**
     * Get the products for the vendor.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get the orders for the vendor.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the schedules for the vendor.
     */
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    /**
     * Get the entries for the vendor.
     */
    public function entries()
    {
        return $this->hasMany(Entry::class);
    }
}
