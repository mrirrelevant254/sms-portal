<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Semester;
use App\Services\PdfService;
use Illuminate\Http\Request;

class TranscriptController extends Controller
{
    public function show(Request $request)
    {
        $student = $request->user()->student;

        // Load ALL registrations, then filter in PHP so we don't rely on whereHas
        $allRegistrations = $student->unitRegistrations()
            ->with(['unit', 'result', 'semester'])
            ->get();

        // Only keep registrations that actually have a result record
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

        return view('student.transcript.index', compact('student', 'registrations', 'gpa'));
    }
    public function download(Request $request, PdfService $pdfService)
    {
        $student = $request->user()->student;
        return $pdfService->generateTranscript($student);
    }
}