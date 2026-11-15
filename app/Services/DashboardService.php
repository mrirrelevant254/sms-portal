<?php

namespace App\Services;

use App\Models\Semester;
use App\Models\Student;
use App\Models\Payment;

class DashboardService
{
    public function forStudent(Student $s): array
    {
        $sem = Semester::current();
        
        $billed = $s->invoices()->where('semester_id', $sem?->id)->sum('total');
        
        $paid = Payment::whereIn('invoice_id', $s->invoices()->pluck('id'))
            ->where('status', 'success')->sum('amount');
            
        $balance = $billed - $paid;

        return [
            'student' => $s,
            'stage' => "Y{$s->year_of_study}S{$s->semester_of_study}",
            'semester' => $sem ? "Semester {$sem->semester_no} {$sem->academic_year}" : 'No active semester',
            'billed' => $billed,
            'paid' => $paid,
            'paid_pct' => $billed ? round($paid / $billed * 100, 2) : 0,
            'balance' => $balance,
            'bal_pct' => $billed ? round(abs($balance) / $billed * 100, 2) : 0,
            'units' => $s->unitRegistrations()->with('unit')->where('semester_id', $sem?->id)->get(),
        ];
    }
}