<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'table_id',
        'user_id',
        'status',
        'payment_status',
        'total_amount',
        'paid_amount',
        'notes',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
    ];

    // სტატუსები
    public const STATUS_PENDING = 'pending';
    public const STATUS_CONFIRMED = 'confirmed';
    public const STATUS_PREPARING = 'preparing';
    public const STATUS_READY = 'ready';
    public const STATUS_SERVED = 'served';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELLED = 'cancelled';

    // გადახდის სტატუსები
    public const PAYMENT_UNPAID = 'unpaid';
    public const PAYMENT_PAID = 'paid';
    public const PAYMENT_PARTIAL = 'partial';

    public static function getStatuses(): array
    {
        return [
            self::STATUS_PENDING => 'მოლოდინში',
            self::STATUS_CONFIRMED => 'დადასტურებული',
            self::STATUS_PREPARING => 'მზადდება',
            self::STATUS_READY => 'მზადაა',
            self::STATUS_SERVED => 'მიტანილია',
            self::STATUS_COMPLETED => 'დასრულებული',
            self::STATUS_CANCELLED => 'გაუქმებული',
        ];
    }

    public static function getPaymentStatuses(): array
    {
        return [
            self::PAYMENT_UNPAID => 'გადაუხდელი',
            self::PAYMENT_PAID => 'გადახდილი',
            self::PAYMENT_PARTIAL => 'ნაწილობრივ გადახდილი',
        ];
    }

    public function table(): BelongsTo
    {
        return $this->belongsTo(Table::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function calculateTotal(): void
    {
        $this->total_amount = $this->items()->sum('subtotal');
        $this->save();
    }
}
