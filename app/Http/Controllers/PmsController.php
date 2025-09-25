<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\OrganizationSetting;
use App\Models\Goal;
use App\Models\GoalAssignment;
use App\Models\Insight;
use App\Models\Task;
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

    public function orgSettingsStore(Request $request) {
        $user = Auth::user();

        $request->validate([
            'id' => 'nullable|integer',
            'name' => 'required|string|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $setting = OrganizationSetting::updateOrCreate(
            ['id' => $request->id],
            [
                'name'       => $request->name,
                'start_date' => $request->start_date,
                'end_date'   => $request->end_date,
                'created_by' => $user->id,
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

    public function orgSettingsForm() {
        return view('superadmin_view.org_settings');
    }

    // ============================
    // GOALS
    // ============================
    public function goalsIndex() {
        return response()->json(Goal::all());
    }

    public function goalsStore(Request $request) {
        $user = Auth::user();

        $request->validate([
            'id' => 'nullable|integer',
            'org_setting_id' => 'required|integer',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'nullable|in:low,medium,high',
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
        return response()->json(Insight::all());
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

    // ============================
    // TASKS
    // ============================
    public function tasksIndex() {
        return response()->json(Task::all());
    }

    public function tasksStore(Request $request) {
        $user = Auth::user();

        $request->validate([
            'id' => 'nullable|integer',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'nullable|in:low,medium,high',
            'status' => 'nullable|in:pending,in-progress,completed',
            'assigned_to' => 'required|integer',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $task = Task::updateOrCreate(
            ['id' => $request->id],
            [
                'title'       => $request->title,
                'description' => $request->description,
                'priority'    => $request->priority,
                'status'      => $request->status ?? 'pending',
                'created_by'  => $user->id,
                'assigned_to' => $request->assigned_to ?? $user->id,
                'start_date'  => $request->start_date,
                'end_date'    => $request->end_date,
            ]
        );

        return response()->json($task, $request->id ? 200 : 201);
    }

    public function tasksUpdate(Request $request, $id) {
        $task = Task::findOrFail($id);

        $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'sometimes|in:low,medium,high',
            'status' => 'sometimes|in:pending,in-progress,completed',
            'assigned_to' => 'sometimes|integer',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $task->update($request->all());
        return response()->json($task);
    }

    public function tasksShow($id) {
        return response()->json(Task::findOrFail($id));
    }

    public function tasksDestroy($id) {
        Task::findOrFail($id)->delete();
        return response()->json(['message'=>'Task deleted']);
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
                'status' => 'rejected',
                'remarks' => $request->remarks,
            ]);

            return back()->with('error', 'Goal rejected.');
        }



 // ============================
    // GOAL BUNDLES
    // ============================
public function submitBundle(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'goal_ids' => 'required|array|min:1',
    ]);

    $reportingManager = \DB::table('emp_details')
        ->where('user_id', $user->id)
        ->value('reporting_manager');

    // Create a new bundle for approval
    $bundle = GoalBundleApproval::create([
        'requested_by'      => $user->id,
        'reporting_manager' => $reportingManager,
        'status'            => 'pending'
    ]);

    foreach ($request->goal_ids as $goalId) {

        // ====== Custom Goals ======
        if (str_starts_with($goalId, 'custom-')) {
            $orgSettingId = $request->org_setting_ids[$goalId] ?? null;
            $title        = $request->custom_titles[$goalId] ?? 'Custom Goal';
            $startDate    = $request->custom_start[$goalId] ?? null;
            $endDate      = $request->custom_end[$goalId] ?? null;

            if (!$orgSettingId || !$title || !$startDate || !$endDate) continue;

            $goal = Goal::create([
                'org_setting_id' => $orgSettingId,
                'title'          => $title,
                'start_date'     => $startDate,
                'end_date'       => $endDate,
                'priority'       => 'medium',
                'status'         => 'pending',
                'created_by'     => $user->id,
            ]);

            $goalId = $goal->id;

        } else {
            // ====== Resubmitted Rejected Goals ======
            $goal = Goal::find($goalId);
            if ($goal && $goal->status === 'rejected') {
                $goal->update([
                    'title'      => $request->custom_titles[$goalId] ?? $goal->title,
                    'start_date' => $request->custom_start[$goalId] ?? $goal->start_date,
                    'end_date'   => $request->custom_end[$goalId] ?? $goal->end_date,
                    'status'     => 'pending', // reset for resubmission
                ]);
            }
        }

        // Add to bundle items
        GoalBundleItem::create([    
            'bundle_id' => $bundle->id,
            'goal_id'   => $goalId
        ]);
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

            // Only show goals NOT submitted yet
            $allOrgGoals = \DB::table('goals')
            ->join('organization_settings', 'goals.org_setting_id', '=', 'organization_settings.id')
            ->select('goals.*', 'organization_settings.name as period_name', 'goals.start_date', 'goals.end_date')
            ->whereIn('goals.created_by', [$user->id, $reportingManager])
            ->whereNotIn('goals.id', $submittedGoalIds) // <- Exclude submitted goals
            ->get();

// Already assigned / submitted goals
//   $submittedGoals = \DB::table('goal_bundle_items')
//     ->join('goal_bundle_approvals', 'goal_bundle_items.bundle_id', '=', 'goal_bundle_approvals.id')
//     ->join('goals', 'goal_bundle_items.goal_id', '=', 'goals.id')
//     ->where('goal_bundle_approvals.requested_by', $user->id)
//     ->where('goal_bundle_approvals.status', 'rejected') // only rejected bundles
//     ->select(
//         'goals.id as goal_id',
//         'goals.title',
//         'goals.org_setting_id',
//         'goals.start_date',
//         'goals.end_date',
//         'goal_bundle_approvals.status as approval_status'
//     )
//     ->get();
// // dd($submittedGoals);

$individualSubmittedGoals = \DB::table('goal_approvals')
    ->join('goals', 'goal_approvals.goal_id', '=', 'goals.id')
    ->where('goal_approvals.requested_by', $user->id)
    ->select(
        'goals.id as goal_id',
        'goals.title',
        'goals.org_setting_id',
        'goals.start_date',
        'goals.end_date',
        'goal_approvals.status as approval_status'
    )
    ->get();

    $bundleSubmittedGoals = \App\Models\GoalBundleItem::with('goal', 'bundle')
    ->whereHas('bundle', function($q) use ($user) {
        $q->where('requested_by', $user->id); // only bundles requested by this user
    })
    ->get()
    ->map(function($item) {
        return (object)[
            'goal_id' => $item->goal_id,
            'title' => $item->goal ? $item->goal->title : 'Custom Goal',
            'org_setting_id' => $item->goal ? $item->goal->org_setting_id : null,
            'start_date' => $item->goal ? $item->goal->start_date : null,
            'end_date' => $item->goal ? $item->goal->end_date : null,
            'approval_status' => $item->bundle->status, // pending/approved/rejected
        ];
    });

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
            ->select('insights.*', 'goals.title as goal_title', 'users.name as user_name')
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
        ]);
        
    }

    
}
