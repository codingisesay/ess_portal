<div class="container">
    <h2>Manager Dashboard</h2>

   {{-- ============================
     1. Goals Created by Organization
============================= --}}
<div class="card mb-4">
    <div class="card-header bg-light"><strong>Goals Created by Organization</strong></div>
    <div class="card-body">
       <table class="table table-bordered table-striped" id="orgGoalsTable">
            <thead class="table-light">
                <tr>
                    <th>Goal</th>
                    <th>Period</th>
                    <th>Priority</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($allOrgGoals as $goal)
                <tr>
                    <td>{{ $goal->title }}</td>
                    <td>{{ $goal->period_name }}</td>
                    <td>{{ ucfirst($goal->priority) }}</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-primary"
                            onclick="addToBundle({{ $goal->id }}, '{{ addslashes($goal->title) }}', '{{ $goal->org_setting_id }}', 'Organization', this)">
                            Add
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        </table>
    </div>
</div>

{{-- ============================
     2. Additional Goals (Self-Created / Selected Org Goals)
============================= --}}
<div class="card mb-4">
    <div class="card-header bg-light"><strong>Additional Goals / Selected Org Goals</strong></div>
    <div class="card-body">
     <form id="bundleForm" method="POST" action="{{ route('goal-bundles.submit') }}">
    @csrf

    {{-- Always send bundle_id once (if exists) --}}
    <input type="hidden" name="bundle_id" value="{{ $submittedGoals[0]->bundle_id ?? '' }}">

   <table class="table table-bordered" id="bundleTable">
    <thead class="table-light">
        <tr>
            <th>Goal</th>
            <th>Type / Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($submittedGoals ?? [] as $goal)
        <tr>
            <td>
                @if($goal->approval_status === 'rejected')
                    {{-- Pass existing bundle_id for resubmission --}}
                    <input type="hidden" name="bundle_id" value="{{ $goal->bundle_id ?? '' }}">

                    {{-- Editable fields for rejected goals --}}
                    <input type="text" 
                           name="custom_titles[{{ $goal->goal_id }}]" 
                           value="{{ $goal->title }}" 
                           class="form-control mb-1" 
                           placeholder="Goal Title">

                    <textarea name="custom_descriptions[{{ $goal->goal_id }}]" 
                              class="form-control mb-1" 
                              placeholder="Goal Description">{{ $goal->description ?? '' }}</textarea>

                    <input type="date" 
                           name="custom_start[{{ $goal->goal_id }}]" 
                           value="{{ $goal->start_date }}" 
                           class="form-control mb-1">

                    <input type="date" 
                           name="custom_end[{{ $goal->goal_id }}]" 
                           value="{{ $goal->end_date }}" 
                           class="form-control">

                    <input type="hidden" name="goal_ids[]" value="{{ $goal->goal_id }}">
                    <input type="hidden" name="org_setting_ids[{{ $goal->goal_id }}]" value="{{ $goal->org_setting_id }}">
                @else
                    {{-- Read-only display for approved / pending goals --}}
                    <strong>{{ $goal->title }}</strong><br>
                    @if(!empty($goal->description))
                        <small>{{ $goal->description }}</small><br>
                    @endif
                    <small>{{ $goal->start_date ?? '—' }} → {{ $goal->end_date ?? '—' }}</small>

                    <input type="hidden" name="goal_ids[]" value="{{ $goal->goal_id }}">
                    <input type="hidden" name="org_setting_ids[{{ $goal->goal_id }}]" value="{{ $goal->org_setting_id }}">
                @endif
            </td>
            <td>{{ ucfirst($goal->approval_status) }}</td>
            <td>
                @if($goal->approval_status === 'rejected')
                    <button type="button" class="btn btn-sm btn-danger" onclick="this.closest('tr').remove()">Remove</button>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>


    {{-- Submit whole bundle --}}
    <button type="submit" class="btn btn-success mt-2">
        Submit Selected Goals for Approval
    </button>
</form>



        {{-- Add Custom Goal --}}
        <div class="mt-3">
            <h6>Create Extra Goal</h6>
            <div class="row g-2">
                <div class="col-md-4">
                    <select id="customGoalOrg" class="form-control">
                        <option value="">Select Period</option>
                        @foreach($allOrgGoals as $g)
                            <option value="{{ $g->org_setting_id }}">{{ $g->period_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="text" id="customGoalTitle" class="form-control" placeholder="Goal Title">
                </div>
                  <div class="col-md-3">
                    <input type="date" id="customGoalStart" class="form-control" placeholder="Start Date">
                </div>
                <div class="col-md-3">
                    <input type="date" id="customGoalEnd" class="form-control" placeholder="End Date">
                </div>
                <div class="col-md-4">
                    <button type="button" class="btn btn-secondary w-100" onclick="addCustomGoal()">Add Custom Goal</button>
                </div>
            </div>
        </div>
    </div>
</div>

    {{-- 3. Task List --}}
    <div class="card mb-4">
        <div class="card-header bg-light"><strong>Task List (Own Tasks)</strong></div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th>Task</th>
                        <th>Status</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ownTasks as $task)
                    <tr>
                        <td>{{ $task->title }}</td>
                        <td>{{ ucfirst($task->status) }}</td>
                        <td><a href="{{ url('/tasks/'.$task->id) }}" class="btn btn-sm btn-warning">Edit</a></td>
                        <td>
                            <form action="{{ url('/tasks/'.$task->id) }}" method="POST" style="display:inline-block">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center">No tasks yet</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- 4. Insights Section --}}
    <div class="card mb-4">
        <div class="card-header bg-light"><strong>Insights on Organization Goals</strong></div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th>Goal</th>
                        <th>Insight</th>
                        <th>Added By</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($insights as $insight)
                    <tr>
                        <td>{{ $insight->goal_title }}</td>
                        <td>{{ $insight->description }}</td>
                        <td>{{ $insight->user_name }}</td>
                        <td>{{ $insight->created_at }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center">No insights available</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    {{-- ============================
     5. Goal Bundle Approval Requests
============================= --}}
<div class="card mb-4">
    <div class="card-header bg-light"><strong>Goal Bundle Approval Requests</strong></div>
    <div class="card-body">
        @php
            $managerId = Auth::id();
            $pendingBundles = \App\Models\GoalBundleApproval::with('items.goal')
                                ->where('reporting_manager', $managerId)
                                ->where('status', 'pending')
                                ->get();
        @endphp

        @if($pendingBundles->count() > 0)
            <table class="table table-bordered table-striped" id="approvalTable">
                <thead class="table-light">
                    <tr>
                        <th>Bundle ID</th>
                        <th>Requested By</th>
                        <th>Goals</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendingBundles as $bundle)
                        <tr data-bundle-id="{{ $bundle->id }}">
                            <td>{{ $bundle->id }}</td>
                            <td>{{ $bundle->requestedBy->name ?? 'N/A' }}</td>
                            <td>
                                <ul>
                                    @foreach($bundle->items as $item)
                                        <li>{{ $item->goal->title ?? 'Custom Goal' }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-success" onclick="approveBundle({{ $bundle->id }}, 'approved')">Approve</button>
                               <button class="btn btn-sm btn-danger" onclick="rejectBundle({{ $bundle->id }})">Reject</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-center">No pending goal bundle requests.</p>
        @endif
    </div>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function approveBundle(id) {
    fetch(`/manager/bundles/${id}/approve`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
        }
    })
    .then(res => res.json())
    .then(data => {
        Swal.fire({
            icon: 'success',
            title: 'Approved!',
            text: data.message,
            timer: 2000,
            showConfirmButton: false
        });

        // remove the row from table
        document.querySelector(`tr[data-bundle-id="${id}"]`).remove();
    })
    .catch(err => {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Something went wrong!'
        });
    });
}

function rejectBundle(id) {
    fetch(`/manager/bundles/${id}/reject`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
        }
    })
    .then(res => res.json())
    .then(data => {
        Swal.fire({
            icon: 'warning',
            title: 'Rejected!',
            text: data.message,
            timer: 2000,
            showConfirmButton: false
        });

        // remove the row from table
        document.querySelector(`tr[data-bundle-id="${id}"]`).remove();
    })
    .catch(err => {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Something went wrong!'
        });
    });
}
</script>


<script>
    let bundleTableBody = document.querySelector("#bundleTable tbody");
let orgGoalsTableBody = document.querySelector("#orgGoalsTable tbody");

// Add organization goal to bundle and remove from Org Goals table
function addToBundle(goalId, title, orgSettingId, type, button) {
    if (!bundleTableBody || !orgGoalsTableBody) return;

    if (document.querySelector(`input[value="${goalId}"]`)) {
        alert("This goal is already added.");
        return;
    }

    let row = `<tr>
        <td>
            ${title}
            <input type="hidden" name="goal_ids[]" value="${goalId}">
            <input type="hidden" name="org_setting_ids[${goalId}]" value="${orgSettingId}">
        </td>
        <td>${type}</td>
        <td>
            <button type="button" class="btn btn-sm btn-danger" onclick="this.closest('tr').remove()">Remove</button>
        </td>
    </tr>`;
    bundleTableBody.insertAdjacentHTML('beforeend', row);

    // Remove from Org Goals table
    if(button) button.closest('tr').remove();
}

// Add custom goal
function addCustomGoal() {
    let title = document.getElementById('customGoalTitle').value.trim();
    let orgSettingId = document.getElementById('customGoalOrg').value;
    let startDate = document.getElementById('customGoalStart').value;
    let endDate = document.getElementById('customGoalEnd').value;

    if (!title || !orgSettingId || !startDate || !endDate) {
        alert("Please fill all custom goal fields.");
        return;
    }

    let customId = 'custom-' + Date.now();
    let row = `<tr>
        <td>
            ${title}
            <input type="hidden" name="goal_ids[]" value="${customId}">
            <input type="hidden" name="org_setting_ids[${customId}]" value="${orgSettingId}">
            <input type="hidden" name="custom_titles[${customId}]" value="${title}">
            <input type="hidden" name="custom_start[${customId}]" value="${startDate}">
            <input type="hidden" name="custom_end[${customId}]" value="${endDate}">
        </td>
        <td>Custom</td>
        <td>
            <button type="button" class="btn btn-sm btn-danger" onclick="this.closest('tr').remove()">Remove</button>
        </td>
    </tr>`;
    bundleTableBody.insertAdjacentHTML('beforeend', row);

    // Reset fields
    document.getElementById('customGoalTitle').value = '';
    document.getElementById('customGoalOrg').value = '';
    document.getElementById('customGoalStart').value = '';
    document.getElementById('customGoalEnd').value = '';
}

// Submit bundle
document.getElementById('bundleForm').addEventListener('submit', function(e) {
    e.preventDefault();

    if(bundleTableBody.children.length === 0) {
        alert("No goals selected to submit!");
        return;
    }

    let formData = new FormData(this);

    fetch(this.action, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        Swal.fire({
            icon: 'success',
            title: 'Submitted!',
            text: data.message || 'Goals submitted for approval!',
            timer: 2000,
            showConfirmButton: false
        });

        // Refresh the page once after alert
        setTimeout(() => {
            location.reload();
        }, 2000); // wait 2 seconds for the alert to show
    })
    .catch(err => {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Something went wrong!'
        });
    });
});


</script>