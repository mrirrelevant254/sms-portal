<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Student\DashboardController;
use App\Http\Controllers\Student\UnitRegistrationController;
use App\Http\Controllers\Student\FeeController;
use App\Http\Controllers\Student\RequestController;
use App\Http\Controllers\Student\HostelBookingController;
use App\Http\Controllers\Student\ExamCardController;
use App\Http\Controllers\Student\TranscriptController;
use App\Http\Controllers\Student\SemesterReportController;
use App\Http\Controllers\Admin\RequestApprovalController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Lecturer\GradeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = auth()->user();
    
    if ($user->hasRole('student')) {
        return redirect()->route('student.dashboard');
    }
    if ($user->hasRole('lecturer')) {
        return redirect()->route('lecturer.grades.index');
    }
    if ($user->hasRole('admin') || $user->hasRole('registrar')) {
        return redirect()->route('admin.students.index');
    }
    
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->prefix('student')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('student.dashboard');
    Route::get('/units', [UnitRegistrationController::class, 'index'])->name('student.units.index');
    Route::post('/units', [UnitRegistrationController::class, 'store'])->name('student.units.store');
    Route::get('/fees/statement', [FeeController::class, 'statement'])->name('student.fees.statement');
    Route::get('/fees/statement/download', [FeeController::class, 'downloadStatement'])->name('student.fees.download');
    Route::get('/requests', [RequestController::class, 'index'])->name('student.requests.index');
    Route::get('/requests/create', [RequestController::class, 'create'])->name('student.requests.create');
    Route::post('/requests', [RequestController::class, 'store'])->name('student.requests.store');
    Route::get('/hostel', [HostelBookingController::class, 'index'])->name('student.hostel.index');
    Route::post('/hostel', [HostelBookingController::class, 'store'])->name('student.hostel.store');
    Route::get('/exam-card', [ExamCardController::class, 'show'])->name('student.exam-card.index');
    Route::get('/exam-card/download', [ExamCardController::class, 'download'])->name('student.exam-card.download');
    Route::get('/transcript', [TranscriptController::class, 'show'])->name('student.transcript.index');
    Route::get('/transcript/download', [TranscriptController::class, 'download'])->name('student.transcript.download');
    
    // Semester Reporting
    Route::get('/semester-report', [SemesterReportController::class, 'index'])->name('student.semester-report.index');
    Route::post('/semester-report', [SemesterReportController::class, 'store'])->name('student.semester-report.store');
});

Route::middleware(['auth'])->prefix('admin')->group(function () {
    // Student Management
    Route::get('/students', [StudentController::class, 'index'])->name('admin.students.index');
    Route::get('/students/create', [StudentController::class, 'create'])->name('admin.students.create');
    Route::post('/students', [StudentController::class, 'store'])->name('admin.students.store');
    
    // Request Approval
    Route::get('/requests', [RequestApprovalController::class, 'index'])->name('admin.requests.index');
    Route::post('/requests/{studentRequest}/process', [RequestApprovalController::class, 'process'])->name('admin.requests.process');
});

Route::middleware(['auth'])->prefix('lecturer')->group(function () {
    Route::get('/grades', [GradeController::class, 'index'])->name('lecturer.grades.index');
    Route::post('/grades/{registration}', [GradeController::class, 'store'])->name('lecturer.grades.store');
});

require __DIR__.'/auth.php';