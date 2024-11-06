<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tshirt extends Model
{
    protected $fillable = ['title', 'description', 'price'];

    public function images()
    {
        return $this->hasMany(ShirtImage::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }

    public function mainImage()
    {
        return $this->images->where('order', 1)->first();
    }
    public function otherImages()
    {
        return $this->images->filter(function ($image) {
            return $image->id !== $this->mainImage()?->id;
        });
    }
}
