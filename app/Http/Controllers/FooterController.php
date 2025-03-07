<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FooterContent;

class FooterController extends Controller
{
    public function index()
    {
        $footerContent = FooterContent::first(); // Fetch the first footer entry
        return view('admin.footer.edit', compact('footerContent'));
    }

    public function update(Request $request)
    {
        $footer = FooterContent::first();
    
        $data = $request->only(['description', 'address', 'map_url']);
    
        if ($request->hasFile('featured_1')) {
            $data['featured_1'] = $request->file('featured_1')->store('images', 'public');
        }
        if ($request->hasFile('featured_2')) {
            $data['featured_2'] = $request->file('featured_2')->store('images', 'public');
        }
        if ($request->hasFile('featured_3')) {
            $data['featured_3'] = $request->file('featured_3')->store('images', 'public');
        }
    
        $footer->update($data);
    
        return redirect()->back()->with('success', 'Footer updated successfully!');
    }
    
}
