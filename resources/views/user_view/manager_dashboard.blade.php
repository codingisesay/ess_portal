<link rel="stylesheet" href="{{ asset('/user_end/css/pms-dashboard.css') }}">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- ========== ORGCHART PLUGIN ========== -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/orgchart/2.1.9/css/jquery.orgchart.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/orgchart/2.1.9/js/jquery.orgchart.min.js"></script>

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
                    <td>{{ $goal->title }}<br>
                        <small class="description">{{ $goal->description }}</small><br>
                       <small>
                            {{ $goal->start_date ? \Carbon\Carbon::parse($goal->start_date)->format('d/m/Y') : '—' }}
                            →
                            {{ $goal->end_date ? \Carbon\Carbon::parse($goal->end_date)->format('d/m/Y') : '—' }}
                        </small>
                    </td>
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
        <!-- <col style="width:15%"> -->
        <col style="width:30%">
    </colgroup>
    <thead>
        <tr>
            <th>Goal</th>
            <th>Type</th>
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
                    <small style="word-break: break-word;">{{ $goal->description ?? '—' }}</small><br>
                    <small>
                        {{ $goal->start_date ? \Carbon\Carbon::parse($goal->start_date)->format('d/m/Y') : '—' }}
                        →
                        {{ $goal->end_date ? \Carbon\Carbon::parse($goal->end_date)->format('d/m/Y') : '—' }}
                    </small>
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
                            @foreach(collect($allOrgGoals)->unique('org_setting_id') as $g)
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
                        value="{{ old('start_date', $activeCycle->start_date ?? '') }}"
                        min="{{ $activeCycle->start_date ?? '' }}" 
                        max="{{ $activeCycle->end_date ?? '' }}">
                    </div>
                    <div class="col-md-2">
                        <label for="customGoalEnd" class="form-label">End Date</label>
                        <input type="date" id="customGoalEnd" class="form-control" required
                         value="{{ old('end_date', $activeCycle->end_date ?? '') }}"
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
                            <td style="word-break: break-word;">{{ $task->description ?? '-' }}</td>
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
            <div class="table-fixed-header no-scrollbar-header">
                <table class="table table-bordered table-striped m-0" style="table-layout:fixed;">
                    <colgroup>
                        <col style="width:25%">
                        <col style="width:35%">
                        <col style="width:15%">
                        <col style="width:12%">
                        <col style="width:13%">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>Goal</th>
                            <th>Insight</th>
                            <th>Added By</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="table-scroll-container no-scrollbar org-insights-scroll">
                <table class="table table-bordered table-striped m-0" style="table-layout:fixed;">
                    <colgroup>
                        <col style="width:25%">
                        <col style="width:35%">
                        <col style="width:15%">
                        <col style="width:12%">
                        <col style="width:13%">
                    </colgroup>
                    <tbody>
                        @forelse($insights as $insight)
                        <tr data-insight-id="{{ $insight->id }}">
                            <td>{{ $insight->goal_title }}</td>
                            <td>
                                @if(strtolower($insight->insights_status) === 'rejected')
                                    <textarea class="form-control insight-edit" data-id="{{ $insight->id }}">{{ $insight->description }}</textarea>
                                    <!-- Aligned Save button to the right in the "Insights on Organization Goals" section after rejected goals display on Manager Dashboard. -->
                                    <div class="d-flex justify-content-end mt-1">
                                        <button class="btn btn-sm btn-success save-insight" data-id="{{ $insight->id }}">Save</button>
                                    </div>
                                @else
                                    <div class="description">{{ $insight->description }}</div>
                                @endif
                            </td>
                            <td>{{ $insight->user_name }}</td>
                            <td>{{ \Carbon\Carbon::parse($insight->created_at)->format('d/m/Y') }}</td>
                            <td>
                                @php
                                    $status = $insight->insights_status ?? 'Pending';
                                    $badgeClass = match(strtolower($status)) {
                                        'approved' => 'success',
                                        'rejected' => 'danger',
                                        'pending' => 'warning',
                                        default => 'secondary'
                                    };
                                @endphp
                                <span class="badge bg-{{ $badgeClass }}">{{ ucfirst($status) }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center">No insights available</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
                    <div class="d-flex justify-content-end my-2">
                         <button id="submitSelectedInsights" class="btn btn-primary">Submit Selected Insights for Approval</button>
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
            <div class="table-scroll-container">
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
                              <td class="text-center">
                                <!-- Button to open modal -->
                                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#bundleModal{{ $bundle->id }}">
                                    <i class="bi bi-eye"></i> View
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="bundleModal{{ $bundle->id }}" tabindex="-1" aria-labelledby="bundleModalLabel{{ $bundle->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="bundleModalLabel{{ $bundle->id }}">Bundle #{{ $bundle->id }} Details</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <table class="table table-bordered table-striped m-0">
                                                    <thead>
                                                        <tr>
                                                            <th>Title</th>
                                                            <th>Description</th>
                                                            <th>Start Date</th>
                                                            <th>End Date</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($bundle->items as $item)
                                                        <tr>
                                                            <td>{{ $item->goal->title ?? 'Custom Goal' }}</td>
                                                            <td class="description">{{ $item->goal->description ?? $bundle->description ?? 'N/A' }}</td>
                                                            <td>
                                                                {{ $item->goal->start_date ? \Carbon\Carbon::parse($item->goal->start_date)->format('d/m/Y') : 'N/A' }}
                                                            </td>
                                                            <td>
                                                                {{ $item->goal->end_date ? \Carbon\Carbon::parse($item->goal->end_date)->format('d/m/Y') : 'N/A' }}
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn  btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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

{{-- ============================
     6. Insight Bundle Approval Requests
============================= --}}
<div class="container">
  <div class="card mb-4">
    <div class="card-header bg-light"><strong>Insight Bundle Approval Requests</strong></div>
    <div class="card-body">
      @php
          $managerId = Auth::id();
          $pendingInsightBundles = \App\Models\InsightBundleApproval::with('items.insight')
                                  ->where('reporting_manager', $managerId)
                                  ->where('status', 'pending')
                                  ->get();
      @endphp

      @if($pendingInsightBundles->count() > 0)
        <div class="table-fixed-header">
          <table class="table table-bordered table-striped m-0">
            <thead>
              <tr>
                <th>Bundle ID</th>
                <th>Requested By</th>
                <th>Insights</th>
                <th>Actions</th>
              </tr>
            </thead>
          </table>
        </div>
        <div class="table-scroll-container no-scrollbar">
          <table class="table table-bordered table-striped m-0" style="table-layout:fixed;">
            <tbody>
              @foreach($pendingInsightBundles as $bundle)
              <tr data-bundle-id="{{ $bundle->id }}">
                <td>{{ $bundle->id }}</td>
                <td>{{ $bundle->requestedBy->name ?? 'N/A' }}</td>
                <td class="text-center">
                  <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#insightBundleModal{{ $bundle->id }}">
                    <i class="bi bi-eye"></i> View
                  </button>

                  {{-- Modal --}}
                  <div class="modal fade" id="insightBundleModal{{ $bundle->id }}" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Insight Bundle #{{ $bundle->id }}</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                          <table class="table table-bordered table-striped m-0">
                            <thead>
                              <tr>
                                <th>Goal</th>
                                <th>Insight</th>
                                <th>Date</th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach($bundle->items as $item)
                              <tr>
                                <td>{{ $item->insight->goal->title ?? 'N/A' }}</td>
                                <td class="description">{{ $item->insight->description }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->insight->created_at)->format('d/m/Y') }}</td>
                              </tr>
                              @endforeach
                            </tbody>
                          </table>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </td>
                <td>
                  <div class="d-flex gap-1">
                    <button class="btn btn-sm btn-success" onclick="approveInsightBundle({{ $bundle->id }})">Approve</button>
                    <button class="btn btn-sm btn-danger" onclick="rejectInsightBundle({{ $bundle->id }})">Reject</button>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @else
        <p class="text-center">No pending insight bundle requests.</p>
      @endif
    </div>
  </div>
</div>


<!-- ========== ORG CHART SECTION ========== -->
<div class="container mt-4">
    <div class="row">
        <!-- ========== ORG CHART SECTION (LEFT) ========== -->
        <div class="col-md-5" id="chart-container" style="height:600px; overflow-y:auto; border-right:1px solid #ddd; padding:10px; background:#f9f9f9; border-radius:8px;"></div>

        <!-- ========== GOALS TABLE SECTION (RIGHT) ========== -->
        <div class="col-md-7" id="goals-section" style="display:none; overflow-y:auto; max-height:600px;">
            <h5 id="employee-name" class="mb-3"></h5>
            <table class="table table-bordered table-hover table-striped">
                <thead class="table-light">
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Progress</th>
                        <th>Priority</th>
                        <th>Start → End</th>
                    </tr>
                </thead>
                <tbody id="goals-body"></tbody>
            </table>
        </div>
    </div>
</div>



<style>
/* Modern org chart styles */
#chart-container .orgchart {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    padding: 15px;
}

#chart-container .orgchart .node {
    border: 2px solid #007bff;
    border-radius: 8px;
    padding: 10px 15px;
    background: #fff;
    color: #333;
    font-weight: 500;
    transition: transform 0.2s, box-shadow 0.2s;
    cursor: pointer;
    min-width: 120px;
    text-align: center;
}

#chart-container .orgchart .node:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    border-color: #0056b3;
}

.employee-node.selected {
    background-color: #007bff;
    color: #fff;
    border-color: #0056b3;
}

#chart-container::-webkit-scrollbar {
    width: 8px;
}

#chart-container::-webkit-scrollbar-thumb {
    background: rgba(0,0,0,0.2);
    border-radius: 4px;
}
</style>

<script>
document.addEventListener("DOMContentLoaded", function() {
    let loggedInManagerId = {{ Auth::id() }};

    fetch('{{ route('manager.hierarchy') }}')
        .then(res => res.json())
        .then(data => {
            if (!data) {
                document.getElementById('chart-container').innerHTML =
                    '<p class="text-muted">No hierarchy data found.</p>';
                return;
            }
            renderChart(data);

            const managerNode = document.querySelector(`.employee-node[data-id='${loggedInManagerId}']`);
            if (managerNode) {
                managerNode.click();
            }
        })
        .catch(err => console.error('Error fetching hierarchy:', err));

    function renderChart(data) {
        $('#chart-container').orgchart({
            'data': data,
            'nodeContent': 'title',
            'verticalLevel': true,
            'createNode': function($node, nodeData) {
                $node.addClass('employee-node');
                $node.attr('data-id', nodeData.id);

                $node.on('click', function(e) {
                    e.stopPropagation();
                    $('.employee-node').removeClass('selected');
                    $node.addClass('selected');
                    loadUserGoals(nodeData.id, nodeData.name);
                });
            }
        });
    }

    async function loadUserGoals(userId, name) {
        try {
            const url = `{{ url('/manager') }}/${userId}/goals`;
            const res = await fetch(url);

            if (!res.ok) throw new Error(`Failed to fetch goals (${res.status})`);
            const goals = await res.json();

            const goalsSection = document.getElementById("goals-section");
            goalsSection.style.display = 'block';
            document.getElementById("employee-name").innerText = `${name}'s Goals`;

            const tbody = document.getElementById("goals-body");
            tbody.innerHTML = '';

            if (!goals.length) {
                tbody.innerHTML = '<tr><td colspan="6" class="text-center text-muted">No goals found</td></tr>';
                return;
            }

            goals.forEach(g => {
                const startDate = g.start_date ? new Date(g.start_date).toLocaleDateString('en-GB') : '—';
                const endDate = g.end_date ? new Date(g.end_date).toLocaleDateString('en-GB') : '—';
                const priority = g.priority ? g.priority.charAt(0).toUpperCase() + g.priority.slice(1) : 'Medium';

                tbody.innerHTML += `
                    <tr>
                        <td>${g.title ?? ''}</td>
                        <td>${g.description ?? ''}</td>
                        <td>${g.status ?? ''}</td>
                        <td>${g.progress ?? 0}%</td>
                        <td>${priority}</td>
                        <td>${startDate} → ${endDate}</td>
                    </tr>
                `;
            });

        } catch (err) {
            console.error(err);
            alert('Error loading goals: ' + err.message);
        }
    }
});
</script>



<!-- added the script for the edit of the insignt when it is rejected  -->
<script>
document.addEventListener('click', async function(e) {
    if (e.target.classList.contains('save-insight')) {
        const id = e.target.dataset.id;
        const textarea = document.querySelector(`.insight-edit[data-id="${id}"]`);
        const description = textarea.value.trim();

        if (!description) {
            Swal.fire({
                icon: 'warning',
                title: 'Empty Field',
                text: 'Description cannot be empty.',
                confirmButtonText: 'OK'
            });
            return;
        }

        try {
            const res = await fetch(`/insights/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ description })
            });

            if (!res.ok) throw new Error('Failed to update');

            const data = await res.json();

            Swal.fire({
                icon: 'success',
                title: 'Updated!',
                text: 'Insight updated successfully.',
                timer: 1500,
                showConfirmButton: false
            });

            // Reload after success (slight delay to let Swal show)
            setTimeout(() => {
                location.reload();
            }, 1500);

        } catch (err) {
            console.error(err);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: err.message || 'Something went wrong!',
            });
        }
    }
});
</script>


<script>
async function approveInsightBundle(id) {
    try {
        // 1️⃣ Ask for star rating (1-5 stars)
        const { value: rating } = await Swal.fire({
            title: 'Rate these insights',
            html: `
                <div id="starRating" style="font-size: 2rem; display: flex; justify-content: center; gap: 5px;">
                    <span data-value="1" style="cursor:pointer;">☆</span>
                    <span data-value="2" style="cursor:pointer;">☆</span>
                    <span data-value="3" style="cursor:pointer;">☆</span>
                    <span data-value="4" style="cursor:pointer;">☆</span>
                    <span data-value="5" style="cursor:pointer;">☆</span>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Submit Rating',
            cancelButtonText: 'Skip Rating',
            preConfirm: () => {
                return document.querySelector('#starRating').dataset.selected;
            },
            didOpen: () => {
                const stars = document.querySelectorAll('#starRating span');
                stars.forEach(star => {
                    star.addEventListener('mouseenter', () => {
                        const val = parseInt(star.dataset.value);
                        stars.forEach((s, i) => {
                            s.textContent = i < val ? '★' : '☆';
                        });
                    });
                    star.addEventListener('click', () => {
                        const val = parseInt(star.dataset.value);
                        document.querySelector('#starRating').dataset.selected = val;
                        stars.forEach((s, i) => {
                            s.textContent = i < val ? '★' : '☆';
                        });
                    });
                    star.addEventListener('mouseleave', () => {
                        const selected = parseInt(document.querySelector('#starRating').dataset.selected || 0);
                        stars.forEach((s, i) => {
                            s.textContent = i < selected ? '★' : '☆';
                        });
                    });
                });
            }
        });

        // 2️⃣ Prepare payload
        const payload = { status: 'approved' };
        if (rating) payload.rating = rating;

        // 3️⃣ Send approve + rating to backend
        const res = await fetch(`/insights/bundles/${id}/approve`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(payload)
        });

        if (!res.ok) {
            const err = await res.json().catch(() => ({}));
            throw new Error(err.message || 'Failed to approve');
        }

        const data = await res.json();

        // 4️⃣ Show success message
        Swal.fire({
            icon: 'success',
            title: 'Approved!',
            text: data.message,
            timer: 2000,
            showConfirmButton: false
        });

        // 5️⃣ Remove row
        document.querySelector(`tr[data-bundle-id="${id}"]`)?.remove();

    } catch (err) {
        console.error(err);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: err.message || 'Something went wrong',
        });
    }
}
function rejectInsightBundle(id) {
    Swal.fire({
        title: 'Reject Bundle',
        input: 'textarea',
        inputLabel: 'Reason / Remarks',
        showCancelButton: true,
        confirmButtonText: 'Reject',
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/insights/bundles/${id}/reject`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    status: 'rejected', // dynamic status
                    remarks: result.value // user input
                })
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
                document.querySelector(`tr[data-bundle-id="${id}"]`).remove();
            });
        }
    });
}
</script>




<script>
document.getElementById('submitSelectedInsights')?.addEventListener('click', async function() {
    // Collect all insight IDs from the table
    const allInsights = Array.from(document.querySelectorAll('tr[data-insight-id]'))
        .map(row => row.getAttribute('data-insight-id'));

    if (!allInsights.length) {
        Swal.fire({
            icon: 'warning',
            title: 'No insights available',
            text: 'There are no insights to submit.',
            confirmButtonColor: '#8A3366'
        });
        return;
    }

    try {
        // Disable button to prevent multiple clicks
        const submitBtn = this;
        submitBtn.disabled = true;
        submitBtn.textContent = 'Submitting...';

        const res = await fetch('/insights/bundles', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ insight_ids: allInsights })
        });

        if (!res.ok) {
            const err = await res.json().catch(() => ({}));
            throw new Error(err.message || 'Failed to submit');
        }

        const data = await res.json();

        Swal.fire({
            icon: 'success',
            title: 'Submitted!',
            text: `Bundle #${data.bundle_id} has been sent for approval.`,
            confirmButtonColor: '#8A3366',
            timer: 2000,
            showConfirmButton: false
        });

        // Optionally reload to refresh table
        setTimeout(() => location.reload(), 1500);

    } catch (err) {
        console.error(err);
        Swal.fire({
            icon: 'error',
            title: 'Submission failed',
            text: err.message || 'Something went wrong.',
            confirmButtonColor: '#8A3366'
        });
    }
});
</script>



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

        try {
            const response = await fetch("{{ url('/insights') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
                },
                body: formData
            });

            if (!response.ok) throw new Error('Failed to save insight');

            const data = await response.json();
            console.log("Insight saved:", data);

            insightModal.hide();

            Swal.fire({
                icon: 'success',
                title: 'Saved!',
                text: 'Insight saved successfully!',
                confirmButtonColor: '#8A3366',
                timer: 2000,
                showConfirmButton: false
            });

        } catch (err) {
            console.error(err);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to save insight.',
                confirmButtonColor: '#8A3366'
            });
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
