<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImpersonateController extends Controller
{
    /**
     * Start impersonating the admin of a specific school.
     */
    public function start(School $school)
    {
        // Find the first user with the 'admin' role associated with this school.
        $adminToImpersonate = User::where('school_id', $school->id)
                                  ->where('role', 'admin')
                                  ->first();

        // If no admin exists for this school, redirect back with an error.
        if (!$adminToImpersonate) {
            return redirect()->route('superadmin.schools.index')
                             ->with('error', 'No admin user found for this school to impersonate.');
        }

        // Store the current superadmin's ID in the session.
        session(['impersonating_by_superadmin' => Auth::id()]);

        // Log in as the school's admin.
        Auth::login($adminToImpersonate);

        // Redirect to the admin dashboard.
        return redirect()->route('admin.dashboard');
    }

    /**
     * Stop impersonating and return to the superadmin account.
     */
    public function stop()
    {
        // Log in as the original superadmin using the ID from the session.
        Auth::loginUsingId(session('impersonating_by_superadmin'));

        // Forget the session variable.
        session()->forget('impersonating_by_superadmin');

        // Redirect back to the superadmin school list.
        return redirect()->route('superadmin.schools.index')
                         ->with('success', 'Stopped impersonating and returned to your account.');
    }
}
