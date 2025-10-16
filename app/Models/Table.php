<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Table extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'capacity',
        'status',
        'location',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'capacity' => 'integer',
    ];

    // სტატუსები
    public const STATUS_AVAILABLE = 'available';
    public const STATUS_OCCUPIED = 'occupied';
    public const STATUS_RESERVED = 'reserved';

    // ლოკაციები
    public const LOCATION_INDOOR = 'indoor';
    public const LOCATION_OUTDOOR = 'outdoor';
    public const LOCATION_TERRACE = 'terrace';
    public const LOCATION_VIP = 'vip';

    public static function getStatuses(): array
    {
        return [
            self::STATUS_AVAILABLE => 'თავისუფალი',
            self::STATUS_OCCUPIED => 'დაკავებული',
            self::STATUS_RESERVED => 'დაჯავშნილი',
        ];
    }

    public static function getLocations(): array
    {
        return [
            self::LOCATION_INDOOR => 'შიდა დარბაზი',
            self::LOCATION_OUTDOOR => 'გარე ტერიტორია',
            self::LOCATION_TERRACE => 'ტერასა',
            self::LOCATION_VIP => 'VIP ოთახი',
        ];
    }

    public function isAvailable(): bool
    {
        return $this->status === self::STATUS_AVAILABLE && $this->is_active;
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
