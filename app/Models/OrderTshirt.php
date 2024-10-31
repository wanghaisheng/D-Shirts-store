<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderTshirt extends Model
{
    protected $fillable = ['order_id', 'tshirt_id'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function tshirt()
    {
        return $this->belongsTo(Tshirt::class);
    }
}
