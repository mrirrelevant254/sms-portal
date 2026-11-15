<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Semester;
use App\Services\PdfService;
use Illuminate\Http\Request;

class FeeController extends Controller
{
    public function statement(Request $request)
    {
        $student = $request->user()->student;
        $semester = Semester::current();

        // Get all invoices and their associated payments
        $invoices = $student->invoices()
            ->with('payments')
            ->where('semester_id', $semester->id)
            ->get();

        $totalBilled = $invoices->sum('total');
        $totalPaid = $invoices->flatMap->payments->where('status', 'success')->sum('amount');
        $balance = $totalBilled - $totalPaid;

        return view('student.finances.statement', compact('invoices', 'totalBilled', 'totalPaid', 'balance', 'semester'));
    }

    public function downloadStatement(Request $request, PdfService $pdfService)
    {
        $student = $request->user()->student;
        $semester = Semester::current();

        return $pdfService->generateFeeStatement($student, $semester);
    }
}