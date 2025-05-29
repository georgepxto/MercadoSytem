<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'box_id',
        'day_of_week',
        'start_time',
        'end_time',
        'active'
    ];

    protected $casts = [
        'active' => 'boolean',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i'
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function box()
    {
        return $this->belongsTo(Box::class);
    }
}
