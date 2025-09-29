<div class="card p-3 shadow-sm">
    <h4 class="mb-3">Employee Dashboard</h4>

    {{-- Assigned Goals --}}
    <div class="mb-4">
        <h5>Your Assigned Goals</h5>
        @if($assignedGoals->isEmpty())
            <p class="text-muted">No goals assigned yet.</p>
        @else
            <ul class="list-group">
                @foreach($assignedGoals as $goal)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $goal->goal_title }}
                        <span class="badge bg-primary">{{ ucfirst($goal->goal_status) }}</span>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    {{-- Your Tasks --}}
    <div class="mb-4">
        <h5>Your Tasks</h5>
        @if($ownTasks->isEmpty())
            <p class="text-muted">No tasks assigned yet.</p>
        @else
            <ul class="list-group">
                @foreach($ownTasks as $task)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $task->title }}
                        <span class="badge bg-secondary">{{ ucfirst($task->status) }}</span>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    {{-- Your Submitted Goals --}}
    <div>
        <h5>Submitted Goals</h5>
        @if($submittedGoals->isEmpty())
            <p class="text-muted">No goals submitted yet.</p>
        @else
            <ul class="list-group">
                @foreach($submittedGoals as $goal)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $goal->title }}
                        <span class="badge bg-info">{{ ucfirst($goal->approval_status) }}</span>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
