<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TimetableSlot;
use App\Models\Unit;
use Illuminate\Http\Request;

class TimetableController extends Controller
{
    public function index()
    {
        $slots = TimetableSlot::with('unit')->get();
        $units = Unit::all();
        return view('admin.timetable.index', compact('slots', 'units'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'unit_id' => 'required|exists:units,id',
            'day_of_week' => 'required|string',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'venue' => 'required|string',
        ]);

        TimetableSlot::create($request->all());
        return back()->with('success', 'Timetable slot added!');
    }
}