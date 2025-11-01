<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Card - {{ $student->full_name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f9fafb; color: #1f2937; }
        @media print {
            .no-print { display: none !important; }
            body { -webkit-print-color-adjust: exact; background: white; }
            .shadow-2xl, .shadow-lg { box-shadow: none !important; }
        }
    </style>
</head>
<body>
    <div class="max-w-5xl mx-auto my-12 bg-white shadow-2xl rounded-lg overflow-hidden border border-gray-200 print:border-none">

        <!-- Header -->
        <div class="flex justify-between items-center border-b border-gray-200 px-10 py-6">
            <div class="flex items-center gap-4">
                @if (Auth::user()->school->logo_path)
                    <img src="{{ asset('storage/' . Auth::user()->school->logo_path) }}" alt="School Logo" class="h-16 w-auto object-contain">
                @endif
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-800 leading-tight">{{ Auth::user()->school->name }}</h1>
                    <p class="text-gray-500 text-sm mt-1">{{ $student->branch->name ?? 'Main Branch' }}</p>
                </div>
            </div>
            <div class="text-right">
                <h2 class="text-2xl font-semibold text-blue-700">{{ $exam->name }}</h2>
                <p class="text-gray-500 text-sm">Academic Session: 2025–26</p>
            </div>
        </div>

        <!-- Student Information -->
        <div class="px-10 py-6 bg-gray-50 grid grid-cols-3 gap-6 text-sm">
            <div>
                <span class="block text-gray-500 uppercase text-xs">Student Name</span>
                <span class="font-semibold text-gray-800">{{ $student->full_name }}</span>
            </div>
            <div>
                <span class="block text-gray-500 uppercase text-xs">Class & Section</span>
                <span class="font-semibold text-gray-800">{{ $student->academicClass->name ?? 'N/A' }} - {{ $student->section->name ?? 'N/A' }}</span>
            </div>
            <div>
                <span class="block text-gray-500 uppercase text-xs">Roll Number</span>
                <span class="font-semibold text-gray-800">{{ $student->roll_number ?? 'N/A' }}</span>
            </div>
            <div>
                <span class="block text-gray-500 uppercase text-xs">Admission No.</span>
                <span class="font-semibold text-gray-800">{{ $student->admission_no ?? 'N/A' }}</span>
            </div>
            <div>
                <span class="block text-gray-500 uppercase text-xs">Date of Birth</span>
                <span class="font-semibold text-gray-800">{{ \Carbon\Carbon::parse($student->date_of_birth)->format('d M, Y') }}</span>
            </div>
            <div>
                <span class="block text-gray-500 uppercase text-xs">Guardian Name</span>
                <span class="font-semibold text-gray-800">{{ $student->guardian_name ?? 'N/A' }}</span>
            </div>
        </div>

        <!-- Marks Table -->
        <div class="px-10 py-6">
            <div class="overflow-x-auto border border-gray-200 rounded-lg">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-blue-50">
                        <tr>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700 uppercase tracking-wider">Subject</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700 uppercase tracking-wider">Total Marks</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700 uppercase tracking-wider">Marks Obtained</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700 uppercase tracking-wider">Grade</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700 uppercase tracking-wider">Remarks</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse ($marksWithGrades as $mark)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-3 font-medium text-gray-800">{{ $mark->subject->name ?? 'N/A' }}</td>
                                <td class="px-6 py-3 text-gray-600">{{ number_format($mark->total_marks, 0) }}</td>
                                <td class="px-6 py-3 font-semibold text-gray-900">{{ number_format($mark->marks_obtained, 2) }}</td>
                                <td class="px-6 py-3 font-bold text-blue-700">{{ $mark->grade->grade_name ?? 'N/A' }}</td>
                                <td class="px-6 py-3 text-gray-600">{{ $mark->grade->comments ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">No marks have been entered for this student.</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot class="bg-gray-50 font-semibold">
                        <tr>
                            <td class="px-6 py-3 text-right text-gray-700">Total:</td>
                            <td class="px-6 py-3 text-gray-800">{{ number_format($totalMaxMarks, 0) }}</td>
                            <td class="px-6 py-3 text-gray-800">{{ number_format($totalMarksObtained, 2) }}</td>
                            <td colspan="2"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Summary Section -->
        <div class="grid grid-cols-3 gap-6 px-10 pb-10">
            <div class="p-4 bg-blue-50 border border-blue-100 rounded-lg text-center">
                <p class="text-gray-600 text-sm">Percentage</p>
                <p class="text-3xl font-bold text-gray-900">{{ number_format($percentage, 2) }}%</p>
            </div>
            <div class="p-4 bg-blue-50 border border-blue-100 rounded-lg text-center">
                <p class="text-gray-600 text-sm">Overall Grade</p>
                <p class="text-3xl font-bold text-blue-700">{{ $overallGrade->grade_name ?? 'N/A' }}</p>
            </div>
            <div class="p-4 bg-blue-50 border border-blue-100 rounded-lg text-center">
                <p class="text-gray-600 text-sm">Final Result</p>
                <p class="text-3xl font-bold text-green-600">{{ $overallGrade->comments ?? 'N/A' }}</p>
            </div>
        </div>

        <!-- Footer / Signature Area -->
        <div class="border-t border-gray-200 px-10 py-6 text-sm text-gray-600 flex justify-between items-center">
            <div>
                <p class="font-medium text-gray-700">Class Teacher’s Signature</p>
                <div class="mt-6 border-b border-gray-400 w-48"></div>
            </div>
            <div>
                <p class="font-medium text-gray-700">Principal’s Signature</p>
                <div class="mt-6 border-b border-gray-400 w-48"></div>
            </div>
        </div>

        <!-- Print Button -->
        <div class="py-6 text-center bg-gray-50 border-t border-gray-200 no-print">
            <button onclick="window.print()" 
                class="inline-flex items-center px-8 py-3 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 transition">
                Print Report Card
            </button>
        </div>
    </div>
</body>
</html>
