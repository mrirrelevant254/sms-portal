<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudentRequest;
use App\Services\RequestWorkflowService;
use Illuminate\Http\Request;

class RequestApprovalController extends Controller
{
    public function index()
    {
        // For demo purposes, show all pending requests
        $requests = StudentRequest::with('student')->where('status', '!=', 'approved')->where('status', '!=', 'rejected')->get();
        return view('admin.requests.index', compact('requests'));
    }

    public function process(Request $req, StudentRequest $studentRequest, RequestWorkflowService $workflow)
    {
        $req->validate([
            'decision' => 'required|in:approved,rejected',
            'comment' => 'nullable|string'
        ]);

        $workflow->process($workflow, $studentRequest, $req->decision, $req->comment ?? '', $req->user());

        return back()->with('success', 'Request updated successfully!');
    }
}