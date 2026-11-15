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

        // Find units for the student's programme, year, and semester
        $availableUnits = Unit::where('programme_id', $student->programme_id)
            ->where('year_no', $student->year_of_study)
            // ->where('semester_no', $student->semester_of_study) // <-- Temporarily commented out
            ->get();

        // Find IDs of units the student has already registered for
        $registeredUnitIds = $student->unitRegistrations()
            ->where('semester_id', $semester->id)
            ->pluck('unit_id')
            ->toArray();

        return view('student.units.index', compact('availableUnits', 'registeredUnitIds', 'semester'));
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