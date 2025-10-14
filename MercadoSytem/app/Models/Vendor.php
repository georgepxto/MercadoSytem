<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;
    
    protected $connection = 'main';

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

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'vendor_id', 'id');
    }

    public function entries()
    {
        return $this->hasMany(Entry::class, 'vendor_id', 'id');
    }
}