<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\SalesOrder;

class SalesOrderItem extends Model
{
    use HasFactory;

     protected $fillable = [
        'sales_order_id',
        'product_id',
        'quantity',
        'price',
    ];

    public function product()
    {
      return $this->belongsTo(Product::class);
    }

    public function salesOrder()
    {
        return $this->belongsTo(SalesOrder::class);
    }

}
