<?php

namespace App\Http\Controllers\Approval;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ApprovalHistory;

class ApprovalHistoryController extends Controller
{
    public function index(Request $request)
    {
        $data = ApprovalHistory::with(['workflowRequest.workflowApproval.workflowDefinition', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.approval.approval-history.index', get_defined_vars());
    }

    public function show($id)
    {
        $data = ApprovalHistory::with([
            'workflowRequest.workflowApproval.workflowDefinition',
            'approval.approvalStatus',
            'user',
        ])->findOrFail($id);

        return view('pages.approval.approval-history.show', get_defined_vars());
    }
}
