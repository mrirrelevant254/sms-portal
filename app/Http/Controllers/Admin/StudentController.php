<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campus;
use App\Models\Programme;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with(['user', 'programme', 'campus'])->get();
        return view('admin.students.index', compact('students'));
    }

    public function create()
    {
        $programmes = Programme::all();
        $campuses = Campus::all();
        return view('admin.students.create', compact('programmes', 'campuses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'reg_no' => 'required|unique:students,reg_no',
            'programme_id' => 'required|exists:programmes,id',
            'campus_id' => 'required|exists:campuses,id',
            'year_of_study' => 'required|integer|min:1|max:6',
        ]);

        // 1. Create User Account
        $user = User::create([
            'name' => $validated['first_name'] . ' ' . $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make('password'), // Default password
        ]);
        $user->assignRole('student');

        // 2. Create Student Profile
        Student::create([
            'user_id' => $user->id,
            'programme_id' => $validated['programme_id'],
            'campus_id' => $validated['campus_id'],
            'reg_no' => $validated['reg_no'],
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'year_of_study' => $validated['year_of_study'],
            'semester_of_study' => 1,
            'status' => 'active',
        ]);

        return redirect()->route('admin.students.index')->with('success', 'Student enrolled successfully! Default password is "password".');
    }
}