<?php
namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Semester;
use Illuminate\Http\Request;

class TimetableController extends Controller
{
    
    public function index(Request $request)
    {
        $student = $request->user()->student;
        $semester = Semester::current();

        // Get the units the student is registered for
        $registeredUnitIds = $student->unitRegistrations()
            ->where('semester_id', $semester->id)
            ->pluck('unit_id')
            ->toArray();

        // Fetch the slots
        $slots = \App\Models\TimetableSlot::with('unit')
            ->whereIn('unit_id', $registeredUnitIds)
            ->get();

        // Sort them in PHP (works on both SQLite and MySQL)
        $daysOrder = ['Monday' => 1, 'Tuesday' => 2, 'Wednesday' => 3, 'Thursday' => 4, 'Friday' => 5, 'Saturday' => 6, 'Sunday' => 7];
        
        $slots = $slots->sortBy(function ($slot) use ($daysOrder) {
            return $daysOrder[$slot->day_of_week] . $slot->start_time;
        });

        return view('student.timetable.index', compact('slots'));
    }

} 