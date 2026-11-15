<?php
namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\SupplementaryExam;
use App\Models\UnitRegistration;
use Illuminate\Http\Request;

class SupplementaryExamController extends Controller
{
    public function index(Request $request)
    {
        $student = $request->user()->student;
        
        // Find units the student registered for but FAILED (Grade E)
        $failedUnits = UnitRegistration::with(['unit', 'result'])
            ->where('student_id', $student->id)
            ->whereHas('result', function($q) {
                $q->where('grade', 'E');
            })->get();

        $applications = SupplementaryExam::with('unit')->where('student_id', $student->id)->get();

        return view('student.supplementary.index', compact('failedUnits', 'applications'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'unit_id' => 'required|exists:units,id',
            'reason' => 'nullable|string'
        ]);

        SupplementaryExam::create([
            'student_id' => $request->user()->student->id,
            'unit_id' => $request->unit_id,
            'type' => 'supp',
            'reason' => $request->reason,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Supplementary exam application submitted successfully.');
    }
}