<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{

    // Show the upload form
    public function showUploadForm()
    {
        return view('user.role.upload');
    }

    // Handle the image upload
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $image = $request->file('image');
        $filename = time() . '.' . $image->getClientOriginalExtension();
        Storage::disk('public')->put($filename, file_get_contents($image));


        // test::create([
        //     'text' =>  $request->content,
        //     'img' => $filename,
        // ]);

        Test::where('id', 1)->update([
            'text' => $request->content,
            'img' => $filename,
        ]);
        return redirect()->route('upload.form')->with('success', 'Image uploaded successfully!')->with('filename', $filename);
    }

    // Retrieve the image
    public function getImage($filename)
    {
        $path = storage_path('app/public/' . $filename);

        if (!file_exists($path)) {
            abort(404);
        }

        $file = file_get_contents($path);
        $type = mime_content_type($path);

        return response($file, 200)->header('Content-Type', $type);
    }
}
