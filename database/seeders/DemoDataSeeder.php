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
    }
}