<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class SalesOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_amount',
    ];

    public function items()
   {
     return $this->hasMany(SalesOrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
