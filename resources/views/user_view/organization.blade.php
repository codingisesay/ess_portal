<link rel="stylesheet" href="{{ asset('/user_end/css/pms-dashboard.css') }}">
<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap 5 JS (bundle includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<div class="container">

    {{-- Summary Cards --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary shadow">
                <div class="card-body">
                    <h5>Total Goals</h5>
                    <h2 id="totalGoals">0</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success shadow">
                <div class="card-body">
                    <h5>Total Tasks</h5>
                    <h2 id="totalTasks">0</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-warning shadow">
                <div class="card-body">
                    <h5>Pending Approvals</h5>
                    <h2 id="pendingApprovals">0</h2>
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

                <div class="row mb-2">
                    <div class="col-md-3">
                        <select name="org_setting_id" id="org_setting_id" class="form-control" required></select>
                    </div>
                    <div class="col-md-3">
                        <input type="text" id="title" name="title" class="form-control" placeholder="Goal Title" required>
                    </div>
                      <div class="col-md-2">
                        <input type="date" id="start_date" name="start_date" class="form-control" placeholder="Start Date" required>
                    </div>
                    <div class="col-md-2">
                        <input type="date" id="end_date" name="end_date" class="form-control" placeholder="End Date" required>
                    </div>
                    <div class="col-md-3">
                        <select name="priority" id="priority" class="form-control">
                            <option value="low">Low</option>
                            <option value="medium" selected>Medium</option>
                            <option value="high">High</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-success w-100">Save</button>
                    </div>
                </div>

                <textarea id="description" name="description" class="form-control" placeholder="Description"></textarea>
            </form>
            <div class="table-scroll mt-3">
            <table class="table table-bordered table-striped mt-3">
               <thead class="table-light">
                        <tr>
                            <th>Title</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Period</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="goalsTable"></tbody>
            </table>
        </div>
    </div>
    </div>

    {{-- Task Approvals --}}
    <div class="card mb-4">
        <div class="card-header bg-light"><strong>Task Approvals</strong></div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
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


<!-- Edit Goal Modal -->
<div class="modal fade" id="editGoalModal" tabindex="-1" aria-labelledby="editGoalModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="editGoalModalLabel">Edit Goal</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="editGoalForm">
        <input type="hidden" id="edit_goal_id">
        <div class="modal-body">
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">Period</label>
              <select id="edit_org_setting_id" class="form-control" required></select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Title</label>
              <input type="text" id="edit_title" class="form-control" required>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">Start Date</label>
              <input type="date" id="edit_start_date" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">End Date</label>
              <input type="date" id="edit_end_date" class="form-control" required>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">Priority</label>
              <select id="edit_priority" class="form-control">
                <option value="low">Low</option>
                <option value="medium">Medium</option>
                <option value="high">High</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Status</label>
              <select id="edit_status" class="form-control">
                <option value="pending">Pending</option>
                <option value="in-progress">In Progress</option>
                <option value="completed">Completed</option>
              </select>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea id="edit_description" class="form-control"></textarea>
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
