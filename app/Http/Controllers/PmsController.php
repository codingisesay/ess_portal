<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\OrganizationSetting;
use App\Models\Goal;
use App\Models\GoalAssignment;
use App\Models\Insight;
use App\Models\Task;
use App\Models\InsightBundleApproval;
use App\Models\InsightBundleItem;
// use App\Models\TaskApproval;
use App\Models\GoalApproval;    
use App\Models\GoalBundleApproval;
use App\Models\GoalBundleItem;

class PmsController extends Controller
{

    
    // ============================
    // ORGANIZATION SETTINGS
    // ============================
    public function orgSettingsIndex() {
        return response()->json(OrganizationSetting::all());
    }

   /**
 * Stores an organization setting
 *
 * @param Request $request
 * @return \Illuminate\Http\RedirectResponse
 */
public function orgSettingsStore(Request $request) {
    $superAdminId = Auth::guard('superadmin')->user()->id;

    $request->validate([
        'id'                 => 'nullable|integer',
        'name'               => 'required|string|max:100',
        'year'               => 'required|string|max:9',
        'cycle_type'         => 'required|string|max:20',
        'cycle_period'       => 'required|string|max:10',
        'start_date'         => 'required|date',
        'end_date'           => 'required|date',
        'process_start_date' => 'required|date',
        'process_end_date'   => 'required|date',
    ]);

    $setting = OrganizationSetting::updateOrCreate(
        ['id' => $request->id],
        [
            'name'               => $request->name,
            'year'               => $request->year,
            'cycle_type'         => $request->cycle_type,
            'cycle_period'       => $request->cycle_period,
            'start_date'         => $request->start_date,
            'end_date'           => $request->end_date,
            'process_start_date' => $request->process_start_date,
            'process_end_date'   => $request->process_end_date,
            'created_by'         => $superAdminId,
        ]
    );

    return redirect()->route('org_settings_form')->with('success', 'Organization setting saved successfully!');
}

    public function orgSettingsUpdate(Request $request, $id) {
        $user = Auth::user();
        $setting = OrganizationSetting::findOrFail($id);

        $request->validate([
            'name' => 'sometimes|string|max:100',
            'start_date' => 'sometimes|date',
            'end_date' => 'sometimes|date|after_or_equal:start_date',
        ]);

        $setting->update([
            'name'       => $request->name ?? $setting->name,
            'start_date' => $request->start_date ?? $setting->start_date,
            'end_date'   => $request->end_date ?? $setting->end_date,
            'created_by' => $user->id,
        ]);

        return response()->json($setting);
    }

    public function orgSettingsShow($id) {
        return response()->json(OrganizationSetting::findOrFail($id));
    }

    public function orgSettingsDestroy($id) {
        OrganizationSetting::findOrFail($id)->delete();
        return response()->json(['message'=>'Organization setting deleted']);
    }

   /**
 * Returns the organization settings form
 *
 * @return \Illuminate\View\View (issue no-(3743))
 */
    public function orgSettingsForm()
{
    $orgSettings = \App\Models\OrganizationSetting::orderBy('id', 'desc')->get();
    return view('superadmin_view.org_settings', compact('orgSettings'));
}

    /**
     * Returns all goals with their associated organization settings
     *
     * @return \Illuminate\Http\Response
     */
    public function goalsIndex()
    {
        // Get all goals with their associated organization settings
        // Select all columns from goals, and the name and cycle period from organization settings
        $goals = \DB::table('goals')
            ->leftJoin('organization_settings', 'organization_settings.id', '=', 'goals.org_setting_id')
            ->select(
                'goals.*',
                'organization_settings.name as period_name',
                'organization_settings.cycle_period',
            )
            ->get();

        return response()->json($goals);
    }


    public function goalsStore(Request $request) {
        $user = Auth::user();

        $request->validate([
            'id' => 'nullable|integer',
            'org_setting_id' => 'required|integer',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'nullable|in:low,medium,high,Critical',
            'status' => 'nullable|in:pending,in-progress,completed',
            'start_date' => 'required|date',
            'end_date'   => 'required|date',
        ]);

       $goal = Goal::updateOrCreate(
            ['id' => $request->id],
            [
                'org_setting_id' => $request->org_setting_id,
                'title'          => $request->title,
                'description'    => $request->description,
                'priority'       => $request->priority,
                'status'         => $request->status ?? 'pending',
                'start_date'     => $request->start_date,
                'end_date'       => $request->end_date,
                'created_by'     => $user->id,
            ]
        );
        return response()->json($goal, $request->id ? 200 : 201);
    }

    public function goalsUpdate(Request $request, $id) {
        $goal = Goal::findOrFail($id);

        $request->validate([
            'org_setting_id' => 'sometimes|integer',
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'sometimes|in:low,medium,high',
            'status' => 'sometimes|in:pending,in-progress,completed',
        ]);

        $goal->update($request->all());
        return response()->json($goal);
    }

    public function goalsShow($id) {
        return response()->json(Goal::findOrFail($id));
    }

    public function goalsDestroy($id) {
        Goal::findOrFail($id)->delete();
        return response()->json(['message'=>'Goal deleted']);
    }

    // ============================
    // GOAL ASSIGNMENTS
    // ============================
    // public function goalAssignmentsIndex() {
    //     return response()->json(GoalAssignment::all());
    // }

    // public function goalAssignmentsStore(Request $request) {
    //     $user = Auth::user();

    //     $request->validate([
    //         'id' => 'nullable|integer',
    //         'goal_id' => 'required|integer',
    //         'assigned_to' => 'required|integer',
    //         'role' => 'required|in:manager,employee',
    //     ]);

    //     $assignment = GoalAssignment::updateOrCreate(
    //         ['id' => $request->id],
    //         [
    //             'goal_id'     => $request->goal_id,
    //             'assigned_to' => $request->assigned_to,
    //             'assigned_by' => $user->id,
    //             'role'        => $request->role,
    //         ]
    //     );

    //     return response()->json($assignment, $request->id ? 200 : 201);
    // }

    // public function goalAssignmentsUpdate(Request $request, $id) {
    //     $assignment = GoalAssignment::findOrFail($id);

    //     $request->validate([
    //         'goal_id' => 'sometimes|integer',
    //         'assigned_to' => 'sometimes|integer',
    //         'role' => 'sometimes|in:manager,employee',
    //     ]);

    //     $assignment->update($request->all());
    //     return response()->json($assignment);
    // }

    // public function goalAssignmentsShow($id) {
    //     return response()->json(GoalAssignment::findOrFail($id));
    // }

    // public function goalAssignmentsDestroy($id) {
    //     GoalAssignment::findOrFail($id)->delete();
    //     return response()->json(['message'=>'Goal assignment deleted']);
    // }

    // ============================
    // INSIGHTS
    // ============================
        public function insightsIndex() {
            $user = Auth::user();
            $insights = Insight::where('user_id', $user->id)->get();
            return response()->json($insights);
        }

    public function insightsStore(Request $request) {
        $user = Auth::user();

        $request->validate([
            'id' => 'nullable|integer',
            'goal_id' => 'required|integer',
            'description' => 'required|string',
        ]);

        $insight = Insight::updateOrCreate(
            ['id' => $request->id],
            [
                'goal_id'     => $request->goal_id,
                'user_id'     => $user->id,
                'description' => $request->description,
            ]
        );

        return response()->json($insight, $request->id ? 200 : 201);
    }

    public function insightsUpdate(Request $request, $id) {
        $insight = Insight::findOrFail($id);

        $request->validate([
            'goal_id' => 'sometimes|integer',
            'description' => 'sometimes|string',
        ]);

        $insight->update($request->all());
        return response()->json($insight);
    }

    public function insightsShow($id) {
        return response()->json(Insight::findOrFail($id));
    }

    public function insightsDestroy($id) {
        Insight::findOrFail($id)->delete();
        return response()->json(['message'=>'Insight deleted']);
    }



public function submitInsightBundle(Request $request)
{
    $user = Auth::user();

    // Validate request
    $request->validate([
        'insight_ids' => 'required|array|min:1',
        'insight_ids.*' => 'integer|exists:insights,id',
    ]);

    // Get reporting manager
    $reportingManager = DB::table('emp_details')
        ->where('user_id', $user->id)
        ->value('reporting_manager');

    $insightIds = $request->insight_ids;

    // Check if there is an existing rejected bundle for these insights
    $existingBundleId = \DB::table('insight_bundle_items')
        ->join('insight_bundle_approvals', 'insight_bundle_items.bundle_id', '=', 'insight_bundle_approvals.id')
        ->whereIn('insight_bundle_items.insight_id', $insightIds)
        ->where('insight_bundle_approvals.requested_by', $user->id)
        ->where('insight_bundle_approvals.status', 'rejected')
        ->pluck('insight_bundle_approvals.id')
        ->first(); // Get first matching bundle

    if ($existingBundleId) {
        // If a rejected bundle exists, update its status back to 'pending'
        InsightBundleApproval::where('id', $existingBundleId)
            ->update(['status' => 'pending']);

        // Update the insights_status back to 'pending' as well
        \DB::table('insights')
            ->whereIn('id', $insightIds)
            ->update(['insights_status' => 'pending']);

        $bundleId = $existingBundleId;
    } else {
        // No rejected bundle exists; create a new one
        $bundle = InsightBundleApproval::create([
            'requested_by' => $user->id,
            'reporting_manager' => $reportingManager,
            'status' => 'pending',
        ]);

        // Attach the selected insights
        foreach ($insightIds as $insightId) {
            InsightBundleItem::create([
                'bundle_id' => $bundle->id,
                'insight_id' => $insightId,
            ]);
        }

        $bundleId = $bundle->id;
    }

    return response()->json([
        'message' => 'Insight bundle submitted',
        'bundle_id' => $bundleId
    ], 201);
}

public function pendingInsightBundles()
{
    $user = Auth::user();

    // manager only: pending bundles assigned to this manager
    $pending = InsightBundleApproval::with('items.insight.goal', 'requestedBy')
                ->where('reporting_manager', $user->id)
                ->where('status', 'pending')
                ->get();

    return view('manager.insight_bundles_pending', compact('pending'));
}

public function approveInsightBundle(Request $request, $id)
{
    $bundle = InsightBundleApproval::findOrFail($id);

    if ($bundle->status !== 'pending') {
        return response()->json(['message' => 'Already processed'], 400);
    }

    // Get status from request (or fallback to 'approved')
    $status = $request->status ?? 'approved';
    $rating = $request->rating ?? null; // rating sent from frontend

    // Update bundle status
    $bundle->update(['status' => $status]);

    // Update all insights related to this bundle
    $insightIds = \DB::table('insight_bundle_items')
        ->where('bundle_id', $bundle->id)
        ->pluck('insight_id');

    \DB::table('insights')
        ->whereIn('id', $insightIds)
        ->update([
            'insights_status' => $status,
            'insights_rating' => $rating // will be null if not provided
        ]);

    return response()->json(['message' => 'Bundle approved successfully.']);
}

public function rejectInsightBundle(Request $request, $id)
{
    $bundle = InsightBundleApproval::findOrFail($id);

    if ($bundle->status !== 'pending') {
        return response()->json(['message' => 'Already processed'], 400);
    }

    // ✅ Get status from request
    $status = $request->status ?? 'rejected'; // fallback to 'rejected'

    // Update bundle
    $bundle->update([
        'status' => $status,
        'remarks' => $request->remarks ?? null,
    ]);

    // Update all insights linked to this bundle
    \DB::table('insights')
        ->whereIn('id', function ($query) use ($bundle) {
            $query->select('insight_id')
                ->from('insight_bundle_items')
                ->where('bundle_id', $bundle->id);
        })
        ->update(['insights_status' => $status]);

    return response()->json(['message' => 'Bundle rejected successfully.']);
}


    

    // ============================
    // TASKS
    // ============================
    public function tasksIndex() {
        return response()->json(Task::all());
    }

// ============================
// TASKS
// ============================
public function tasksStore(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'id'          => 'nullable|integer',
        'title'       => 'required|string|max:255',
        'description' => 'nullable|string',
        'priority'    => 'nullable|in:low,medium,high',
        'status'      => 'nullable|in:pending,in-progress,completed',
        'start_date'  => 'nullable|date',
        'end_date'    => 'nullable|date|after_or_equal:start_date',
    ]);

    try {
        Task::updateOrCreate(
            ['id' => $request->id],
            [
                'title'       => $request->title,
                'description' => $request->description,
                'priority'    => $request->priority,
                'status'      => $request->status ?? 'pending',
                'created_by'  => $user->id,
                'assigned_to' => $user->id, // Employee assigns to self
                'start_date'  => $request->start_date,
                'end_date'    => $request->end_date,
            ]
        );

        return redirect()->back()->with('success', 'Task created successfully!');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed to create task. Please try again.');
    }
}

public function tasksUpdate(Request $request, $id)
{
    $task = Task::findOrFail($id);

    $request->validate([
        'title'       => 'sometimes|string|max:255',
        'description' => 'nullable|string',
        'priority'    => 'sometimes|in:low,medium,high',
        'status'      => 'sometimes|in:pending,in-progress,completed',
        'start_date'  => 'nullable|date',
        'end_date'    => 'nullable|date|after_or_equal:start_date',
    ]);

    try {
        $task->update($request->all());
        return redirect()->back()->with('success', 'Task updated successfully!');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed to update task.');
    }
}

public function tasksDestroy($id)
{
    try {
        Task::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Task deleted successfully!');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed to delete task.');
    }
}


      // ============================
    // GOAL ASSIGNMENTS
    // ============================

 public function submitForApproval(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'goal_ids' => 'required|array',
    ]);

    // Get reporting manager for this user
        $reportingManager = \DB::table('emp_details')
            ->where('user_id', $user->id)
            ->value('reporting_manager');

        foreach ($request->goal_ids as $goalId) {
            GoalApproval::create([
                'goal_id' => $goalId,
                'requested_by' => $user->id,
                'reporting_manager' => $reportingManager,
                'status' => 'pending',
            ]);
        }

            return back()->with('success', 'Goals submitted for approval!');
        }

        public function approveGoal($id)
        {
            $approval = GoalApproval::findOrFail($id);

            $approval->update(['status' => 'approved']);

            GoalAssignment::create([
                'goal_id' => $approval->goal_id,
                'assigned_to' => $approval->requested_by,
                'assigned_by' => $approval->reporting_manager,
                'role' => 'manager',
            ]);

            return back()->with('success', 'Goal approved and assigned!');
        }

        public function rejectGoal(Request $request, $id)
            {
                $approval = GoalApproval::findOrFail($id);

                $approval->update([
                    'status'  => 'rejected',
                    'remarks' => $request->remarks,
                ]);

                // ✅ Also mark the actual Goal as rejected
                $goal = Goal::find($approval->goal_id);
                if ($goal) {
                    $goal->update(['status' => 'rejected']);
                }

                return back()->with('error', 'Goal rejected.');
            }



// ============================
// GOAL BUNDLES
// ============================
public function submitBundle(Request $request)
{
    $user = Auth::user();

    \Log::info('Request payload', $request->all());

    $request->validate([
        'goal_ids' => 'required|array|min:1',
    ]);

    $bundleId = $request->bundle_id ?? null;

    if ($bundleId) {
        // Existing bundle (resubmission)
        $bundle = GoalBundleApproval::find($bundleId);

        if (!$bundle || $bundle->requested_by != $user->id) {
            return response()->json(['error' => 'Invalid bundle.'], 400);
        }

        // Reset bundle status for re-approval
        $bundle->update(['status' => 'pending']);
    } else {
        // First submission → create new bundle
        $reportingManager = \DB::table('emp_details')
            ->where('user_id', $user->id)
            ->value('reporting_manager');

        $bundle = GoalBundleApproval::create([
            'requested_by'      => $user->id,
            'reporting_manager' => $reportingManager,
            'status'            => 'pending',
        ]);
    }

    foreach ($request->goal_ids as $goalId) {
        // ====== Case 1: Custom Goals ======
        if (str_starts_with($goalId, 'custom-')) {
            $orgSettingId = $request->org_setting_ids[$goalId] ?? null;
            $title        = $request->custom_titles[$goalId] ?? 'Custom Goal';
            $startDate    = $request->custom_start[$goalId] ?? null;
            $endDate      = $request->custom_end[$goalId] ?? null;
            $description  = $request->custom_descriptions[$goalId] ?? null;

            if (!$orgSettingId || !$title || !$startDate || !$endDate) {
                continue;
            }

            $goal = Goal::create([
                'org_setting_id' => $orgSettingId,
                'title'          => $title,
                'description'    => $description,
                'start_date'     => $startDate,
                'end_date'       => $endDate,
                'priority'       => 'medium',
                'status'         => 'pending',
                'created_by'     => $user->id,
            ]);

            $goalId = $goal->id;
        }

        // ====== Case 2: Existing Goals ======
        else {
            $goal = Goal::find($goalId);
            $key  = (string)$goalId;

            if ($goal) {
                \Log::info("Updating goal {$goalId}", [
                    'old_title'       => $goal->title,
                    'old_description' => $goal->description,
                    'old_start_date'  => $goal->start_date,
                    'old_end_date'    => $goal->end_date,
                    'old_org_setting' => $goal->org_setting_id,
                    'new_title'       => $request->custom_titles[$key] ?? $goal->title,
                    'new_description' => $request->custom_descriptions[$key] ?? $goal->description,
                    'new_start_date'  => $request->custom_start[$key] ?? $goal->start_date,
                    'new_end_date'    => $request->custom_end[$key] ?? $goal->end_date,
                    'new_org_setting' => $request->org_setting_ids[$key] ?? $goal->org_setting_id,
                ]);

                // Update the goal
                $goal->update([
                    'org_setting_id' => $request->org_setting_ids[$key] ?? $goal->org_setting_id,
                    'title'          => $request->custom_titles[$key] ?? $goal->title,
                    'description'    => $request->custom_descriptions[$key] ?? $goal->description,
                    'start_date'     => $request->custom_start[$key] ?? $goal->start_date,
                    'end_date'       => $request->custom_end[$key] ?? $goal->end_date,
                    'status'         => 'pending', // reset for re-approval
                ]);
            } else {
                \Log::warning("Goal ID {$goalId} not found. Skipping.");
                continue;
            }
        }

        // ====== Attach Goal to Bundle ======
        GoalBundleItem::updateOrCreate(
            ['bundle_id' => $bundle->id, 'goal_id' => $goalId],
            []
        );
    }

    return response()->json(['message' => 'Goals bundle submitted successfully!']);
}






// Fetch pending bundles for manager
public function pendingBundles()
{
    $user = Auth::user();

    $bundles = GoalBundleApproval::with('items.goal', 'requestedBy')
                ->where('reporting_manager', $user->id)
                ->where('status', 'pending')
                ->get();

    return view('manager.approvals', compact('bundles'));
}

// Approve a bundle
public function approveBundle($bundleId)
{
    $bundle = GoalBundleApproval::findOrFail($bundleId);

    if ($bundle->status !== 'pending') {
        return response()->json(['message' => 'Bundle already processed.'], 400);
    }

    // Insert approved goals into goal_assignments
    foreach ($bundle->items as $item) {
        $goal = $item->goal;
        \DB::table('goal_assignments')->insert([
            'goal_id'      => $goal->id,
            'assigned_to'  => $bundle->requested_by,
            'assigned_by'  => auth()->id(),
            'role'         => 'Manager',
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);
    }

    // Mark bundle as approved
    $bundle->update(['status' => 'approved']);

   return response()->json(['message' => 'Bundle approved successfully!']);
}

// Reject a bundle
public function rejectBundle($bundleId)
{
    $bundle = GoalBundleApproval::findOrFail($bundleId);

    if ($bundle->status !== 'pending') {
        return back()->with('error', 'Bundle already processed.');
    }

    $bundle->update(['status' => 'rejected']);

    return response()->json(['message' => 'Bundle rejected successfully!']);
}

 /**
     * ================================
     * 1. Build Recursive Hierarchy
     * ================================
     * Returns tree of employees under a given manager (including themselves)
     */
    private function buildEmployeeHierarchy($managerId)
    {
        // Fetch current user details
        $manager = DB::table('users')
            ->join('emp_details', 'users.id', '=', 'emp_details.user_id')
            ->select('users.id', 'users.name', 'emp_details.designation')
            ->where('users.id', $managerId)
            ->first();

        if (!$manager) return null;

        // Fetch subordinates
        $subordinates = DB::table('users')
            ->join('emp_details', 'users.id', '=', 'emp_details.user_id')
            ->select('users.id', 'users.name', 'emp_details.designation')
            ->where('emp_details.reporting_manager', $managerId)
            ->get();

        // Recursive structure
        $children = [];
        foreach ($subordinates as $sub) {
            $children[] = $this->buildEmployeeHierarchy($sub->id);
        }

        return [
            'id' => $manager->id,
            'name' => $manager->name,
            'title' => $manager->designation ?? 'Employee',
            'children' => $children
        ];
    }

    /**
     * ================================
     * 2. API: Manager Hierarchy
     * ================================
     * Returns JSON for the logged-in manager’s team tree
     */
    public function managerHierarchy()
    {
        $user = Auth::user();
        $employeeHierarchy = $this->buildEmployeeHierarchy($user->id);

        return response()->json($employeeHierarchy);
    }

  /**
 * ================================
 * 3. API: User Goals
 * ================================
 * Returns detailed goals for a selected user (clicked in chart)
 */
public function userGoals($id)
{
    try {
        // Join goal_assignments with goals table to get full goal details
        $orggoals = DB::table('goal_assignments')
            ->join('goals', 'goal_assignments.goal_id', '=', 'goals.id')
            ->where('goal_assignments.assigned_to', $id)
            ->select(
                'goals.id',
                'goals.title',
                'goals.description',
                'goals.priority',
                'goals.status',
                'goals.start_date',
                'goals.end_date'
            )
            ->get();

        return response()->json($orggoals);

    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Failed to load goals',
            'message' => $e->getMessage()
        ], 500);
    }
}



    // ============================
    // PMS DASHBOARD (Main Entry)
    // ============================
    public function pmsDashboard()
    {


        $user = Auth::user();

            // Check if user is top-level (no reporting manager)
            $reportingManager = \DB::table('emp_details')
                ->where('user_id', $user->id)
                ->value('reporting_manager');

            $isTopLevel = $reportingManager === null;

            // Check if user has subordinates (is a manager)
            $hasSubordinates = \DB::table('emp_details')
                ->where('reporting_manager', $user->id)
                ->exists();

        $user = Auth::user();

       $reportingManager = \DB::table('emp_details')
        ->where('user_id', $user->id)
        ->value('reporting_manager');

   

   // Get IDs of goals already submitted by this user
    $submittedGoalIds = \DB::table('goal_bundle_items')
        ->join('goal_bundle_approvals', 'goal_bundle_items.bundle_id', '=', 'goal_bundle_approvals.id')
        ->where('goal_bundle_approvals.requested_by', $user->id)
        ->pluck('goal_bundle_items.goal_id')
        ->toArray();

    // Get active organization cycle (needed for filtering goals below)
    $activeCycle = \DB::table('organization_settings')
        ->where('is_active', 1) // or whatever flag you use
        ->first();

    // Fetch organization goals: include active cycle goals regardless of creator/assignment
    $allOrgGoals = \DB::table('goals')
        ->join('organization_settings', 'goals.org_setting_id', '=', 'organization_settings.id')
        ->select(
            'goals.*',
            'organization_settings.name as period_name',
            'goals.start_date',
            'goals.end_date'
        )
        ->when(isset($activeCycle->id), function ($q) use ($activeCycle) {
            // Prefer goals from the active organization cycle if available
            $q->where('goals.org_setting_id', $activeCycle->id);
        })
        ->whereNotIn('goals.id', $submittedGoalIds) // exclude already submitted
        ->orderByDesc('goals.id')
        ->get();


// ===== Individual submitted goals (old flow) =====
$individualSubmittedGoals = \DB::table('goal_approvals')
    ->join('goals', 'goal_approvals.goal_id', '=', 'goals.id')
    ->where('goal_approvals.requested_by', $user->id)
    ->select(
        'goals.id as goal_id',
        'goals.title',
        'goals.description',
        'goals.org_setting_id',
        'goals.start_date',
        'goals.end_date',
        'goal_approvals.status as approval_status',
        \DB::raw('NULL as bundle_id')
    )
    ->get();

// ===== Bundle submitted goals (new flow) =====
$bundleSubmittedGoals = \App\Models\GoalBundleItem::with('goal', 'bundle')
    ->whereHas('bundle', function($q) use ($user) {
        $q->where('requested_by', $user->id);
    })
    ->get()
    ->map(function($item) {
        return (object)[
            'goal_id'        => $item->goal_id,
            'title'          => $item->goal ? $item->goal->title : 'Custom Goal',
            'description'    => $item->goal ? $item->goal->description : null,
            'org_setting_id' => $item->goal ? $item->goal->org_setting_id : null,
            'start_date'     => $item->goal ? $item->goal->start_date : null,
            'end_date'       => $item->goal ? $item->goal->end_date : null,
            'approval_status'=> $item->bundle->status, // pending/approved/rejected
            'bundle_id'      => $item->bundle_id,
        ];
    });

// Merge both into one collection
$submittedGoals = $individualSubmittedGoals->merge($bundleSubmittedGoals);


    



        $orgInsights = \DB::table('insights')
            ->join('goals', 'insights.goal_id', '=', 'goals.id')
            ->join('users', 'insights.user_id', '=', 'users.id')
            ->select('insights.*', 'goals.title as goal_title', 'users.name as user_name')
            ->orderBy('insights.created_at', 'desc')
            ->get();

          // Already assigned goals (to this manager)
            $assignedGoals = \DB::table('goal_assignments')
                ->join('goals', 'goal_assignments.goal_id', '=', 'goals.id')
                ->join('organization_settings', 'goals.org_setting_id', '=', 'organization_settings.id')
               ->select(
                        'goal_assignments.*',
                        'goals.title as goal_title',
                        'goals.status as goal_status',
                        'goals.id as goal_id',
                        'goals.start_date',
                        'goals.end_date',
                        'organization_settings.name as period_name'
                    )
                ->where('goal_assignments.assigned_to', $user->id)
                ->where('goal_assignments.role', 'manager')
                ->get();

        $additionalGoals = \DB::table('goals')
            ->where('goals.created_by', $user->id)
            ->get();

        $ownTasks = \DB::table('tasks')
            ->where('assigned_to', $user->id)
            ->get();

        $managerInsights = \DB::table('insights')
            ->join('goals', 'insights.goal_id', '=', 'goals.id')
            ->join('users', 'insights.user_id', '=', 'users.id')
            ->join('emp_details', 'users.id', '=', 'emp_details.user_id')
            ->select(
                'insights.*',
                'goals.title as goal_title',
                'users.name as user_name',
                'emp_details.reporting_manager'
            )
            ->where('insights.user_id', Auth::id())   // 🔹 Filter by logged-in user
            ->orderBy('insights.created_at', 'desc')
            ->get();

        // $juniors = \DB::table('users')
        //     ->where('manager_id', $user->id)
        //     ->get();

        

        return view('user_view.pms_dashboard', [
            // Organization Dashboard Data
            'allOrgGoals' => $allOrgGoals,
            'orgInsights' => $orgInsights,
            // Manager Dashboard Data
             'assignedGoals' => $assignedGoals,
            'additionalGoals' => $additionalGoals,
            'ownTasks' => $ownTasks,
            'insights' => $managerInsights,
            // 'juniors' => $juniors,
            'submittedGoals' => $submittedGoals,
            'user' => $user,
            'activeCycle' => $activeCycle,
        ]);
        
    }

    
}
