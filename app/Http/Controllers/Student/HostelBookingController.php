<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Hostel;
use App\Models\HostelBooking;
use App\Models\Room;
use App\Models\Semester;
use Illuminate\Http\Request;

class HostelBookingController extends Controller
{
    public function index(Request $request)
    {
        $student = $request->user()->student;
        $semester = Semester::current();
        
        $hostels = Hostel::with('rooms')->get();
        
        // Check if the student already has a booking for this semester
        $currentBooking = HostelBooking::with('room.hostel')
            ->where('student_id', $student->id)
            ->where('semester_id', $semester->id)
            ->first();

        return view('student.hostel.index', compact('hostels', 'currentBooking', 'semester'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id'
        ]);

        $student = $request->user()->student;
        $semester = Semester::current();
        $room = Room::findOrFail($request->room_id);

        // 1. Check if student already booked
        if (HostelBooking::where('student_id', $student->id)->where('semester_id', $semester->id)->exists()) {
            return back()->with('error', 'You have already booked a room for this semester.');
        }

        // 2. Check if room is full
        if ($room->isFull()) {
            return back()->with('error', 'This room is already full.');
        }

        // 3. Create the booking
        HostelBooking::create([
            'student_id' => $student->id,
            'room_id' => $room->id,
            'semester_id' => $semester->id,
            'status' => 'confirmed', // Auto-confirming for demo. In production, it might be 'pending' until paid.
            'booked_at' => now(),
        ]);

        // 4. Automatically generate a hostel invoice! (Integrates with Finance module)
        $invoice = $student->invoices()->firstOrCreate(
            ['semester_id' => $semester->id],
            ['total' => 0, 'status' => 'unpaid'] // Get existing, or create new with 0
        );
        
        // Add the hostel fee to the invoice
        $invoice->increment('total', $room->fee);

        return redirect()->route('student.hostel.index')->with('success', "Room {$room->room_no} booked successfully! KES " . number_format($room->fee) . " has been added to your fee statement.");
    }
}