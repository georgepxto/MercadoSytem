<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Box extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'number',
        'location',
        'description',
        'available',
        'monthly_price'
    ];

    protected $casts = [
        'available' => 'boolean',
        'monthly_price' => 'decimal:2'
    ];

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function entries()
    {
        return $this->hasMany(Entry::class);
    }

    public function vendors()
    {
        return $this->belongsToMany(Vendor::class, 'schedules');
    }
}
