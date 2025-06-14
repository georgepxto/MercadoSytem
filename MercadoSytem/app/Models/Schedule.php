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
    ];    protected $casts = [
        'active' => 'boolean'
    ];

    // Accessor to ensure time format is consistent
    public function getStartTimeAttribute($value)
    {
        return date('H:i', strtotime($value));
    }

    public function getEndTimeAttribute($value)
    {
        return date('H:i', strtotime($value));
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function box()
    {
        return $this->belongsTo(Box::class);
    }
}
