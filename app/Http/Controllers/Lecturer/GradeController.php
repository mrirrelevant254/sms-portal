<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use App\Models\UnitRegistration;
use App\Models\Result;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function index()
    {
        // For this demo, let's show ALL registrations to the lecturer
        $registrations = UnitRegistration::with(['student', 'unit'])->get();
        return view('lecturer.grades.index', compact('registrations'));
    }

    public function store(Request $request, UnitRegistration $registration)
    {
        $request->validate([
            'cat_mark' => 'required|numeric|min:0|max:30',
            'exam_mark' => 'required|numeric|min:0|max:70',
        ]);

        $total = $request->cat_mark + $request->exam_mark;

        // Simple grading scale (Blueprint Section 3.4)
        if ($total >= 70) $grade = 'A';
        elseif ($total >= 60) $grade = 'B';
        elseif ($total >= 50) $grade = 'C';
        elseif ($total >= 40) $grade = 'D';
        else $grade = 'E';

        Result::updateOrCreate(
            ['unit_registration_id' => $registration->id],
            [
                'cat_mark' => $request->cat_mark,
                'exam_mark' => $request->exam_mark,
                'total' => $total,
                'grade' => $grade,
            ]
        );

        return back()->with('success', 'Grade saved for ' . $registration->student->full_name);
    }
}