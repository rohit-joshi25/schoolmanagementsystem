<?php

namespace App\Http\Controllers\SchoolSuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class NoticeController extends Controller
{
    /**
     * Display a listing of the notices.
     */
    public function index()
    {
        $activeMenus = [14]; // ID for Communication menu
        $school = Auth::user()->school;
        
        $notices = $school->notices()->latest()->get();

        return view('school-superadmin.communication.notice-board.index', compact('notices', 'activeMenus'));
    }

    /**
     * Show the form for creating a new notice.
     */
    public function create()
    {
        $activeMenus = [14];
        return view('school-superadmin.communication.notice-board.create', compact('activeMenus'));
    }

    /**
     * Store a newly created notice in storage.
     */
    public function store(Request $request)
    {
        $school = Auth::user()->school;

        $validatedData = $request->validate([
            'title' => ['required', 'string', 'max:255', Rule::unique('notices')->where('school_id', $school->id)],
            'body' => 'required|string',
            'publish_date' => 'required|date',
            'is_published' => 'nullable|boolean',
        ]);

        $validatedData['is_published'] = $request->has('is_published');

        $school->notices()->create($validatedData);

        return redirect()->route('school-superadmin.notices.index')
                         ->with('success', 'Notice created successfully.');
    }

    /**
     * Show the form for editing the specified notice.
     */
    public function edit(Notice $notice)
    {
        // Security Check
        if ($notice->school_id !== Auth::user()->school_id) {
            abort(403);
        }

        $activeMenus = [14];
        return view('school-superadmin.communication.notice-board.edit', compact('notice', 'activeMenus'));
    }

    /**
     * Update the specified notice in storage.
     */
    public function update(Request $request, Notice $notice)
    {
        // Security Check
        if ($notice->school_id !== Auth::user()->school_id) {
            abort(403);
        }

        $school = Auth::user()->school;
        $validatedData = $request->validate([
            'title' => ['required', 'string', 'max:255', Rule::unique('notices')->where('school_id', $school->id)->ignore($notice->id)],
            'body' => 'required|string',
            'publish_date' => 'required|date',
            'is_published' => 'nullable|boolean',
        ]);
        
        $validatedData['is_published'] = $request->has('is_published');

        $notice->update($validatedData);

        return redirect()->route('school-superadmin.notices.index')
                         ->with('success', 'Notice updated successfully.');
    }

    /**
     * Remove the specified notice from storage.
     */
    public function destroy(Notice $notice)
    {
        // Security Check
        if ($notice->school_id !== Auth::user()->school_id) {
            abort(403);
        }
        
        $notice->delete();

        return redirect()->route('school-superadmin.notices.index')
                         ->with('success', 'Notice deleted successfully.');
    }
}