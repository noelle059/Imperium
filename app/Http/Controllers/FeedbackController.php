<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\SliderImage; // Import SliderImage model

class FeedbackController extends Controller
{
    public function homepage()
    {
        $feedbacks = Feedback::all(); // Fetch feedback
        $images = SliderImage::all(); // Fetch slider images
    
        return view('homepage', compact('feedbacks', 'images')); // Pass data to homepage
    }
    

    public function index()
    {
        $feedbacks = Feedback::all();
        return view('admin.feedback.feedbackchanger', compact('feedbacks'));
    }



    public function store(Request $request)
    {
        // Validate the input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'message' => 'required|string',
            'interview_date' => 'nullable|date', // Allow NULL if not provided
            'client_info' => 'nullable|string',  // Allow NULL if not provided
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
    
        try {
            // Handle image upload
            $filename = null;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads'), $filename);
            }
    
            // Create feedback entry
            Feedback::create([
                'name' => $validatedData['name'],
                'position' => $validatedData['position'],
                'message' => $validatedData['message'],
                'interview_date' => $validatedData['interview_date'] ?? null, // Ensure NULL if empty
                'client_info' => $validatedData['client_info'] ?? null, // Ensure NULL if empty
                'image' => $filename
            ]);
    
            return redirect()->route('admin.feedback.feedbackchanger')->with('success', 'Feedback added successfully!');
        } catch (\Exception $e) {
            \Log::error('Feedback Store Error: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while saving feedback.');
        }
    }
    
    
    
    

    public function destroy($id)
    {
        $feedback = Feedback::findOrFail($id);

        // Check if image exists before deleting
        if ($feedback->image && file_exists(public_path('uploads/' . $feedback->image))) {
            unlink(public_path('uploads/' . $feedback->image));
        }

        $feedback->delete();

        return redirect()->route('admin.feedback.feedbackchanger')->with('success', 'Feedback deleted successfully!');
    }

    public function edit($id)
    {
        $feedback = Feedback::findOrFail($id);
        return view('admin.feedback.editfeedback', compact('feedback'));
    }

    public function update(Request $request, $id)
{
    // Validate the request
    $request->validate([
        'name' => 'required|string|max:255',
        'position' => 'required|string|max:255',
        'message' => 'required|string',
        'interview_date' => 'nullable|date',
        'client_info' => 'nullable|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);

    // Find the feedback entry
    $feedback = Feedback::findOrFail($id);
    $filename = $feedback->image;

    // Handle image upload
    if ($request->hasFile('image')) {
        // Delete old image if it exists
        if ($filename && file_exists(public_path('uploads/' . $filename))) {
            unlink(public_path('uploads/' . $filename));
        }

        $file = $request->file('image');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads'), $filename);
    }

    // Update feedback data
    $feedback->update([
        'name' => $request->name,
        'position' => $request->position,
        'message' => $request->message,
        'interview_date' => $request->interview_date ?? null, // Ensures NULL if empty
        'client_info' => $request->client_info ?? null, // Ensures NULL if empty
        'image' => $filename
    ]);

    return redirect()->route('admin.feedback.feedbackchanger')->with('success', 'Feedback updated successfully!');
}

}
