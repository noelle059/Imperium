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
    public function index(Request $request)
    {
        $query = Subject::where('archive_status', 1);

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('subject_code', 'like', "%$search%")
                    ->orWhere('subject_name', 'like', "%$search%")
                    ->orWhere('units', 'like', "%$search%");
            });
        }

        $subjects = $query->paginate(10)->appends(['search' => $request->input('search')]);

        if ($request->ajax()) {
            return view('admin.subjects', compact('subjects'))->render();
        }

        return view('admin.subjects', compact('subjects'));
    }

    public function getSubjectUnits($id)
    {
        $subject = Subject::find($id);

        if ($subject) {
            return response()->json(['units' => $subject->units]);
        }

        return response()->json(['units' => null], 404);
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
        // Validate the incoming request
        $this->validate($request, [
            'subject_code' => 'required',
            'subject_name' => 'required',
            'subject_units' => 'required',
        ]);

        // Check if a subject with the same subject code already exists
        $existingSubject = Subject::where('subject_code', $request->input('subject_code'))->first();

        if ($existingSubject) {
            return redirect()->back()->with('error', 'A subject with this code already exists.');
        }

        // Create and save the new subject
        $subject = new Subject();
        $subject->subject_code = $request->input('subject_code');
        $subject->subject_name = $request->input('subject_name');
        $subject->units = $request->input('subject_units');

        $subject->save();

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

            // Check if the subject_code has changed and if the new subject_code already exists in another subject
            if ($subject->subject_code !== $validated['subject_code']) {
                $existingSubject = Subject::where('subject_code', $validated['subject_code'])->first();
                if ($existingSubject) {
                    return redirect()->back()->with('error', 'A subject with this code already exists.');
                }
                $subject->subject_code = $validated['subject_code'];
            }

            // Check if subject name or units have changed and update them
            if ($subject->subject_name !== $validated['subject_name']) {
                $subject->subject_name = $validated['subject_name'];
            }
            if ($subject->units !== (int) $validated['subject_units']) {
                $subject->units = (int) $validated['subject_units']; // Ensure units is an integer
            }

            // Save the updated subject
            $subject->save();

            // Redirect with a success message
            return redirect()->route('subjects.index')->with('success', 'Subject updated successfully!');
        } catch (\Exception $e) {
            // In case of an error, return with an error message
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
