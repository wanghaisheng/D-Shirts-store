<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tshirt;
use Illuminate\Http\Request;

class TshirtsController extends Controller
{
    public function index()
    {
        $tshirts = Tshirt::with('images')->get()->map(function ($tshirt) {
            return [
                'id' => $tshirt->id,
                'title' => $tshirt->title,
                'price' => $tshirt->price,
                'mainImage' => $tshirt->mainImage(),
                'otherImages' => $tshirt->otherImages()
            ];
        });
        return inertia('Admin/Tshirts', ['tshirts' => $tshirts]);
    }
}
