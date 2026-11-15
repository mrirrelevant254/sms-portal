<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Semester;
use App\Models\Unit;
use Illuminate\Http\Request;

class UnitRegistrationController extends Controller
{
    public function index(Request $request)
    {
        $student = $request->user()->student;
        $semester = Semester::current();

        // Find units for the student's specific programme, year, and semester of study
        $availableUnits = Unit::where('programme_id', $student->programme_id)
            ->where('year_no', $student->year_of_study)
            ->where('semester_no', $student->semester_of_study)
            ->get();

        // Check which ones the student has already registered for
        $registeredUnitIds = $student->unitRegistrations()
            ->where('semester_id', $semester->id)
            ->pluck('unit_id')
            ->toArray();

        // Pass the student's semester to the view instead of the system semester
        return view('student.units.index', [
            'availableUnits' => $availableUnits,
            'registeredUnitIds' => $registeredUnitIds,
            'semester' => $semester,
            'studentSemester' => $student->semester_of_study, // Add this
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'unit_ids' => 'required|array',
            'unit_ids.*' => 'exists:units,id'
        ]);

        $student = $request->user()->student;
        $semester = Semester::current();

        foreach ($request->unit_ids as $unitId) {
            $student->unitRegistrations()->firstOrCreate([
                'unit_id' => $unitId,
                'semester_id' => $semester->id,
            ], [
                'status' => 'registered'
            ]);
        }

        return redirect()->route('student.units.index')->with('success', 'Units registered successfully!');
    }
}