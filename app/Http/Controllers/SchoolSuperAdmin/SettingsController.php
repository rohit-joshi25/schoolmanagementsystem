<?php

namespace App\Http\Controllers\SchoolSuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function index()
    {
        $activeMenus = [];
        return view('school-superadmin.settings.index', compact('activeMenus'));
    }

    public function updateLogo(Request $request)
{
    $request->validate([
        'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $school = Auth::user()->school;

    if (!$school) {
        return back()->with('error', 'You are not associated with a school.');
    }

    if ($school->logo_path) {
        Storage::disk('public')->delete($school->logo_path);
    }

    // This correctly saves the file inside "storage/app/public/logos"
    $path = $request->file('logo')->store('logos', 'public');

    $school->update(['logo_path' => $path]);

    return back()->with('success', 'Logo updated successfully.');
}
}
