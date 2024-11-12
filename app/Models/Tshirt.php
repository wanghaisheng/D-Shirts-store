<?php

namespace App\Models;

use App\Helpers\TitleToFolderName;
use Illuminate\Database\Eloquent\Model;

class Tshirt extends Model
{
    protected $fillable = ['title', 'description', 'price', 'listed', 'images_folder_name'];

    public function images()
    {
        return $this->hasMany(ShirtImage::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class)
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }

    public function getMainImage()
    {
        return $this->images->where('order', 1)->first();
    }
    public function getOtherImages()
    {
        return $this->images->filter(function ($image) {
            return $image->id !== $this->getMainImage()?->id;
        });
    }

    public function getImagesFolderName()
    {
        return $this->images_folder_name ?? TitleToFolderName::convert($this->title) ;
    }

    public function getTotalSales()
    {
        $this->loadMissing('orders');
        return $this->orders->sum('pivot.quantity');
    }

    public function getTotalRevenue()
    {
        $this->loadMissing('orders');
        return $this->orders->sum(function ($order) {
            return $order->pivot->quantity * $order->pivot->price;
        });
    }
}
