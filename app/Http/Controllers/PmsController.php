<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\OrganizationSetting;
use App\Models\Goal;
use App\Models\GoalAssignment;
use App\Models\Insight;
use App\Models\Task;
use App\Models\TaskApproval;

class PmsController extends Controller
{
    // ============================
    // USERS
    // ============================
    public function usersIndex() {
        return response()->json(User::all());
    }

    // POST: insert or update (upsert)
    public function usersStore(Request $request) {
        $request->validate([
            'id' => 'nullable|integer',
            'name' => 'required|string|max:150',
            'email' => 'required|email',
            'role' => 'required|in:organization,manager,employee',
            'designation' => 'nullable|string|max:100',
        ]);

        $user = User::updateOrCreate(
            ['id' => $request->id],
            $request->only('name','email','role','designation')
        );

        return response()->json($user, $request->id ? 200 : 201);
    }

    // PUT: strict update
    public function usersUpdate(Request $request, $id) {
        $user = User::findOrFail($id);
        $request->validate([
            'name' => 'sometimes|string|max:150',
            'email' => 'sometimes|email',
            'role' => 'sometimes|in:organization,manager,employee',
            'designation' => 'nullable|string|max:100',
        ]);
        $user->update($request->all());
        return response()->json($user);
    }

    public function usersShow($id) { return response()->json(User::findOrFail($id)); }
    public function usersDestroy($id) { User::findOrFail($id)->delete(); return response()->json(['message'=>'User deleted']); }

    // ============================
    // ORGANIZATION SETTINGS
    // ============================
    public function orgSettingsIndex() { return response()->json(OrganizationSetting::all()); }

    public function orgSettingsStore(Request $request) {
        $request->validate([
            'id' => 'nullable|integer',
            'name' => 'required|string|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'created_by' => 'required|integer',
        ]);

        $setting = OrganizationSetting::updateOrCreate(
            ['id' => $request->id],
            $request->only('name','start_date','end_date','created_by')
        );

        return response()->json($setting, $request->id ? 200 : 201);
    }

    public function orgSettingsUpdate(Request $request, $id) {
        $setting = OrganizationSetting::findOrFail($id);
        $request->validate([
            'name' => 'sometimes|string|max:100',
            'start_date' => 'sometimes|date',
            'end_date' => 'sometimes|date|after_or_equal:start_date',
            'created_by' => 'sometimes|integer',
        ]);
        $setting->update($request->all());
        return response()->json($setting);
    }

    public function orgSettingsShow($id) { return response()->json(OrganizationSetting::findOrFail($id)); }
    public function orgSettingsDestroy($id) { OrganizationSetting::findOrFail($id)->delete(); return response()->json(['message'=>'Organization setting deleted']); }

    // ============================
    // GOALS
    // ============================
    public function goalsIndex() { return response()->json(Goal::all()); }

    public function goalsStore(Request $request) {
        $request->validate([
            'id' => 'nullable|integer',
            'org_setting_id' => 'required|integer',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'nullable|in:low,medium,high',
            'status' => 'nullable|in:pending,in-progress,completed',
            'created_by' => 'required|integer',
        ]);

        $goal = Goal::updateOrCreate(
            ['id' => $request->id],
            $request->only('org_setting_id','title','description','priority','status','created_by')
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
            'created_by' => 'sometimes|integer',
        ]);
        $goal->update($request->all());
        return response()->json($goal);
    }

    public function goalsShow($id) { return response()->json(Goal::findOrFail($id)); }
    public function goalsDestroy($id) { Goal::findOrFail($id)->delete(); return response()->json(['message'=>'Goal deleted']); }

    // ============================
    // GOAL ASSIGNMENTS
    // ============================
    public function goalAssignmentsIndex() { return response()->json(GoalAssignment::all()); }

    public function goalAssignmentsStore(Request $request) {
        $request->validate([
            'id' => 'nullable|integer',
            'goal_id' => 'required|integer',
            'assigned_to' => 'required|integer',
            'assigned_by' => 'required|integer',
            'role' => 'required|in:manager,employee',
        ]);

        $assignment = GoalAssignment::updateOrCreate(
            ['id' => $request->id],
            $request->only('goal_id','assigned_to','assigned_by','role')
        );

        return response()->json($assignment, $request->id ? 200 : 201);
    }

    public function goalAssignmentsUpdate(Request $request, $id) {
        $assignment = GoalAssignment::findOrFail($id);
        $request->validate([
            'goal_id' => 'sometimes|integer',
            'assigned_to' => 'sometimes|integer',
            'assigned_by' => 'sometimes|integer',
            'role' => 'sometimes|in:manager,employee',
        ]);
        $assignment->update($request->all());
        return response()->json($assignment);
    }

    public function goalAssignmentsShow($id) { return response()->json(GoalAssignment::findOrFail($id)); }
    public function goalAssignmentsDestroy($id) { GoalAssignment::findOrFail($id)->delete(); return response()->json(['message'=>'Goal assignment deleted']); }

    // ============================
    // INSIGHTS
    // ============================
    public function insightsIndex() { return response()->json(Insight::all()); }

    public function insightsStore(Request $request) {
        $request->validate([
            'id' => 'nullable|integer',
            'goal_id' => 'required|integer',
            'user_id' => 'required|integer',
            'description' => 'required|string',
        ]);

        $insight = Insight::updateOrCreate(
            ['id' => $request->id],
            $request->only('goal_id','user_id','description')
        );

        return response()->json($insight, $request->id ? 200 : 201);
    }

    public function insightsUpdate(Request $request, $id) {
        $insight = Insight::findOrFail($id);
        $request->validate([
            'goal_id' => 'sometimes|integer',
            'user_id' => 'sometimes|integer',
            'description' => 'sometimes|string',
        ]);
        $insight->update($request->all());
        return response()->json($insight);
    }

    public function insightsShow($id) { return response()->json(Insight::findOrFail($id)); }
    public function insightsDestroy($id) { Insight::findOrFail($id)->delete(); return response()->json(['message'=>'Insight deleted']); }

    // ============================
    // TASKS
    // ============================
    public function tasksIndex() { return response()->json(Task::all()); }

    public function tasksStore(Request $request) {
        $request->validate([
            'id' => 'nullable|integer',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'nullable|in:low,medium,high',
            'status' => 'nullable|in:pending,in-progress,completed',
            'created_by' => 'required|integer',
            'assigned_to' => 'required|integer',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $task = Task::updateOrCreate(
            ['id' => $request->id],
            $request->only('title','description','priority','status','created_by','assigned_to','start_date','end_date')
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
            'created_by' => 'sometimes|integer',
            'assigned_to' => 'sometimes|integer',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);
        $task->update($request->all());
        return response()->json($task);
    }

    public function tasksShow($id) { return response()->json(Task::findOrFail($id)); }
    public function tasksDestroy($id) { Task::findOrFail($id)->delete(); return response()->json(['message'=>'Task deleted']); }

    // ============================
    // TASK APPROVALS
    // ============================
    public function taskApprovalsIndex() { return response()->json(TaskApproval::all()); }

    public function taskApprovalsStore(Request $request) {
        $request->validate([
            'id' => 'nullable|integer',
            'task_id' => 'required|integer',
            'approved_by' => 'required|integer',
            'status' => 'nullable|in:approved,rejected,pending',
            'remarks' => 'nullable|string',
        ]);

        $approval = TaskApproval::updateOrCreate(
            ['id' => $request->id],
            $request->only('task_id','approved_by','status','remarks')
        );

        return response()->json($approval, $request->id ? 200 : 201);
    }

    public function taskApprovalsUpdate(Request $request, $id) {
        $approval = TaskApproval::findOrFail($id);
        $request->validate([
            'task_id' => 'sometimes|integer',
            'approved_by' => 'sometimes|integer',
            'status' => 'sometimes|in:approved,rejected,pending',
            'remarks' => 'nullable|string',
        ]);
        $approval->update($request->all());
        return response()->json($approval);
    }

    public function taskApprovalsShow($id) { return response()->json(TaskApproval::findOrFail($id)); }
    public function taskApprovalsDestroy($id) { TaskApproval::findOrFail($id)->delete(); return response()->json(['message'=>'Task approval deleted']); }

}
