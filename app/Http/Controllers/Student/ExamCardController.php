<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Semester;
use App\Models\Payment;
use App\Services\PdfService;
use Illuminate\Http\Request;

class ExamCardController extends Controller
{
    public function show(Request $request)
    {
        $student = $request->user()->student;
        $semester = Semester::current();

        $billed = $student->invoices()->where('semester_id', $semester->id)->sum('total');
        $paid = Payment::whereIn('invoice_id', $student->invoices()->pluck('id'))
            ->where('status', 'success')->sum('amount');
        $balance = $billed - $paid;

        $isCleared = $balance <= 0;
        $units = $student->unitRegistrations()->with('unit')->where('semester_id', $semester->id)->get();

        return view('student.exam-card.index', compact('student', 'semester', 'units', 'balance', 'isCleared'));
    }

    public function download(Request $request, PdfService $pdfService)
    {
        $student = $request->user()->student;
        $semester = Semester::current();

        $billed = $student->invoices()->where('semester_id', $semester->id)->sum('total');
        $paid = Payment::whereIn('invoice_id', $student->invoices()->pluck('id'))
            ->where('status', 'success')->sum('amount');
        
        if (($billed - $paid) > 0) {
            return back()->with('error', 'You cannot download the exam card. You have an outstanding fee balance of KES ' . number_format($billed - $paid, 2));
        }

        return $pdfService->generateExamCard($student, $semester);
    }
}