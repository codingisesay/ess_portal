<!-- Styles: PMS base + manager, employee overrides, and icon font -->
<link rel="stylesheet" href="{{ asset('/user_end/css/pms-dashboard.css') }}">
<link rel="stylesheet" href="{{ asset('/user_end/css/manager-dashboard.css') }}">
<link rel="stylesheet" href="{{ asset('/user_end/css/Employee_dash.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Added: Responsive two-column layout (Sidebar + Main content) for Employee PMS dashboard -->
<div class="row g-3 align-items-stretch">
  <div class="col-12 col-lg-3">
    <div class="card p-2 emp-sidebar h-100" style="position: sticky; top: 12px;">
      <!-- Sidebar header with blue dot + title (matches screenshot) -->
      <div class="d-flex align-items-center gap-2 mb-2 emp-sidebar-header">
        <span class="emp-dot" aria-hidden="true"></span>
        <span class="fw-bold">Employee Dashboard</span>
        <span class="ms-auto"></span>
      </div>
      <div class="list-group">
        <a href="#emp-goals" class="list-group-item list-group-item-action active">
          <i class="bi bi-flag"></i>
          <span class="link-text">
            <span class="title">Goals</span>
            <span class="subtitle">View goals</span>
          </span>
        </a>
        <a href="#emp-tasks" class="list-group-item list-group-item-action">
          <i class="bi bi-list"></i>
          <span class="link-text">
            <span class="title">Your Tasks</span>
            <span class="subtitle">Tasks assigned to you</span>
          </span>
        </a>
        <a href="#emp-insights" class="list-group-item list-group-item-action">
          <i class="bi bi-lightbulb"></i>
          <span class="link-text">
            <span class="title">Your Submitted Insights</span>
            <span class="subtitle">View or edit your insights</span>
          </span>
        </a>
      </div>
    </div>
    <script>
      // Sidebar behavior: keep only the selected employee section visible (Goals/Tasks/Insights)
      // Runs after DOM is ready so anchors and cards exist
      document.addEventListener('DOMContentLoaded', function(){
        // All sidebar links we toggle 'active' on
        const links = document.querySelectorAll('.emp-sidebar .list-group a.list-group-item');
        // Helper: resolve the exact container to show for each anchor
        // - Goals: the specific mb-4 right after #emp-goals (contains the goals table)
        // - Tasks: the card that contains #emp-tasks
        // - Insights: the insights card under its wrapper
        const getGoalsContainer = () => {
          const a = document.getElementById('emp-goals');
          if (!a) return null;
          // The goals table lives in the immediate next ".mb-4" sibling
          let n = a.nextElementSibling;
          while (n && !n.classList.contains('mb-4')) n = n.nextElementSibling;
          return n || a.closest('.card') || null;
        };
        const getTasksContainer = () => {
          const a = document.getElementById('emp-tasks');
          if (!a) return null;
          // The tasks list lives in the immediate next ".mb-4" sibling
          let n = a.nextElementSibling;
          while (n && !n.classList.contains('mb-4')) n = n.nextElementSibling;
          return n || a.closest('.card') || null;
        };
        const getInsightsContainer = () => {
          const a = document.getElementById('emp-insights');
          if (!a) return null;
          // Find the first card inside the insights wrapper
          const wrap = a.nextElementSibling || a.parentElement;
          const card = wrap?.querySelector('.card');
          return card || wrap || null;
        };

        const sections = {
          'emp-goals': getGoalsContainer(),
          'emp-tasks': getTasksContainer(),
          'emp-insights': getInsightsContainer()
        };

        // Make only the target section visible and highlight the corresponding nav link
        const showOnly = (hash) => {
          const targetHash = hash || '#emp-goals';
          const key = targetHash.replace('#','');
          // Highlight nav link that matches the current hash
          links.forEach(l => l.classList.toggle('active', l.getAttribute('href') === targetHash));
          // Hide all other sections; show only the matched section (no external CSS required)
          Object.entries(sections).forEach(([k, el]) => {
            if (!el) return;
            el.style.display = (k === key) ? '' : 'none';
          });
        };

        // Click handler: update UI immediately when a sidebar link is clicked
        links.forEach(l => l.addEventListener('click', function(e){
          e.preventDefault();
          const href = this.getAttribute('href');
          if (!href) return;
          if (history.replaceState) history.replaceState(null, '', href); else location.hash = href;
          showOnly(href);
        }));
        // Keep in sync with URL changes (back/forward navigation)
        window.addEventListener('hashchange', () => showOnly(location.hash));
        // Initial render: respect existing hash or default to Goals
        showOnly(location.hash || '#emp-goals');
      });
    </script>
  </div>
  <div class="col-12 col-lg-9">
<div class="card p-3 shadow-sm">
    

   {{-- =============================
     Goals (Yours + Manager's)
============================= --}}
<!-- Added: Anchor target for sidebar link to Goals section -->
<span id="emp-goals"></span>
<!-- Sidebar toggle target: this .mb-4 contains the Goals table and is shown/hidden by the sidebar script -->
<div class="mb-4">
    <div class="emp-goals-bar d-flex align-items-center gap-2">
      <span class="emp-goals-icon" aria-hidden="true"><i class="bi bi-flag-fill"></i></span>
      <span class="emp-goals-title">Goals</span>
    </div>
    @if($allOrgGoals->isEmpty())
        <p class="text-muted">No goals assigned yet.</p>
    @else
        <!-- Fixed header table (separate element that never scrolls) -->
        <div class="table-fixed-header no-scrollbar-header">
          <table class="table table-bordered align-middle m-0" style="table-layout:fixed;">
            <colgroup>
              <col style="width:70%">
              <col style="width:30%">
            </colgroup>
            <thead class="table-light">
              <tr>
                <th>Goal Title</th>
                <th>Actions</th>
              </tr>
            </thead>
          </table>
        </div>

        <!-- Scrollable body table (only tbody scrolls) -->
        <div class="goals-scroll no-scrollbar">
          <table class="table table-bordered align-middle m-0" style="table-layout:fixed;">
            <colgroup>
              <col style="width:70%">
              <col style="width:30%">
            </colgroup>
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
        </div>
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
        // Log unexpected errors (network/server/runtime) to the console for debugging
        console.error(err);
        // Show a friendly error to the user; include err.message when available to aid troubleshooting
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: err.message || 'Something went wrong!'
        });
    }
});
</script>


    {{-- =============================
         Your Tasks
    ============================= --}}
    <!-- Added: Anchor target for sidebar link to Your Tasks section -->
    <span id="emp-tasks"></span>
    <!-- Sidebar toggle target: this .mb-4 contains the Tasks list and is shown/hidden by the sidebar script -->
    <div class="mb-4">
        {{-- Styled header bar matching Goals section visual --}}
        <div class="emp-goals-bar d-flex align-items-center gap-2">
          <span class="emp-goals-icon" aria-hidden="true"><i class="bi bi-list-check"></i></span>
          <span class="emp-goals-title">Your Tasks</span>
        </div>
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
         4. Insights Section (moved inside main card)
============================= --}}
        <!-- Added: Anchor target for sidebar link to Your Submitted Insights section -->
        <span id="emp-insights"></span>
        <!-- Sidebar toggle target: this card contains the Insights table and controls, shown/hidden by the sidebar script -->
        <div class="card mb-4" style="display: none;">
          <div class="card-body">
            {{-- Styled header bar matching Goals/Tasks visual language --}}
            <div class="emp-goals-bar d-flex align-items-center gap-2">
              <span class="emp-goals-icon" aria-hidden="true"><i class="bi bi-lightbulb-fill"></i></span>
              <span class="emp-goals-title">Your Submitted Insights</span>
            </div>

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
                    <td>
                      <span class="insight-goal-icon bi bi-record-circle me-2" aria-hidden="true"></span>
                      {{ $insight->goal_title }}
                    </td>

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

        {{-- =============================
         Submit Script (Standardized) — kept next to the Insights card
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

    </div> <!-- /.card p-3 shadow-sm (Employee Dashboard main card) -->


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
        // Keep Create Task modal below the header by setting a CSS variable with header height
        document.addEventListener('DOMContentLoaded', function(){
          var modalEl = document.getElementById('taskModal');
          if (!modalEl) return;
          function headerOffsetPx(){
            var h = document.querySelector('header, .navbar, .main-header, #header, .app-header');
            if (!h) return 0;
            var rect = h.getBoundingClientRect();
            var height = rect && rect.height ? rect.height : (h.offsetHeight || 0);
            return Math.max(0, Math.round(height)) + 12; // extra spacing
          }
          modalEl.addEventListener('show.bs.modal', function(){
            var off = headerOffsetPx();
            document.documentElement.style.setProperty('--emp-header-offset', off + 'px');
          });
          modalEl.addEventListener('hidden.bs.modal', function(){
            document.documentElement.style.removeProperty('--emp-header-offset');
          });
        });
        </script> 

        <!-- Keep Add Insight modal below header: set --emp-header-offset on open, clear on close -->
        <script>
        document.addEventListener('DOMContentLoaded', function(){
          var insightModalEl = document.getElementById('insightModal');
          if (!insightModalEl) return;
          function headerOffsetPx(){
            var h = document.querySelector('header, .navbar, .main-header, #header, .app-header');
            if (!h) return 0;
            var rect = h.getBoundingClientRect();
            var height = rect && rect.height ? rect.height : (h.offsetHeight || 0);
            return Math.max(0, Math.round(height)) + 12;
          }
          insightModalEl.addEventListener('show.bs.modal', function(){
            var off = headerOffsetPx();
            document.documentElement.style.setProperty('--emp-header-offset', off + 'px');
          });
          insightModalEl.addEventListener('hidden.bs.modal', function(){
            document.documentElement.style.removeProperty('--emp-header-offset');
          });
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
              // Update a rejected insight with edited description
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
