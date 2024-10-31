<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['customer_id', 'number_of_items', 'total_price', 'status', 'tracking_number'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function tshirts()
    {
        return $this->belongsToMany(Tshirt::class);
    }
}
