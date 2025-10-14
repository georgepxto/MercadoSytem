<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $number
 * @property string $location
 * @property string|null $description
 * @property bool $available
 * @property float $monthly_price
 * @property string|null $qr_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Box extends Model
{
    protected $connection = 'main';
    use HasFactory;

    protected $fillable = [
        'name',
        'number',
        'location',
        'description',
        'available',
        'monthly_price',
        'qr_token'
    ];

    protected $casts = [
        'available' => 'boolean',
        'monthly_price' => 'decimal:2'
    ];

    protected static function booted()
    {
        static::creating(function ($box) {
            if (empty($box->qr_token)) {
                $box->qr_token = (string) \Illuminate\Support\Str::uuid();
            }
        });
    }

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

    public function regenerateQrToken(): void
    {
        $this->qr_token = (string) \Illuminate\Support\Str::uuid();
        $this->save();
    }

    public function getCheckinUrlAttribute(): string
    {
        return url('/checkin/box' . $this->number);
    }
}
