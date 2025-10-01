<link rel="stylesheet" href="{{ asset('/user_end/css/pms-dashboard.css') }}">
<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap 5 JS (bundle includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Summary Pie Chart Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  let orgSummaryChart = null;

  function getCounts() {
    const toInt = (el) => parseInt((el?.textContent || '0').replace(/[^0-9]/g, '')) || 0;
    return {
      goals: toInt(document.getElementById('totalGoals')),
      tasks: toInt(document.getElementById('totalTasks')),
      pending: toInt(document.getElementById('pendingApprovals')),
    };
  }

  function renderOrgSummaryPie() {
    const ctx = document.getElementById('orgSummaryPie');
    if (!ctx) return;
    const { goals, tasks, pending } = getCounts();
    const data = [goals, tasks, pending];
    const labels = ['Total Goals', 'Total Tasks', 'Pending Approvals'];
    const colors = ['#3b82f6', '#10b981', '#f59e0b'];

    if (orgSummaryChart) {
      orgSummaryChart.data.datasets[0].data = data;
      orgSummaryChart.update();
      return;
    }

    orgSummaryChart = new Chart(ctx, {
      type: 'pie',
      data: { labels, datasets: [{ data, backgroundColor: colors }] },
      options: { plugins: { legend: { position: 'bottom' } }, responsive: true }
    });
  }

  document.addEventListener('DOMContentLoaded', function () {
    // Initial render
    renderOrgSummaryPie();

    // Auto-update when counts change
    const container = document.querySelector('.card:has(#orgSummaryPie)') || document.body;
    const observer = new MutationObserver(() => renderOrgSummaryPie());
    observer.observe(container, { subtree: true, characterData: true, childList: true });
  });
</script>

<div class="container">

    {{-- Summary Pie Chart --}}
    <div class="card mb-4">
        <div class="card-header bg-light"><strong>Summary</strong></div>
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-5">
                    <canvas id="orgSummaryPie" height="160" style="max-width:260px; display:block; margin:auto;"></canvas>
                </div>
                <div class="col-md-7">
                    <ul class="list-unstyled mb-0 small">
                        <li class="d-flex align-items-center mb-2">
                            <span class="me-2" style="display:inline-block;width:14px;height:14px;background:#3b82f6;border-radius:3px;"></span>
                            <strong>Total Goals:</strong>&nbsp;<span id="totalGoals">0</span>
                        </li>
                        <li class="d-flex align-items-center mb-2">
                            <span class="me-2" style="display:inline-block;width:14px;height:14px;background:#10b981;border-radius:3px;"></span>
                            <strong>Total Tasks:</strong>&nbsp;<span id="totalTasks">0</span>
                        </li>
                        <li class="d-flex align-items-center mb-2">
                            <span class="me-2" style="display:inline-block;width:14px;height:14px;background:#f59e0b;border-radius:3px;"></span>
                            <strong>Pending Approvals:</strong>&nbsp;<span id="pendingApprovals">0</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Goals --}}
    <div class="card mb-4">
        <div class="card-header bg-light"><strong>Goals</strong></div>
        <div class="card-body">
            <form id="goalsForm">
                @csrf
                <input type="hidden" name="id" id="goal_id">

                <!-- Row 1: Title, Period, Priority -->
                <div class="row g-3 mb-2">
                    <div class="col-md-5">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" id="title" name="title" class="form-control" placeholder="Goal Title" required>
                    </div>
                    <div class="col-md-4">
                        <label for="org_setting_id" class="form-label">Period</label>
                        <select name="org_setting_id" id="org_setting_id" class="form-control" required></select>
                    </div>
                    <div class="col-md-3">
                        <label for="priority" class="form-label">Priority</label>
                        <select name="priority" id="priority" class="form-control">
                            <option value="low">Low</option>
                            <option value="medium" selected>Medium</option>
                            <option value="high">High</option>
                        </select>
                    </div>
                </div>

                <!-- Row 2: Start & End Dates -->
                <div class="row g-3 mb-2">
                    <div class="col-md-3">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" id="start_date" name="start_date" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" id="end_date" name="end_date" class="form-control" required>
                    </div>
                </div>

                <!-- Row 3: Description -->
                <div class="row g-3 mb-2">
                    <div class="col-12">
                        <label for="description" class="form-label">Description</label>
                        <textarea id="description" name="description" class="form-control" placeholder="Description"></textarea>
                    </div>
                </div>

                <!-- Row 4: Save Button -->
                <div class="row g-3 mb-2">
                    <div class="col-12 d-flex justify-content-end">
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </div>

                
            </form>
            <div class="mt-3">
                <div class="table-fixed-header">
                    <table class="table table-bordered table-striped m-0">
                        <colgroup>
                            <col style="width:26%">
                            <col style="width:14%">
                            <col style="width:12%">
                            <col style="width:12%">
                            <col style="width:12%">
                            <col style="width:12%">
                            <col style="width:12%">
                        </colgroup>
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Period</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="table-scroll-container">
                    <table class="table table-bordered table-striped m-0">
                        <colgroup>
                            <col style="width:26%">
                            <col style="width:14%">
                            <col style="width:12%">
                            <col style="width:12%">
                            <col style="width:12%">
                            <col style="width:12%">
                            <col style="width:12%">
                        </colgroup>
                        <tbody id="goalsTable"></tbody>
                    </table>
                </div>
            </div>
    </div>
    </div>

    {{-- Task Approvals --}}
    <div class="card mb-4">
        <div class="card-header bg-light"><strong>Tasks</strong></div>
        <div class="card-body">
            <div class="d-flex justify-content-end mb-2">
                <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#createTaskModal">Add Task</button>
            </div>
            <div class="table-scroll">
                <table class="table table-bordered table-striped m-0">
                    <thead class="table-light">
                        <tr>
                            <th>Task</th>
                            <th>Approved By</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="approvalsTable"></tbody>
                </table>
            </div>
        </div>
    </div>


<!-- Create Task Modal -->
<div class="modal fade" id="createTaskModal" tabindex="-1" aria-labelledby="createTaskModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header edit-goal-header text-white">
        <h5 class="modal-title" id="createTaskModalLabel">Create Task</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ url('/tasks') }}" method="POST">
        @csrf
        <div class="modal-body">
          <!-- Row 1: Title, Priority -->
          <div class="row g-3 mb-2">
            <div class="col-md-8">
              <label for="task_title" class="form-label">Title</label>
              <input type="text" id="task_title" name="title" class="form-control" placeholder="Task title" required>
            </div>
            <div class="col-md-4">
              <label for="task_priority" class="form-label">Priority</label>
              <select id="task_priority" name="priority" class="form-control">
                <option value="low">Low</option>
                <option value="medium" selected>Medium</option>
                <option value="high">High</option>
              </select>
            </div>
          </div>

          <!-- Row 2: Start & End Dates -->
          <div class="row g-3 mb-2">
            <div class="col-md-6">
              <label for="task_start" class="form-label">Start Date</label>
              <input type="date" id="task_start" name="start_date" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label for="task_end" class="form-label">End Date</label>
              <input type="date" id="task_end" name="end_date" class="form-control" required>
            </div>
          </div>

          <!-- Row 3: Description -->
          <div class="row g-3 mb-2">
            <div class="col-12">
              <label for="task_description" class="form-label">Description</label>
              <textarea id="task_description" name="description" class="form-control" placeholder="Task description"></textarea>
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

<!-- Edit Goal Modal -->
<div class="modal fade" id="editGoalModal" tabindex="-1" aria-labelledby="editGoalModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header edit-goal-header text-white">
        <h5 class="modal-title" id="editGoalModalLabel">Edit Goal</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="editGoalForm">
        <input type="hidden" id="edit_goal_id">
        <div class="modal-body">
          <!-- Row 1: Title, Period, Priority -->
          <div class="row g-3 mb-2">
            <div class="col-md-5">
              <label for="edit_title" class="form-label">Title</label>
              <input type="text" id="edit_title" class="form-control" required>
            </div>
            <div class="col-md-4">
              <label for="edit_org_setting_id" class="form-label">Period</label>
              <select id="edit_org_setting_id" class="form-control" required></select>
            </div>
            <div class="col-md-3">
              <label for="edit_priority" class="form-label">Priority</label>
              <select id="edit_priority" class="form-control">
                <option value="low">Low</option>
                <option value="medium">Medium</option>
                <option value="high">High</option>
              </select>
            </div>
          </div>

          <!-- Row 2: Start & End Dates, Status -->
          <div class="row g-3 mb-2">
            <div class="col-md-3">
              <label for="edit_start_date" class="form-label">Start Date</label>
              <input type="date" id="edit_start_date" class="form-control" required>
            </div>
            <div class="col-md-3">
              <label for="edit_end_date" class="form-label">End Date</label>
              <input type="date" id="edit_end_date" class="form-control" required>
            </div>
            <div class="col-md-3">
              <label for="edit_status" class="form-label">Status</label>
              <select id="edit_status" class="form-control">
                <option value="pending">Pending</option>
                <option value="in-progress">In Progress</option>
                <option value="completed">Completed</option>
              </select>
            </div>
          </div>

          <!-- Row 3: Description -->
          <div class="row g-3 mb-2">
            <div class="col-12">
              <label for="edit_description" class="form-label">Description</label>
              <textarea id="edit_description" class="form-control"></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Update Goal</button>
        </div>
      </form>
    </div>
  </div>
</div>



</div>

{{-- JS --}}



<script>
/* ---------- Helper: CSRF token ---------- */
const csrfToken = () => {
    const meta = document.querySelector('meta[name="csrf-token"]');
    return meta ? meta.getAttribute('content') : '';
};

/* ---------- Open Edit Modal and populate fields ---------- */
async function editGoal(id) {
    try {
        // load goal data
        const res = await fetch(`/goals/${id}`);
        if (!res.ok) throw new Error(`Failed to fetch goal (status ${res.status})`);
        const goal = await res.json();

        // populate fields
        document.getElementById("edit_goal_id").value = goal.id;
        document.getElementById("edit_title").value = goal.title || '';
        document.getElementById("edit_start_date").value = goal.start_date || '';
        document.getElementById("edit_end_date").value = goal.end_date || '';
        document.getElementById("edit_priority").value = goal.priority || 'medium';
        document.getElementById("edit_status").value = goal.status || 'pending';
        document.getElementById("edit_description").value = goal.description || '';

        // populate period select
        const select = document.getElementById("edit_org_setting_id");
        select.innerHTML = '<option>Loading...</option>';
        const settingsRes = await fetch('/org-settings');
        if (!settingsRes.ok) throw new Error('Failed to load organization settings');
        const settings = await settingsRes.json();

        select.innerHTML = '';
        settings.forEach(s => {
            const opt = document.createElement('option');
            opt.value = s.id;
            opt.text = s.name;
            if (String(s.id) === String(goal.org_setting_id)) opt.selected = true;
            select.appendChild(opt);
        });

        // show modal
        const modalEl = document.getElementById("editGoalModal");
        const modal = new bootstrap.Modal(modalEl);
        modal.show();

    } catch (err) {
        console.error(err);
        alert("Could not load goal details. Open DevTools Console for more info.");
    }
}

/* ---------- Submit updated goal via PUT ---------- */
document.getElementById("editGoalForm").addEventListener("submit", async function (e) {
    e.preventDefault();

    const id = document.getElementById("edit_goal_id").value;
    if (!id) {
        alert("Missing goal id");
        return;
    }

    // build payload from form fields
    const payload = {
        org_setting_id: document.getElementById("edit_org_setting_id").value,
        title: document.getElementById("edit_title").value,
        start_date: document.getElementById("edit_start_date").value,
        end_date: document.getElementById("edit_end_date").value,
        priority: document.getElementById("edit_priority").value,
        status: document.getElementById("edit_status").value,
        description: document.getElementById("edit_description").value,
    };

    try {
        const res = await fetch(`/goals/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken()
            },
            body: JSON.stringify(payload),
        });

        if (!res.ok) {
            // try to read JSON errors
            let errText = `Request failed (${res.status})`;
            try {
                const errJson = await res.json();
                if (errJson.errors) {
                    errText = Object.values(errJson.errors).flat().join("\n");
                } else if (errJson.message) {
                    errText = errJson.message;
                }
            } catch (_) {}
            throw new Error(errText);
        }

        // success: hide modal & refresh goals
        const modalEl = document.getElementById("editGoalModal");
        const modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();

        // optional: show a temporary success message
        // alert('Goal updated successfully');

        // reload goals list
        if (typeof loadGoals === 'function') loadGoals();
    } catch (err) {
        console.error(err);
        alert("Failed to update goal: " + err.message);
    }
});
</script>



<script>
  document.addEventListener("DOMContentLoaded", function () {
    loadGoals();
    loadApprovals();

    // Save Goal
    document.getElementById("goalsForm").addEventListener("submit", async function (e) {
        e.preventDefault();
        let formData = new FormData(this);

        await fetch("/goals", { method: "POST", body: formData });
        loadGoals();
        this.reset();
    });
});

async function loadGoals() {
    let res = await fetch("/goals");
    let data = await res.json();
    let tbody = document.getElementById("goalsTable");
    document.getElementById("totalGoals").innerText = data.length;
    tbody.innerHTML = "";

        data.forEach(g => {
            tbody.innerHTML += `<tr>
                <td>${g.title}</td>
                <td>${g.priority}</td>
                <td>${g.status}</td>
                <td>${g.period_name || g.org_setting_id}</td>
                <td>${g.start_date || '-'}</td>
                <td>${g.end_date || '-'}</td>
                <td>
                    <button class="btn btn-sm btn-warning" onclick="editGoal(${g.id})">Edit</button>
                </td>
            </tr>`;
        });

    // Populate period select
    let select = document.getElementById("org_setting_id");
    let settingsRes = await fetch("/org-settings");
    let settings = await settingsRes.json();
    select.innerHTML = "";
    settings.forEach(s => {
        select.innerHTML += `<option value="${s.id}">${s.name}</option>`;
    });
}

async function loadApprovals() {
    let res = await fetch("/task-approvals");
    let data = await res.json();
    let tbody = document.getElementById("approvalsTable");
    document.getElementById("pendingApprovals").innerText = data.filter(a => a.status === "pending").length;
    tbody.innerHTML = "";
    data.forEach(a => {
        tbody.innerHTML += `<tr>
            <td>${a.task_title || a.task_id}</td>
            <td>${a.approved_by_name || a.approved_by}</td>
            <td>${a.status}</td>
            <td>
                <button class="btn btn-sm btn-success">Approve</button>
                <button class="btn btn-sm btn-danger">Reject</button>
            </td>
        </tr>`;
    });
}


</script>
