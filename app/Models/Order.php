<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public const STATUS_NEW = 'new';
    public const STATUS_IN_PROGRESS = 'in_progress';
    public const STATUS_DONE = 'done';
    public const STATUS_CANCELED = 'canceled';

    protected $fillable = [
        'user_id',
        'contact_name',
        'contact_phone',
        'contact_email',
        'address',
        'preferred_date',
        'preferred_time',
        'payment_method',
        'status',
        'cancellation_reason',
        'total_price',
        'notes',
    ];

    protected $casts = [
        'preferred_date' => 'date',
        'preferred_time' => 'string',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function scopeForStatus($query, ?string $status)
    {
        if ($status && in_array($status, [
            self::STATUS_NEW,
            self::STATUS_IN_PROGRESS,
            self::STATUS_DONE,
            self::STATUS_CANCELED,
        ], true)) {
            $query->where('status', $status);
        }

        return $query;
    }

    public function getFormattedTotalAttribute(): string
    {
        return number_format($this->total_price, 0, '', ' ') . ' ₽';
    }

    public function getPreferredTimeFormattedAttribute(): string
    {
        return $this->preferred_time ? substr($this->preferred_time, 0, 5) : '';
    }
}
