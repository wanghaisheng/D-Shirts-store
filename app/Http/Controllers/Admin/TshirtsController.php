<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\TitleToFolderName;
use App\Http\Controllers\Controller;
use App\Models\ShirtImage;
use App\Models\Tshirt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TshirtsController extends Controller
{
    public function index()
    {
        $tshirts = Tshirt::with('images')->orderBy('updated_at', 'desc')->get()->map(function ($tshirt) {
            return [
                'id' => $tshirt->id,
                'title' => $tshirt->title,
                'description' => $tshirt->description,
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
            'description' => 'required|string',
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

    public function update(Request $request, Tshirt $tshirt)
    {
        // Validate request data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'mainImage' => 'nullable|max:1024',
            'secondImage' => 'nullable|max:1024',
            'thirdImage' => 'nullable|max:1024',
            'forthImage' => 'nullable|max:1024',
            'fifthImage' => 'nullable|max:1024',
        ]);

        // Folder name remains the same from the creation
        $folderName = TitleToFolderName::convert($tshirt->title);

        // Check and update only if there are changes in non-image fields
        if (
            $tshirt->title !== $validatedData['title'] ||
            $tshirt->price !== $validatedData['price'] ||
            $tshirt->description !== $validatedData['description']
        ) {
            $tshirt->title = $validatedData['title'];
            $tshirt->price = $validatedData['price'];
            $tshirt->description = $validatedData['description'];
            $tshirt->save();
        }

        

        // Array of images with their corresponding order and fixed names
        $images = [
            'mainImage' => 1,
            'secondImage' => 2,
            'thirdImage' => 3,
            'forthImage' => 4,
            'fifthImage' => 5,
        ];

        // Loop through each image input
        foreach ($images as $imageKey => $order) {
            if ($request->hasFile($imageKey)) {
                $existingImage = $tshirt->images()->where('order', $order)->first();

                // Delete the existing image file from storage if it exists
                if ($existingImage) {
                    Storage::disk('public')->delete($existingImage->url);
                }

                $file = $request->file($imageKey);
                $extension = $file->getClientOriginalExtension();
                $filename = "{$imageKey}.{$extension}";

                // Store the new image and update the path in the database
                $path = $file->storeAs("tshirts/{$folderName}", $filename, 'public');

                if ($existingImage) {
                    // Update existing ShirtImage
                    $existingImage->url = '/storage/' . $path;
                    $existingImage->save();
                } else {
                    // Create a new ShirtImage if not exists
                    $tshirt->images()->create([
                        'order' => $order,
                        'url' => '/storage/' . $path,
                    ]);
                }
            }
        }

        // Redirect to the t-shirts route
        return redirect()->route('t-shirts');
    }
}
