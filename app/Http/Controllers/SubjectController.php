<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Models\Subject;

class SubjectController extends Controller
{
    use ValidatesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all subjects from the database
        $subjects = Subject::where('archive_status', 1)->paginate(10);

        // Return the view with the subjects data
        return view('admin.subjects', compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'subject_code' => 'required',
            'subject_name' => 'required',
            'subject_units' => 'required',
        ]);

        $subjects = new Subject();
        $subjects->subject_code = $request->input('subject_code');
        $subjects->subject_name = $request->input('subject_name');
        $subjects->units = $request->input('subject_units');

        $subjects->save();

        return redirect('/admin/subjects')->with('success', 'Subject Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            // Find the subject by ID
            $subject = Subject::findOrFail($id);

            // Validate the request data
            $validated = $request->validate([
                'subject_code' => 'required|string|max:255',
                'subject_name' => 'required|string|max:255',
                'subject_units' => 'required|integer|min:1',
            ]);

            // Check if anything has changed before updating
            $isUpdated = false;

            // Check each field and compare with the current subject values
            if ($subject->subject_code !== $validated['subject_code']) {
                $subject->subject_code = $validated['subject_code'];
                $isUpdated = true;
            }
            if ($subject->subject_name !== $validated['subject_name']) {
                $subject->subject_name = $validated['subject_name'];
                $isUpdated = true;
            }
            if ($subject->units !== (int) $validated['subject_units']) {
                $subject->units = (int) $validated['subject_units']; // Make sure units is cast to integer
                $isUpdated = true;
            }

            // If nothing was updated, set a warning session message
            if (!$isUpdated) {
                return redirect()->route('subjects.index')
                    ->with('warning', 'No changes were made to the subject.');
            }

            // Save the changes to the database
            $subject->save();

            // Redirect back to the subjects list with a success message
            return redirect()->route('subjects.index')
                ->with('success', 'Subject updated successfully!');
        } catch (\Exception $e) {
            // In case of any error, set an error session message
            return redirect()->route('subjects.index')
                ->with('error', 'An error occurred while updating the subject: ' . $e->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function remove($id, Request $request)
    {
        $subject = Subject::findOrFail($id); // Find the subject by ID

        $subject->archive_status = 0; // Set archive_status to 0 (mark as removed)
        $subject->save(); // Save changes

        return response()->json(['success' => true]); // Send success response
    }
}
