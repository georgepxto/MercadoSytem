<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'box_id',
        'entry_time',
        'exit_time',
        'entry_date',
        'notes'
    ];    protected $casts = [
        'entry_time' => 'datetime',
        'exit_time' => 'datetime',
        'entry_date' => 'date'
    ];

    // Mutator to ensure datetime is stored correctly in database
    public function setEntryTimeAttribute($value)
    {
        $this->attributes['entry_time'] = $value ? date('Y-m-d H:i:s', strtotime($value)) : null;
    }

    public function setExitTimeAttribute($value)
    {
        $this->attributes['exit_time'] = $value ? date('Y-m-d H:i:s', strtotime($value)) : null;
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
