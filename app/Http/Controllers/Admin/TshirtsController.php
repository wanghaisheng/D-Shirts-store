<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\TitleToFolderName;
use App\Http\Controllers\Controller;
use App\Models\ShirtImage;
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

    public function store(Request $request)
    {
        // Validate request data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string|max:255',
            'mainImage' => 'required|image|max:1024',
            'secondImage' => 'nullable|image|max:1024',
            'thirdImage' => 'nullable|image|max:1024',
            'forthImage' => 'nullable|image|max:1024',
            'fifthImage' => 'nullable|image|max:1024',
        ]);

        // Create a new Tshirt instance and save it
        $tshirt = new Tshirt();
        $tshirt->title = $validatedData['title'];
        $tshirt->price = $validatedData['price'];
        $tshirt->description = $validatedData['description'];
        $tshirt->save();

        // Generate folder name from the first 3 words of the title
        $folderName = TitleToFolderName::convert($validatedData['title']);
        
        // Array of images with their corresponding order
        $images = [
            'mainImage' => 1,
            'secondImage' => 2,
            'thirdImage' => 3,
            'forthImage' => 4,
            'fifthImage' => 5,
        ];

        // Loop through each image input
        foreach ($images as $imageKey => $order) {
            // Check if the image exists in the request
            if ($request->hasFile($imageKey)) {
                $file = $request->file($imageKey);
                $extension = $file->getClientOriginalExtension(); // Get original extension
                $filename = "{$imageKey}.{$extension}";

                // Store the image in the public disk under the specified folder
                $path = $file->storeAs("tshirts/{$folderName}", $filename, 'public');

                // Create a new TshirtImage instance
                $tshirtImage = new ShirtImage();
                $tshirtImage->order = $order;
                $tshirtImage->tshirt_id = $tshirt->id;
                // $tshirtImage->url = Storage::url($path); // Get URL for public access
                $tshirtImage->url = '/storage/' . $path; // Get URL for public access
                $tshirtImage->save();
            }
        }

        // Redirect to the t-shirts route
        return redirect()->route('t-shirts');
    }



}
