<?php

namespace App\Http\Controllers\SchoolSuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommunicationController extends Controller
{
    /**
     * Display the Email/SMS composer page.
     */
    public function index()
    {
        $activeMenus = [14]; // ID for Communication menu
        $school = Auth::user()->school;

        // Get all data needed for the recipient dropdowns
        $branches = $school->branches()->with(['classes.sections'])->where('status', 'active')->get();
        
        // Define the target groups
        $recipientGroups = [
            'all_students' => 'All Students',
            'all_teachers' => 'All Teachers',
            'all_parents' => 'All Parents',
        ];

        return view('school-superadmin.communication.email-sms.index', compact(
            'branches', 
            'recipientGroups', 
            'activeMenus'
        ));
    }

    /**
     * Send the email/SMS.
     * We will build this logic in a future step after creating the settings page.
     */
    public function send(Request $request)
    {
        // For now, we will just validate and redirect with a "demo" message.
        // The actual sending logic will be added here later.
        $request->validate([
            'recipient_group' => 'required|string',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        return redirect()->route('school-superadmin.communication.index')
                         ->with('success', 'Message sent successfully (DEMO).');
    }
}