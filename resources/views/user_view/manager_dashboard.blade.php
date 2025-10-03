<link rel="stylesheet" href="{{ asset('/user_end/css/pms-dashboard.css') }}">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container">
    <h2>Manager Dashboard</h2>
   {{-- ============================
     1. Goals Created by Organization
============================= --}}
<div class="card mb-4">
    <div class="card-header bg-light"><strong>Goals Created by Organization</strong></div>
    <div class="table-fixed-header">
        <table class="table table-bordered table-striped m-0" style="table-layout:fixed;">
            <colgroup>
                <col style="width:40%">
                <col style="width:20%">
                <col style="width:20%">
                <col style="width:20%">
            </colgroup>
            <thead>
                <tr>
                    <th>Goal</th>
                    <th>Period</th>
                    <th>Priority</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
    <div class="table-scroll-container no-scrollbar">
        <table class="table table-bordered table-striped m-0" style="table-layout:fixed;">
            <colgroup>
                <col style="width:40%">
                <col style="width:20%">
                <col style="width:20%">
                <col style="width:20%">
            </colgroup>
            <tbody id="orgGoalsTable">
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
    </div>
        </div>
    </div>
    </div>
</div>

<!-- Create Own Task Modal -->
<div class="modal fade" id="createOwnTaskModal" tabindex="-1" aria-labelledby="createOwnTaskModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header edit-goal-header text-white">
        <h5 class="modal-title" id="createOwnTaskModalLabel">Create Task</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ url('/tasks') }}" method="POST">
        @csrf
        <div class="modal-body">
          <!-- Row 1: Title, Priority -->
          <div class="row g-3 mb-2">
            <div class="col-md-8">
              <label for="own_task_title" class="form-label">Title</label>
              <input type="text" id="own_task_title" name="title" class="form-control" placeholder="Task title"
              required minlength="3" maxlength="100"
              title="Task title must be between 3 and 100 characters" pattern=".*\S.*"   
              required>
            </div>
            <div class="col-md-4">
              <label for="own_task_priority" class="form-label">Priority</label>
              <select id="own_task_priority" name="priority" class="form-control" required>
                <option value="low">Low</option>
                <option value="medium" selected>Medium</option>
                <option value="high">High</option>
              </select>
                <div class="invalid-feedback">Please select a priority.</div>
            </div>
          </div>

          <!-- Row 2: Start & End Dates -->
            <div class="row g-3 mb-2">
            <div class="col-md-6">
                <label for="own_task_start" class="form-label">Start Date</label>
                <input type="date" 
                    id="own_task_start" 
                    name="start_date" 
                    class="form-control" 
                    required
                    min="{{ $activeCycle->start_date ?? '' }}" 
                    max="{{ $activeCycle->end_date ?? '' }}">
            </div>
            <div class="col-md-6">
                <label for="own_task_end" class="form-label">End Date</label>
                <input type="date" 
                    id="own_task_end" 
                    name="end_date" 
                    class="form-control" 
                    required
                    min="{{ $activeCycle->start_date ?? '' }}" 
                    max="{{ $activeCycle->end_date ?? '' }}">
            </div>
            </div>


          <!-- Row 3: Description -->
          <div class="row g-3 mb-2">
            <div class="col-12">
              <label for="own_task_description" class="form-label">Description</label>
              <textarea id="own_task_description" name="description" class="form-control" placeholder="Task description"required maxlength="500"
                        pattern=".*\S.*"></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Create</button>
        </div>
      </form>
    </div>
  </div>
</div>


{{-- ============================
     2. Additional Goals (Self-Created / Selected Org Goals)
============================= --}}
<div class="section-pad-x">
<div class="card mb-4">
    <div class="card-header bg-light"><strong>Additional Goals / Selected Org Goals</strong></div>
    <div class="card-body">
    @csrf
     <form id="bundleForm" method="POST" action="{{ route('goal-bundles.submit') }}">
    {{-- Always send bundle_id once (if exists) --}}
    <input type="hidden" name="bundle_id" value="{{ $submittedGoals[0]->bundle_id ?? '' }}">

   <div class="table-fixed-header">
   <table class="table table-bordered table-striped m-0">
    <colgroup>
        <col style="width:40%">
        <col style="width:15%">
        <col style="width:15%">
        <col style="width:30%">
    </colgroup>
    <thead>
        <tr>
            <th>Goal</th>
            <th>Type</th>
            <th>Weightage</th>
            <th>Actions</th>
        </tr>
    </thead>
   </table>
   </div>
   <div class="table-scroll-container">
   <table class="table table-bordered table-striped m-0" id="bundleTable">
    <colgroup>
        <col style="width:40%">
        <col style="width:15%">
        <col style="width:15%">
        <col style="width:30%">
    </colgroup>
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
                           class="form-control mb-1"
                            min="{{ $activeCycle->start_date ?? '' }}" 
                            max="{{ $activeCycle->end_date ?? '' }}">

                    <input type="date" 
                           name="custom_end[{{ $goal->goal_id }}]" 
                           value="{{ $goal->end_date }}" 
                           class="form-control"
                          min="{{ $activeCycle->start_date ?? '' }}" 
                          max="{{ $activeCycle->end_date ?? '' }}">

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
            @elseif($goal->approval_status === 'approved')
                <button type="button" 
                        class="btn btn-sm btn-primary add-insight-btn" 
                        data-goal-id="{{ $goal->goal_id }}"
                        data-goal-title="{{ $goal->title }}">
                    Add Insight
                </button>
            @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>


    {{-- Submit whole bundle --}}
    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-success mt-2">
            Submit Selected Goals for Approval
        </button>
    </div>
</form>



        {{-- Add Custom Goal --}}
        <div class="mt-3">
            <h6>Create Extra Goal</h6>
            <form onsubmit="addCustomGoal(); return false;">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label for="customGoalOrg" class="form-label">Period</label>
                        <select id="customGoalOrg" class="form-control" required>
                            <option value="">Select Period</option>
                            @foreach($allOrgGoals as $g)
                                <option value="{{ $g->org_setting_id }}">{{ $g->period_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="customGoalTitle" class="form-label">Goal Title</label>
                        <input type="text" id="customGoalTitle" class="form-control" placeholder="e.g., Improve client onboarding" required>
                    </div>
                    <div class="col-md-2">
                        <label for="customGoalStart" class="form-label">Start Date</label>
                        <input type="date" id="customGoalStart" class="form-control" required
                        min="{{ $activeCycle->start_date ?? '' }}" 
                        max="{{ $activeCycle->end_date ?? '' }}">
                    </div>
                    <div class="col-md-2">
                        <label for="customGoalEnd" class="form-label">End Date</label>
                        <input type="date" id="customGoalEnd" class="form-control" required
                        min="{{ $activeCycle->start_date ?? '' }}" 
                        max="{{ $activeCycle->end_date ?? '' }}">
                    </div>
                    <div class="col-12">
                        <label for="description" class="form-label">Description</label>
                        <textarea id="description" name="description" class="form-control" placeholder="Description"></textarea>
                    </div>
                
                </div>
                <div class="row mt-2">
                    <div class="col-12 d-flex justify-content-end">
                        <button type="submit" class="btn btn-secondary">Add Custom Goal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

    {{-- 3. Task List --}}
    <div class="section-pad-x">
    <div class="card mb-4">
        <div class="card-header bg-light"><strong>Create Own Task</strong></div>
        <div class="card-body">
            <div class="d-flex justify-content-end mb-2">
                <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#createOwnTaskModal">Create</button>
            </div>
            <div class="table-scroll">
                <table class="table table-bordered table-striped m-0" style="table-layout:fixed;">
                    <colgroup>
                        <col style="width:25%">
                        <col style="width:15%">
                        <col style="width:20%">
                        <col style="width:20%">
                        <col style="width:30%">
                        <col style="width:10%">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>Task</th>
                            <th>Status</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Description</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($ownTasks as $task)
                        <tr>
                            <td>{{ $task->title }}</td>
                            <td>{{ ucfirst($task->status) }}</td>
                            <td>{{ $task->start_date ? \Carbon\Carbon::parse($task->start_date)->format('d M Y') : '-' }}</td>
                            <td>{{ $task->start_date ? \Carbon\Carbon::parse($task->end_date)->format('d M Y') : '-' }}</td>
                            <td>{{ $task->description ?? '-' }}</td>
                            <td>
                                <form action="{{ url('/tasks/'.$task->id) }}" method="POST" style="display:inline-block">
                                    @csrf 
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center">No tasks yet</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>

    <!-- Add Insight Modal -->
<div class="modal fade" id="insightModal" tabindex="-1" aria-labelledby="insightModalLabel" aria-hidden="true">
  <div class="modal-dialog">
   <form id="insightForm">
    @csrf
    <input type="hidden" name="id" id="insight_id"> <!-- for editing -->
    <input type="hidden" name="goal_id" id="insight_goal_id">
    
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Insight for <span id="insight_goal_title"></span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
            <label for="insight_description" class="form-label">Insight</label>
            <textarea name="description" id="insight_description" class="form-control" rows="4" required></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Save Insight</button>
      </div>
    </div>
</form>

  </div>
</div>


    {{-- 4. Insights Section --}}
    <div class="section-pad-x">
    <div class="card mb-4">
        <div class="card-header bg-light"><strong>Insights on Organization Goals</strong></div>
        <div class="card-body">
            <div class="table-scroll">
            <table class="table table-bordered table-striped m-0">
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
<div class="container">
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
            <div class="table-fixed-header">
                <table class="table table-bordered table-striped m-0" style="table-layout:fixed;">
                    <colgroup>
                        <col style="width:15%">
                        <col style="width:20%">
                        <col style="width:55%">
                        <col style="width:10%">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>Bundle ID</th>
                            <th>Requested By</th>
                            <th>Goals</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="table-scroll-container no-scrollbar">
                <table class="table table-bordered table-striped m-0" id="approvalTable" style="table-layout:fixed;">
                    <colgroup>
                        <col style="width:15%">
                        <col style="width:20%">
                        <col style="width:55%">
                        <col style="width:10%">
                    </colgroup>
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
                                <div class="d-flex flex-wrap gap-1">
                                    <button class="btn btn-sm btn-success" onclick="approveBundle({{ $bundle->id }}, 'approved')">Approve</button>
                                    <button class="btn btn-sm btn-danger" onclick="rejectBundle({{ $bundle->id }})">Reject</button>
                                </div>
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


<script>
   document.addEventListener("DOMContentLoaded", function () {
    const insightModal = new bootstrap.Modal(document.getElementById('insightModal'));
    const form = document.getElementById("insightForm");

    // When "Add Insight" button is clicked
    document.querySelectorAll(".add-insight-btn").forEach(btn => {
        btn.addEventListener("click", function () {
            document.getElementById("insight_id").value = ""; // reset (new)
            document.getElementById("insight_goal_id").value = this.dataset.goalId;
            document.getElementById("insight_goal_title").textContent = this.dataset.goalTitle;
            document.getElementById("insight_description").value = ""; // clear old text
            insightModal.show();
        });
    });

    // Handle submit
    form.addEventListener("submit", async function (e) {
        e.preventDefault();

        const formData = new FormData(form);

        const response = await fetch("{{ url('/insights') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
            },
            body: formData
        });

        if (response.ok) {
            const data = await response.json();
            console.log("Insight saved:", data);

            insightModal.hide();

            // Optional: dynamically update UI without reload
            alert("Insight saved successfully!");
        } else {
            alert("Error saving insight!");
        }
    });
});


</script>

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
let orgGoalsTableBody = document.querySelector("#orgGoalsTable");

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
