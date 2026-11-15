<?php

namespace Database\Seeders;

use App\Models\{Campus, Programme, Semester, Student, User};
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $campus = Campus::firstOrCreate(['code' => 'MAIN'], ['name' => 'Main Campus']);
        $programme = Programme::firstOrCreate(
            ['code' => 'SC200'],
            ['name' => 'BSc Computer Science']
        );

        Semester::firstOrCreate(
            ['academic_year' => '2026/2027', 'semester_no' => 1],
            ['is_current' => true]
        );

        $user = User::firstOrCreate(
            ['email' => 'student@test.local'],
            ['name' => 'Demo Student', 'password' => Hash::make('password')]
        );
        
        if (!$user->hasRole('student')) {
            $user->assignRole('student');
        }

        Student::firstOrCreate(
            ['user_id' => $user->id],
            [
                'programme_id' => $programme->id,
                'campus_id' => $campus->id,
                'reg_no' => 'SC200/0397/2022',
                'first_name' => 'Demo',
                'last_name' => 'Student',
                'year_of_study' => 4,
                'semester_of_study' => 2,
                'status' => 'active',
            ]
        );

        $hostel = \App\Models\Hostel::firstOrCreate(['name' => 'Nyayo Hostel'], [
            'gender' => 'male', 
            'location' => 'Main Campus'
        ]);
        
        $hostel->rooms()->firstOrCreate(['room_no' => 'A-101'], ['capacity' => 4, 'fee' => 15000]);
        $hostel->rooms()->firstOrCreate(['room_no' => 'A-102'], ['capacity' => 4, 'fee' => 15000]);
        $hostel->rooms()->firstOrCreate(['room_no' => 'B-201'], ['capacity' => 2, 'fee' => 25000]);
    }


        // Add Units
    $programme->units()->firstOrCreate(['code' => 'CSC401'], ['title' => 'Software Engineering', 'year_no' => 4, 'semester_no' => 2]);
    $programme->units()->firstOrCreate(['code' => 'CSC402'], ['title' => 'Artificial Intelligence', 'year_no' => 4, 'semester_no' => 2]);
    $programme->units()->firstOrCreate(['code' => 'CSC403'], ['title' => 'Distributed Systems', 'year_no' => 4, 'semester_no' => 2]);
    $programme->units()->firstOrCreate(['code' => 'CSC404'], ['title' => 'Mobile Application Development', 'year_no' => 4, 'semester_no' => 2]);

    // Add Hostels
    $hostel = \App\Models\Hostel::firstOrCreate(['name' => 'Nyayo Hostel'], ['gender' => 'male', 'location' => 'Main Campus']);
    $hostel->rooms()->firstOrCreate(['room_no' => 'A-101'], ['capacity' => 4, 'fee' => 15000]);
    $hostel->rooms()->firstOrCreate(['room_no' => 'A-102'], ['capacity' => 4, 'fee' => 15000]);
    $hostel->rooms()->firstOrCreate(['room_no' => 'B-201'], ['capacity' => 2, 'fee' => 25000]);

    // Add Finance Data
    if ($studentRecord) {
        $sem = \App\Models\Semester::where('is_current', true)->first();
        $invoice = \App\Models\Invoice::firstOrCreate(
            ['student_id' => $studentRecord->id, 'semester_id' => $sem->id],
            ['total' => 62740.00, 'status' => 'unpaid']
        );
        \App\Models\Payment::firstOrCreate(
            ['reference' => 'QK47H2L9P0'],
            ['invoice_id' => $invoice->id, 'method' => 'mpesa', 'amount' => 25000.00, 'status' => 'success']
        );
    }
}