<?php

namespace App\Http\Controllers\SchoolSuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\CertificateTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\Section;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage; // Make sure this is imported

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
    public function transferCertificate()
    {
        $activeMenus = [15]; // ID for Certificates menu
        $school = Auth::user()->school;

        // Get branches to populate the student selector dropdowns
        $branches = $school->branches()->with(['classes.sections'])->where('status', 'active')->get();

        return view('school-superadmin.certificates.transfer.index', compact(
            'activeMenus',
            'branches'
        ));
    }

    /**
     * Show the ID Card generator page.
     */
    public function idCard()
    {
        $activeMenus = [15];
        return redirect()->route('school-superadmin.certificates.transfer-certificate')
            ->with('info', 'ID Card module not yet built.');
    }

    /**
     * Show the Custom Certificate generator page.
     */
    public function customCertificate()
    {
        $activeMenus = [15];
        return redirect()->route('school-superadmin.certificates.transfer-certificate')
            ->with('info', 'Custom Certificate module not yet built.');
    }

    public function getStudentsBySection(Section $section)
    {
        // Security check: ensure this section belongs to the authenticated school
        if ($section->school_class->branch->school_id !== Auth::user()->school_id) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        $students = $section->students()
            ->select('id', 'first_name', 'last_name', 'roll_number')
            ->get();

        return response()->json($students);
    }

    /**
     * Show the form to prepare/edit the transfer certificate details.
     */
    public function prepareTransferCertificate(User $student)
    {
        $school = Auth::user()->school;

        // ** THE FIX: Add safe, step-by-step security checks **

        // Check 1: Does the student have a section assigned?
        if (!$student->section) {
            abort(403, 'Student data is incomplete. Please assign a section to this student first.');
        }

        // Check 2: Does the section have a class?
        if (!$student->section->school_class) {
            abort(403, 'Student data is incomplete. The assigned section is not linked to a class.');
        }

        // Check 3: Does the class have a branch?
        if (!$student->section->school_class->branch) {
            abort(403, 'Student data is incomplete. The assigned class is not linked to a branch.');
        }

        // Check 4: Does this student actually belong to this school?
        if ($student->section->school_class->branch->school_id !== $school->id) {
            abort(403, 'This student does not belong to your school.');
        }

        // Pass the student and school data to the preparation form
        return view('school-superadmin.certificates.transfer.prepare', compact('student', 'school'));
    }

    /**
     * Generate and download the final transfer certificate PDF from form data.
     */
    public function downloadTransferCertificate(Request $request)
    {
        $school = Auth::user()->school;

        // Validate all the data coming from the preparation form
        $validatedData = $request->validate([
            'student_id' => 'required|exists:users,id',
            'student_name' => 'required|string',
            'date_of_birth' => 'required|date',
            'guardian_name' => 'required|string',
            'class_name' => 'required|string',
            'section_name' => 'required|string',
            'admission_date' => 'required|date',
            'issue_date' => 'required|date',
            'character_conduct' => 'required|string',
            'reason_for_leaving' => 'required|string|max:255',
            'promotion_status' => 'required|string|max:255',
            'dues_cleared' => 'required|string|max:255',
            'general_remarks' => 'nullable|string',
        ]);

        // Security check: ensure the student ID from the form belongs to this school
        $student = User::where('id', $validatedData['student_id'])
            ->where('school_id', $school->id)
            ->firstOrFail();

        // Add student's admission number to the data
        $validatedData['admission_no'] = $student->admission_no;

        // ** END OF FIX **


        // Read the image file and convert it to Base64
        $logoData = null;
        if ($school->logo_path && Storage::disk('public')->exists($school->logo_path)) {
            $logoPath = Storage::disk('public')->path($school->logo_path);
            $logoType = pathinfo($logoPath, PATHINFO_EXTENSION);
            $logoData = 'data:image/' . $logoType . ';base64,' . base64_encode(file_get_contents($logoPath));
        }

        // Data for the PDF
        $data = [
            'certificate_data' => $validatedData, // Use the validated data from the form
            'school' => $school,
            'logo_base64' => $logoData, // Pass the Base64 data to the view
        ];

        // Load the PDF view
        $pdf = Pdf::loadView('school-superadmin.certificates.templates.transfer-certificate', $data);

        // (Optional) Set paper size and orientation
        $pdf->setPaper('a4', 'portrait');

        // Stream the PDF to the browser
        return $pdf->stream('transfer-certificate-' . str_replace(' ', '-', $validatedData['student_name']) . '.pdf');
    }
}
