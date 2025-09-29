<link rel="stylesheet" href="{{ asset('/user_end/css/pms-dashboard.css') }}">
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

</div>

{{-- JS --}}
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

// Optional edit function
function editGoal(id) {
    // Fetch goal by id, populate form fields for editing
}

</script>
