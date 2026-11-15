<?php

namespace App\Services;

use App\Models\StudentRequest;

class RequestWorkflowService
{
    // Define the approval chain for each request type
    protected $chains = [
        'graduation' => ['finance', 'library', 'hostel', 'department', 'registrar'],
        'defer'      => ['department', 'registrar'],
        'withdrawal' => ['department', 'finance', 'registrar'],
    ];

    public function initiate(StudentRequest $request)
    {
        $chain = $this->chains[$request->type] ?? ['registrar'];
        
        // Set the first step
        $request->update(['current_step' => $chain[0]]);

        // Log the first step in the approvals table
        $request->approvals()->create([
            'role' => $chain[0],
            'decision' => null,
        ]);
    }

    public function process(RequestWorkflowService $service, StudentRequest $request, string $decision, string $comment, $user)
    {
        // 1. Record the decision for the current step
        $currentApproval = $request->approvals()->where('role', $request->current_step)->whereNull('decision')->first();
        
        if ($currentApproval) {
            $currentApproval->update([
                'approver_id' => $user->id,
                'decision' => $decision,
                'comment' => $comment,
                'acted_at' => now(),
            ]);
        }

        // 2. If rejected, stop the chain
        if ($decision === 'rejected') {
            $request->update(['status' => 'rejected']);
            return;
        }

        // 3. If approved, find the next step
        $chain = $this->chains[$request->type] ?? ['registrar'];
        $currentIndex = array_search($request->current_step, $chain);

        if ($currentIndex !== false && isset($chain[$currentIndex + 1])) {
            // Move to next step
            $nextStep = $chain[$currentIndex + 1];
            $request->update(['current_step' => $nextStep, 'status' => 'in_review']);
            
            $request->approvals()->create([
                'role' => $nextStep,
                'decision' => null,
            ]);
        } else {
            // No more steps, fully approved!
            $request->update(['status' => 'approved', 'current_step' => 'completed']);
            
            // Apply final business logic (e.g., update student status)
            $this->applyFinalOutcome($request);
        }
    }

    protected function applyFinalOutcome(StudentRequest $request)
    {
        if ($request->type === 'withdrawal') {
            $request->student->update(['status' => 'withdrawn']);
        } elseif ($request->type === 'defer') {
            $request->student->update(['status' => 'deferred']);
        }
    }
}