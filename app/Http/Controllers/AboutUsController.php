<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AboutUs;

class AboutUsController extends Controller
{
    public function index()
    {
        $aboutUs = AboutUs::first();
        return view('admin.about.edit', compact('aboutUs'));
    }

    public function update(Request $request)
{
    $aboutUs = AboutUs::first();

    // If no record exists, create a new one
    if (!$aboutUs) {
        $aboutUs = new AboutUs();
    }

    $data = $request->only([
        'title', 'subtitle', 'abstract', 'article_link',
        'modal_title', 'modal_subtitle', 'modal_doi', 'modal_meta', 'modal_abstract', 'modal_article_link'
    ]);

    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')->store('images', 'public');
    }
    if ($request->hasFile('featured_1')) {
        $data['featured_1'] = $request->file('featured_1')->store('images', 'public');
    }
    if ($request->hasFile('featured_2')) {
        $data['featured_2'] = $request->file('featured_2')->store('images', 'public');
    }
    if ($request->hasFile('featured_3')) {
        $data['featured_3'] = $request->file('featured_3')->store('images', 'public');
    }

    // Use fill() + save() if creating a new record, otherwise update
    $aboutUs->fill($data)->save();

    return redirect()->back()->with('success', 'About Us updated successfully!');
}

    
}
