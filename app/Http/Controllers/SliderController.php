<?php

namespace App\Http\Controllers;

use App\Models\SliderImage;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function index()
{
    $images = SliderImage::all(); // Fetch all images from the database
    return view('admin.slider.sliderchanger', compact('images')); // Admin page
}

public function homepage()
{
    $images = SliderImage::all(); // Fetch all images from the database
    return view('homepage', compact('images')); // Homepage
}

    public function carousel()
    {
        $images = SliderImage::all(); // Fetch all images from database
        return view('class.carousel', compact('images')); // Pass images to view
    }
    

    
    

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:50048',
        ]);

        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('images'), $imageName);

        SliderImage::create(['filename' => $imageName]);

        return redirect()->route('admin.slider.sliderchanger')->with('success', 'Image uploaded successfully.');
    } 

    public function destroy($id)
    {
        $sliderImage = SliderImage::findOrFail($id);
        $sliderImage->delete(); // Soft delete the image

        return redirect()->route('admin.slider.sliderchanger')->with('success', 'Image deleted successfully.');
    }
}