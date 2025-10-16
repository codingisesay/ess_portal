<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<div class="card p-3 shadow-sm">
    <h4 class="mb-3">Employee Dashboard</h4>

   {{-- =============================
     Goals (Yours + Manager's)
============================= --}}
<div class="mb-4">
    <h5><i class="fas fa-bullseye text-primary"></i> Goals</h5>
    @if($allOrgGoals->isEmpty())
        <p class="text-muted">No goals assigned yet.</p>
    @else
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>Goal Title</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($allOrgGoals as $goal)
                    <tr>
                        <td>
                            <strong>{{ $goal->title }}</strong>
                            <br>
                            <small class="text-muted">{{ $goal->description ?? 'No description' }}</small>
                        </td>
                        <td>
                            {{-- Create Task Button --}}
                            <button class="btn btn-sm btn-success"
                                    onclick="openTaskModal({{ $goal->id }}, '{{ $goal->title }}')">
                                <i class="fas fa-plus"></i> Create Task
                            </button>

                            {{-- Add Insight Button --}}
                            <button class="btn btn-sm btn-primary add-insight-btn"
                                    data-goal-id="{{ $goal->id }}"
                                    data-goal-title="{{ $goal->title }}">
                                <i class="fas fa-lightbulb"></i> Add Insight
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

<!-- Add Insight Modal -->
<div class="modal fade" id="insightModal" tabindex="-1" aria-labelledby="insightModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="insightForm">
      @csrf
      <input type="hidden" name="id" id="insight_id"> <!-- for editing existing insight -->
      <input type="hidden" name="goal_id" id="insight_goal_id"> <!-- goal ID for new insight -->

      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Insight for <span id="insight_goal_title"></span></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label for="insight_description" class="form-label">Insight</label>
            <textarea name="description" id="insight_description" class="form-control" rows="4" required maxlength="200"></textarea>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Save Insight</button>
        </div>
      </div>
    </form>
  </div>
</div>


<script>
document.querySelectorAll(".add-insight-btn").forEach(btn => {
    btn.addEventListener("click", function () {
        document.getElementById("insight_id").value = ""; // new insight
        document.getElementById("insight_goal_id").value = this.dataset.goalId;
        document.getElementById("insight_goal_title").textContent = this.dataset.goalTitle;
        document.getElementById("insight_description").value = ""; // clear previous text
        new bootstrap.Modal(document.getElementById('insightModal')).show();
    });
});

// Handle form submission
document.getElementById("insightForm").addEventListener("submit", async function(e) {
    e.preventDefault();
    const formData = new FormData(this);

    try {
        const response = await fetch("{{ url('/insights') }}", {
            method: "POST",
            headers: { "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value },
            body: formData
        });

        if (response.ok) {
            const data = await response.json(); // if backend returns JSON
            new bootstrap.Modal(document.getElementById('insightModal')).hide();

            Swal.fire({
                icon: 'success',
                title: 'Saved!',
                text: data.message || 'Insight saved successfully!',
                timer: 2000,
                showConfirmButton: false
            });

            setTimeout(() => {
                location.reload(); // optional refresh to show new insight
            }, 2000);
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to save insight. Please try again!'
            });
        }
    } catch (err) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Something went wrong!'
        });
    }
});
</script>

    {{-- =============================
         Your Tasks
    ============================= --}}
    <div class="mb-4">
        <h5><i class="fas fa-tasks text-secondary"></i> Your Tasks</h5>
        @if($ownTasks->isEmpty())
            <p class="text-muted">No tasks assigned yet.</p>
        @else
            <ul class="list-group">
                @foreach($ownTasks as $task)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $task->title }}</strong>
                            <br>
                            <small class="text-muted">Under Goal: {{ $task->goal_title ?? '—' }}</small>
                        </div>
                        <span class="badge bg-secondary">{{ ucfirst($task->status) }}</span>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    {{-- ============================
     4. Insights Section
============================= --}}
<div class="section-pad-x">
    <div class="card mb-4">
        <div class="card-header bg-light">
            <strong>Your Submitted Insights</strong>
        </div>
        <div class="card-body">

            {{-- Fixed header --}}
            <div class="table-fixed-header no-scrollbar-header">
                <table class="table table-bordered table-striped m-0" style="table-layout:fixed;">
                    <colgroup>
                        <col style="width:25%">
                        <col style="width:40%">
                        <col style="width:15%">
                        <col style="width:10%">
                        <col style="width:10%">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>Goal</th>
                            <th>Insight</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Rating</th>
                        </tr>
                    </thead>
                </table>
            </div>

            {{-- Scrollable body --}}
            <div class="table-scroll-container no-scrollbar org-insights-scroll">
                <table class="table table-bordered table-striped m-0" style="table-layout:fixed;">
                    <colgroup>
                        <col style="width:25%">
                        <col style="width:40%">
                        <col style="width:15%">
                        <col style="width:10%">
                        <col style="width:10%">
                    </colgroup>
                    <tbody>
                        @forelse($insights as $insight)
                        <tr data-insight-id="{{ $insight->id }}">
                            {{-- Goal Title --}}
                            <td>{{ $insight->goal_title }}</td>

                            {{-- Insight Description --}}
                            <td>
                                @if(strtolower($insight->insights_status) === 'rejected')
                                    <textarea class="form-control insight-edit" data-id="{{ $insight->id }}">{{ $insight->description }}</textarea>
                                    <div class="d-flex justify-content-end mt-1">
                                        <button class="btn btn-sm btn-success save-insight" data-id="{{ $insight->id }}">Save</button>
                                    </div>
                                @else
                                    <div class="description text-wrap">{{ $insight->description }}</div>
                                @endif
                            </td>

                            {{-- Date --}}
                            <td>{{ \Carbon\Carbon::parse($insight->created_at)->format('d/m/Y') }}</td>

                            {{-- Status Badge --}}
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

                            {{-- Rating (if any) --}}
                            <td>
                                @if($insight->insights_rating)
                                    ⭐ {{ $insight->insights_rating }}
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center">No insights available</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Submit Button --}}
            <div class="d-flex justify-content-end my-2">
                <button id="submitSelectedInsights" class="btn btn-primary">
                    <i class="fas fa-paper-plane"></i> Submit Insights for Approval
                </button>
            </div>
        </div>
    </div>
</div>
{{-- =============================
     Submit Script (Standardized)
============================= --}}
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

        // Reload to refresh the insight list
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
    {{-- =============================
         Modal for Creating Task
    ============================= --}}
    <div class="modal fade" id="taskModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ url('/tasks') }}" method="POST">
                @csrf
                <input type="hidden" name="goal_id" id="modal-goal-id">
                
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Create Task for <span id="modal-goal-title"></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Task Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control"></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Deadline</label>
                            <input type="date" name="end_date" class="form-control">
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save Task</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- =============================
         Script for Modal
    ============================= --}}
    <script>
    function openTaskModal(goalId, goalTitle) {
        document.getElementById('modal-goal-id').value = goalId;
        document.getElementById('modal-goal-title').textContent = goalTitle;
        new bootstrap.Modal(document.getElementById('taskModal')).show();
    }
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
