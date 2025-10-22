<?php

namespace App\Http\Controllers\SchoolSuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\CertificateTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CertificateController extends Controller
{
    /**
     * Display a listing of the certificate templates.
     */
    public function index()
    {
        $activeMenus = [3]; // ID for Students menu
        $school = Auth::user()->school;
        $templates = $school->certificateTemplates()->latest()->get();

        return view('school-superadmin.academics.certificates.index', compact('templates', 'activeMenus'));
    }

    /**
     * Show the form for creating a new certificate template.
     */
    public function create()
    {
        $activeMenus = [3];
        return view('school-superadmin.academics.certificates.create', compact('activeMenus'));
    }

    /**
     * Store a newly created certificate template.
     */
    public function store(Request $request)
    {
        $school = Auth::user()->school;

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('certificate_templates')->where('school_id', $school->id)],
            'body' => 'required|string',
        ]);

        $school->certificateTemplates()->create($validatedData);

        return redirect()->route('school-superadmin.certificates.index')
                         ->with('success', 'Certificate template created successfully.');
    }

    /**
     * Show the form for editing the specified certificate template.
     */
    public function edit(CertificateTemplate $certificate)
    {
        // Security Check
        if ($certificate->school_id !== Auth::user()->school_id) {
            abort(403);
        }

        $activeMenus = [3];
        return view('school-superadmin.academics.certificates.edit', compact('certificate', 'activeMenus'));
    }

    /**
     * Update the specified certificate template.
     */
    public function update(Request $request, CertificateTemplate $certificate)
    {
        // Security Check
        if ($certificate->school_id !== Auth::user()->school_id) {
            abort(403);
        }

        $school = Auth::user()->school;

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('certificate_templates')->where('school_id', $school->id)->ignore($certificate->id)],
            'body' => 'required|string',
        ]);

        $certificate->update($validatedData);

        return redirect()->route('school-superadmin.certificates.index')
                         ->with('success', 'Certificate template updated successfully.');
    }

    /**
     * Remove the specified certificate template.
     */
    public function destroy(CertificateTemplate $certificate)
    {
        // Security Check
        if ($certificate->school_id !== Auth::user()->school_id) {
            abort(403);
        }
        
        $certificate->delete();

        return redirect()->route('school-superadmin.certificates.index')
                         ->with('success', 'Certificate template deleted successfully.');
    }
}