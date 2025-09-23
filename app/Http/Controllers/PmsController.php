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
        ]);

        $goal = Goal::updateOrCreate(
            ['id' => $request->id],
            [
                'org_setting_id' => $request->org_setting_id,
                'title'          => $request->title,
                'description'    => $request->description,
                'priority'       => $request->priority,
                'status'         => $request->status ?? 'pending',
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
    public function goalAssignmentsIndex() {
        return response()->json(GoalAssignment::all());
    }

    public function goalAssignmentsStore(Request $request) {
        $user = Auth::user();

        $request->validate([
            'id' => 'nullable|integer',
            'goal_id' => 'required|integer',
            'assigned_to' => 'required|integer',
            'role' => 'required|in:manager,employee',
        ]);

        $assignment = GoalAssignment::updateOrCreate(
            ['id' => $request->id],
            [
                'goal_id'     => $request->goal_id,
                'assigned_to' => $request->assigned_to,
                'assigned_by' => $user->id,
                'role'        => $request->role,
            ]
        );

        return response()->json($assignment, $request->id ? 200 : 201);
    }

    public function goalAssignmentsUpdate(Request $request, $id) {
        $assignment = GoalAssignment::findOrFail($id);

        $request->validate([
            'goal_id' => 'sometimes|integer',
            'assigned_to' => 'sometimes|integer',
            'role' => 'sometimes|in:manager,employee',
        ]);

        $assignment->update($request->all());
        return response()->json($assignment);
    }

    public function goalAssignmentsShow($id) {
        return response()->json(GoalAssignment::findOrFail($id));
    }

    public function goalAssignmentsDestroy($id) {
        GoalAssignment::findOrFail($id)->delete();
        return response()->json(['message'=>'Goal assignment deleted']);
    }

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
    // TASK APPROVALS
    // ============================
    public function taskApprovalsIndex() {
        return response()->json(TaskApproval::all());
    }

    public function taskApprovalsStore(Request $request) {
        $user = Auth::user();

        $request->validate([
            'id' => 'nullable|integer',
            'task_id' => 'required|integer',
            'status' => 'nullable|in:approved,rejected,pending',
            'remarks' => 'nullable|string',
        ]);

        $approval = TaskApproval::updateOrCreate(
            ['id' => $request->id],
            [
                'task_id'     => $request->task_id,
                'approved_by' => $user->id,
                'status'      => $request->status ?? 'pending',
                'remarks'     => $request->remarks,
            ]
        );

        return response()->json($approval, $request->id ? 200 : 201);
    }

    public function taskApprovalsUpdate(Request $request, $id) {
        $approval = TaskApproval::findOrFail($id);

        $request->validate([
            'task_id' => 'sometimes|integer',
            'status' => 'sometimes|in:approved,rejected,pending',
            'remarks' => 'nullable|string',
        ]);

        $approval->update($request->all());
        return response()->json($approval);
    }

    public function taskApprovalsShow($id) {
        return response()->json(TaskApproval::findOrFail($id));
    }

    public function taskApprovalsDestroy($id) {
        TaskApproval::findOrFail($id)->delete();
        return response()->json(['message'=>'Task approval deleted']);
    }

    // ============================
    // PMS DASHBOARD
    // ============================
    public function pmsDashboard()
    {
        return view('user_view.pms_dashboard');
    }

    public function managerDashboard()
    {
        $user = Auth::user();

        // 1. Organization Goals Assigned (to this manager)
        $assignedGoals = \DB::table('goal_assignments')
            ->join('goals', 'goal_assignments.goal_id', '=', 'goals.id')
            ->join('organization_settings', 'goals.org_setting_id', '=', 'organization_settings.id')
            ->select(
                'goal_assignments.*',
                'goals.title as goal_title',
                'goals.status as goal_status',
                'goals.id as goal_id',
                'organization_settings.name as period_name'
            )
            ->where('goal_assignments.assigned_to', $user->id)
            ->where('goal_assignments.role', 'manager')
            ->get();

        // 2. Additional Goals/Tasks (created by this manager)
        $additionalGoals = \DB::table('goals')
            ->leftJoin('users', 'goals.assigned_to', '=', 'users.id')
            ->select('goals.*', 'users.name as assigned_to_name')
            ->where('goals.created_by', $user->id)
            ->get();

        // 3. Task List (own tasks)
        $ownTasks = \DB::table('tasks')
            ->where('assigned_to', $user->id)
            ->get();

        // 4. Insights Section (all insights with goal and user info)
        $insights = \DB::table('insights')
            ->join('goals', 'insights.goal_id', '=', 'goals.id')
            ->join('users', 'insights.user_id', '=', 'users.id')
            ->select('insights.*', 'goals.title as goal_title', 'users.name as user_name')
            ->orderBy('insights.created_at', 'desc')
            ->get();

        // List of juniors (for assigning tasks/goals)
        $juniors = \DB::table('users')
            ->where('manager_id', $user->id)
            ->get();

        return view('user_view.manager_dashboard', compact(
            'assignedGoals', 'additionalGoals', 'ownTasks', 'insights', 'juniors'
        ));
    }
}
