<?php

namespace Tests\Feature;

use App\Http\Middleware\ValidateApiKey;
use App\Models\ApiKey;
use App\Models\Approval;
use App\Models\ApprovalHistory;
use App\Models\ApprovalStatus;
use App\Models\ApproverType;
use App\Models\User;
use App\Models\WorkflowApproval;
use App\Models\WorkflowApprovalStage;
use App\Models\WorkflowApprover;
use App\Models\WorkflowDefinition;
use App\Models\WorkflowRequest;
use App\Services\ApprovalService;
use Database\Seeders\ApprovalStatusSeeder;
use Database\Seeders\ApproverTypeSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use LogicException;
use Tests\TestCase;

class WorkflowApprovalTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(ApprovalStatusSeeder::class);
        $this->seed(ApproverTypeSeeder::class);
    }

    public function test_seeders_populated_expected_data(): void
    {
        $this->assertDatabaseHas('approval_statuses', ['code' => 'PENDING']);
        $this->assertDatabaseHas('approval_statuses', ['code' => 'IN_PROGRESS']);
        $this->assertDatabaseHas('approval_statuses', ['code' => 'APPROVED']);
        $this->assertDatabaseHas('approval_statuses', ['code' => 'REJECTED']);

        $this->assertDatabaseHas('approver_types', ['code' => 'USER']);
        $this->assertDatabaseHas('approver_types', ['code' => 'POSITION']);
    }

    public function test_workflow_submission_and_multistage_approval(): void
    {
        $requester = User::factory()->create();
        $approverUser1 = User::factory()->create();
        $approverUser2 = User::factory()->create();

        $userApproverType = ApproverType::where('code', 'USER')->firstOrFail();

        // 1. Create Workflow Definition & Published Version
        $definition = WorkflowDefinition::create([
            'code' => 'LEAVE_REQ',
            'name' => 'Leave Request Workflow',
            'is_active' => true,
        ]);

        $workflowApproval = WorkflowApproval::create([
            'workflow_definition_id' => $definition->id,
            'version' => 1,
            'status' => 'PUBLISHED',
            'published_at' => now(),
        ]);

        // 2. Stages: Stage 1 (Manager, ANY), Stage 2 (HR, ALL)
        $stage1 = WorkflowApprovalStage::create([
            'workflow_approval_id' => $workflowApproval->id,
            'sequence' => 1,
            'name' => 'Manager Review',
            'rule' => 'ANY',
        ]);

        $stage2 = WorkflowApprovalStage::create([
            'workflow_approval_id' => $workflowApproval->id,
            'sequence' => 2,
            'name' => 'HR Director Approval',
            'rule' => 'ALL',
        ]);

        // Approvers for Stage 1
        $stage1Approver = WorkflowApprover::create([
            'workflow_approval_stage_id' => $stage1->id,
            'approver_type_id' => $userApproverType->id,
            'user_id' => $approverUser1->id,
        ]);

        // Approvers for Stage 2
        $stage2Approver = WorkflowApprover::create([
            'workflow_approval_stage_id' => $stage2->id,
            'approver_type_id' => $userApproverType->id,
            'user_id' => $approverUser2->id,
        ]);

        $service = app(ApprovalService::class);

        // 3. Submit Request
        $request = $service->submitRequest($definition->code, [
            'requester_id' => $requester->id,
            'requestable_type' => 'App\\Models\\User',
            'requestable_id' => $requester->id,
            'title' => 'Annual Leave for John',
            'payload' => ['days' => 5, 'reason' => 'Family vacation'],
        ]);

        $this->assertInstanceOf(WorkflowRequest::class, $request);
        $this->assertEquals('PENDING', $request->status->code);
        $this->assertEquals(1, $request->current_sequence);
        $this->assertDatabaseHas('approval_histories', [
            'workflow_request_id' => $request->id,
            'event' => 'SUBMITTED',
        ]);

        // 4. Process Stage 1 Approval (Decision: APPROVED)
        $approval1 = $service->processApproval($request, [
            'user_id' => $approverUser1->id,
            'decision' => 'APPROVED',
            'note' => 'Approved by manager.',
        ]);

        $this->assertInstanceOf(Approval::class, $approval1);
        $this->assertNotEmpty($approval1->signature_hash);
        $this->assertEquals(64, strlen($approval1->signature_hash));

        $request->refresh();
        $this->assertEquals('IN_PROGRESS', $request->status->code);
        $this->assertEquals(2, $request->current_sequence);

        // 5. Process Stage 2 Approval (Decision: APPROVED)
        $approval2 = $service->processApproval($request, [
            'user_id' => $approverUser2->id,
            'decision' => 'APPROVED',
            'note' => 'Final HR approval granted.',
        ]);

        $request->refresh();
        $this->assertEquals('APPROVED', $request->status->code);
        $this->assertNull($request->current_sequence);
        $this->assertNotNull($request->completed_at);
    }

    public function test_approval_record_is_immutable(): void
    {
        $user = User::factory()->create();
        $type = ApproverType::where('code', 'USER')->firstOrFail();
        $status = ApprovalStatus::where('code', 'PENDING')->firstOrFail();

        $definition = WorkflowDefinition::create(['code' => 'EXPENSE', 'name' => 'Expense', 'is_active' => true]);
        $version = WorkflowApproval::create(['workflow_definition_id' => $definition->id, 'version' => 1, 'status' => 'PUBLISHED']);
        $stage = WorkflowApprovalStage::create(['workflow_approval_id' => $version->id, 'sequence' => 1, 'name' => 'Finance', 'rule' => 'ANY']);
        $approver = WorkflowApprover::create(['workflow_approval_stage_id' => $stage->id, 'approver_type_id' => $type->id, 'user_id' => $user->id]);

        $workflowRequest = WorkflowRequest::create([
            'workflow_approval_id' => $version->id,
            'approval_status_id' => $status->id,
            'requester_id' => $user->id,
            'current_sequence' => 1,
            'requestable_type' => 'App\\Models\\User',
            'requestable_id' => $user->id,
            'title' => 'Travel Expense',
        ]);

        $approval = Approval::create([
            'workflow_request_id' => $workflowRequest->id,
            'workflow_approval_stage_id' => $stage->id,
            'workflow_approver_id' => $approver->id,
            'actor_user_id' => $user->id,
            'decision' => 'APPROVED',
            'note' => 'Looks good',
            'signature_hash' => hash('sha256', 'payload'),
            'signature_key_version' => 'v1',
            'acted_at' => now(),
        ]);

        $this->expectException(LogicException::class);
        $approval->update(['note' => 'Tampered note']);
    }

    public function test_api_key_hashing_and_middleware(): void
    {
        $plainKey = 'test_secret_key_12345';
        $prefix = substr($plainKey, 0, 8);
        $hash = hash('sha256', $plainKey);

        $apiKey = ApiKey::create([
            'name' => 'ERP Integration',
            'key_prefix' => $prefix,
            'key_hash' => $hash,
            'is_active' => true,
            'permissions' => ['workflows.read', 'workflows.create'],
            'rate_limit' => 100,
        ]);

        $this->assertDatabaseHas('api_keys', [
            'id' => $apiKey->id,
            'key_prefix' => $prefix,
            'key_hash' => $hash,
        ]);

        // Test middleware validation
        $middleware = new ValidateApiKey();
        $request = Request::create('/api/v1/workflows', 'GET');
        $request->headers->set('X-API-KEY', $plainKey);

        $response = $middleware->handle($request, function ($req) {
            return response()->json(['success' => true]);
        });

        $this->assertEquals(200, $response->getStatusCode());
    }
}
