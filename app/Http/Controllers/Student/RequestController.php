<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\StudentRequest;
use App\Services\RequestWorkflowService;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    public function index(Request $request)
    {
        $requests = $request->user()->student->requests()->latest()->get();
        return view('student.requests.index', compact('requests'));
    }

    public function create()
    {
        return view('student.requests.create');
    }

    public function store(Request $request, RequestWorkflowService $workflow)
    {
        $validated = $request->validate([
            'type' => 'required|in:graduation,defer,withdrawal',
            'reason' => 'required|string|min:10',
        ]);

        $studentRequest = $request->user()->student->requests()->create([
            'type' => $validated['type'],
            'reason' => $validated['reason'],
            'status' => 'pending',
        ]);

        $workflow->initiate($studentRequest);

        return redirect()->route('student.requests.index')->with('success', 'Request submitted successfully. It is now pending approval.');
    }
}