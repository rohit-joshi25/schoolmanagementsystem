<?php

namespace App\Http\Controllers\SchoolSuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\SchoolSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommunicationSettingsController extends Controller
{
    /**
     * Display the communication settings page.
     */
    public function index()
    {
        $activeMenus = [14]; // ID for Communication menu
        $school = Auth::user()->school;

        // Get all settings from the database, or create them if they don't exist
        $settings = $school->settings()->pluck('value', 'key');

        $mail_host = $settings->get('mail_host');
        $mail_port = $settings->get('mail_port');
        $mail_username = $settings->get('mail_username');
        $mail_password = $settings->get('mail_password');
        $mail_encryption = $settings->get('mail_encryption', 'tls');
        $mail_from_address = $settings->get('mail_from_address');
        $mail_from_name = $settings->get('mail_from_name');

        return view('school-superadmin.communication.settings.index', compact(
            'activeMenus', 'mail_host', 'mail_port', 'mail_username', 
            'mail_password', 'mail_encryption', 'mail_from_address', 'mail_from_name'
        ));
    }

    /**
     * Update the communication settings.
     */
    public function update(Request $request)
    {
        $school = Auth::user()->school;

        // Validate all the form fields
        $validatedData = $request->validate([
            'mail_host' => 'nullable|string',
            'mail_port' => 'nullable|integer',
            'mail_username' => 'nullable|string',
            'mail_password' => 'nullable|string',
            'mail_encryption' => 'nullable|string|in:tls,ssl',
            'mail_from_address' => 'nullable|email',
            'mail_from_name' => 'nullable|string',
            // Add validation for Twilio and WhatsApp keys here later
        ]);

        // Loop through and save each setting
        foreach ($validatedData as $key => $value) {
            if ($value !== null) { // Only save if a value was provided
                $school->settings()->updateOrCreate(
                    ['key' => $key],
                    ['value' => $value]
                );
            }
        }

        return redirect()->route('school-superadmin.communication-settings.index')
                         ->with('success', 'Communication settings updated successfully.');
    }
}