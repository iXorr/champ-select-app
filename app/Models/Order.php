<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    public const STATUSES = ['Новый', 'Отгрузка', 'Доставка', 'Выдан', 'Отменён'];

    protected $fillable = [
        'client_id',
        'user_id',
        'status',
        'total_sum',
        'shipped_at'
    ];

    protected $casts = [
        'shipped_at' => 'datetime'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
