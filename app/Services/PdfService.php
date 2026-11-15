<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Student;
use App\Models\Semester;

class PdfService
{
    public function generateFeeStatement(Student $student, Semester $semester)
    {
        $invoices = $student->invoices()
            ->with('payments')
            ->where('semester_id', $semester->id)
            ->get();

        $totalBilled = $invoices->sum('total');
        $totalPaid = $invoices->flatMap->payments->where('status', 'success')->sum('amount');
        $balance = $totalBilled - $totalPaid;

        $data = compact('student', 'semester', 'invoices', 'totalBilled', 'totalPaid', 'balance');

        $pdf = Pdf::loadView('pdf.fee-statement', $data);

        $safeRegNo = str_replace('/', '-', $student->reg_no);
        return $pdf->download("Fee_Statement_{$safeRegNo}.pdf");
    }

    public function generateExamCard(Student $student, Semester $semester)
    {
        $units = $student->unitRegistrations()
            ->with('unit')
            ->where('semester_id', $semester->id)
            ->get();

        $pdf = Pdf::loadView('pdf.exam-card', compact('student', 'semester', 'units'));
        return $pdf->download("Exam_Card_" . str_replace('/', '-', $student->reg_no) . ".pdf");
    }

    public function generateTranscript(Student $student)
    {
        $allRegistrations = $student->unitRegistrations()
            ->with(['unit', 'result', 'semester'])
            ->get();

        $registrations = $allRegistrations->filter(function ($reg) {
            return $reg->result !== null;
        });

        $gradePoints = ['A' => 4, 'B' => 3, 'C' => 2, 'D' => 1, 'E' => 0];
        $totalPoints = 0;
        $totalUnits = 0;
        foreach ($registrations as $reg) {
            $totalPoints += $gradePoints[$reg->result->grade] ?? 0;
            $totalUnits += 1;
        }
        $gpa = $totalUnits > 0 ? round($totalPoints / $totalUnits, 2) : 0;

        $pdf = Pdf::loadView('pdf.transcript', compact('student', 'registrations', 'gpa'));
        return $pdf->download("Transcript_" . str_replace('/', '-', $student->reg_no) . ".pdf");
    }
}