<link rel="stylesheet" href="{{ asset('/user_end/css/pms-dashboard.css') }}">
<link rel="stylesheet" href="{{ asset('/user_end/css/manager-dashboard.css') }}">
<link rel="stylesheet" href="{{ asset('/user_end/css/hr_policy.css') }}">
<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<!-- Bootstrap 5 JS (bundle includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Sidebar collapse/expand functionality (namespaced to avoid conflicts with other pages)
window.orgSidebarCollapsed = window.orgSidebarCollapsed || false;

// Keep a dedicated function for org page and expose it globally so the inline onclick works
window.toggleOrgSidebar = function() {
  console.log('[organization] toggleOrgSidebar invoked, current:', window.orgSidebarCollapsed);
  window.orgSidebarCollapsed = !window.orgSidebarCollapsed;
  const sidebarMain = document.getElementById('orgSidebar');
  const collapseIcon = document.getElementById('collapseIcon');
  const orgMainEl = document.getElementById('org-main');

  if (!sidebarMain) return;

  if (window.orgSidebarCollapsed) {
    // add class-based collapsed state
    sidebarMain.classList.add('collapsed');
    if (orgMainEl) orgMainEl.classList.add('collapsed-adjust');
    if (collapseIcon) {
      collapseIcon.style.transform = 'rotate(180deg)';
      collapseIcon.classList.remove('fa-chevron-right');
      collapseIcon.classList.add('fa-chevron-left');
    }
    try { localStorage.setItem('orgSidebarCollapsed', '1'); } catch (e) {}
  } else {
    // remove collapsed state
    sidebarMain.classList.remove('collapsed');
    if (orgMainEl) orgMainEl.classList.remove('collapsed-adjust');
    if (collapseIcon) {
      collapseIcon.style.transform = 'rotate(0deg)';
      collapseIcon.classList.remove('fa-chevron-left');
      collapseIcon.classList.add('fa-chevron-right');
    }
    try { localStorage.setItem('orgSidebarCollapsed', '0'); } catch (e) {}
  }
}

// Panel switching functionality
document.addEventListener('DOMContentLoaded', function() {
    const nav = document.querySelector('.sidebar_bottom');
    // panels may be directly under .pms-main or marked with .pms-panel
    const panels = Array.from(document.querySelectorAll('.pms-main .pms-panel, .pms-panel'));

    if (nav) {
        nav.addEventListener('click', function(e) {
            const link = e.target.closest('a[data-target]');
            if (!link) return;

            e.preventDefault();
            const target = link.getAttribute('data-target');

            // Update panel visibility
            panels.forEach(panel => {
                if (panel.id === target) {
                    panel.classList.add('visible');
                } else {
                    panel.classList.remove('visible');
                }
            });

            // Update active state
            document.querySelectorAll('.sidebar-button').forEach(btn => {
                btn.classList.remove('active');
            });
            link.classList.add('active');
        });

        // Set first item as active by default and show its panel
        const firstLink = nav.querySelector('a[data-target]');
        if (firstLink) {
            const firstTarget = firstLink.getAttribute('data-target');
            document.querySelectorAll('.sidebar-button').forEach(btn => btn.classList.remove('active'));
            firstLink.classList.add('active');
            panels.forEach(panel => {
                if (panel.id === firstTarget) panel.classList.add('visible'); else panel.classList.remove('visible');
            });
        }
    }

  // Load saved sidebar state
  try {
    const collapsed = localStorage.getItem('orgSidebarCollapsed') === '1';
    const sidebarMain = document.getElementById('orgSidebar');
    const orgMainEl = document.getElementById('org-main');
    if (collapsed && sidebarMain) {
      sidebarMain.classList.add('collapsed');
      if (orgMainEl) orgMainEl.classList.add('collapsed-adjust');
      const collapseIcon = document.getElementById('collapseIcon');
      if (collapseIcon) {
        collapseIcon.style.transform = 'rotate(180deg)';
        collapseIcon.classList.remove('fa-chevron-right');
        collapseIcon.classList.add('fa-chevron-left');
      }
  window.orgSidebarCollapsed = true;
    }
  } catch(e) {}
});

  // Auto-collapse on small screens for better viewport usage
  function applyResponsiveSidebar(){
    const sidebar = document.getElementById('orgSidebar');
    const orgMainEl = document.getElementById('org-main');
    if(!sidebar) return;
    const isSmall = window.matchMedia('(max-width: 800px)').matches;
    if(isSmall){
      try { localStorage.setItem('orgSidebarCollapsed', '1'); } catch(e) {}
  if(!sidebar.classList.contains('collapsed')) sidebar.classList.add('collapsed');
  if (orgMainEl && !orgMainEl.classList.contains('collapsed-adjust')) orgMainEl.classList.add('collapsed-adjust');
  window.orgSidebarCollapsed = true;
    } else {
      const persisted = localStorage.getItem('orgSidebarCollapsed')==='1';
      if(!persisted){
  sidebar.classList.remove('collapsed');
  if (orgMainEl) orgMainEl.classList.remove('collapsed-adjust');
  window.orgSidebarCollapsed = false;
      }
    }
  }
  applyResponsiveSidebar();
  window.addEventListener('resize', applyResponsiveSidebar);

  // Debounced resize to keep Chart.js responsive across layout changes
  let __rz;
  window.addEventListener('resize', function(){
    clearTimeout(__rz);
    __rz = setTimeout(function(){
      try{
        if(window.orgSummaryChart && typeof window.orgSummaryChart.resize === 'function'){
          window.orgSummaryChart.resize();
        } else {
          // as fallback, re-run render to recalc
          if(typeof renderOrgSummaryPie === 'function') renderOrgSummaryPie();
        }
      }catch(e){}
    }, 150);
  });
</script>

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
      type: 'bar',
      data: {
        labels,
        datasets: [{
          label: 'Summary',
          data,
          backgroundColor: colors,
          borderColor: '#ffffff',
          borderWidth: 1,
          borderRadius: 4,
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: { display: false }
        },
        scales: {
          y: { beginAtZero: true, ticks: { precision: 0 } },
          x: { grid: { display: false } }
        }
      }
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

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<style>
  /* Collapsed sidebar (class-based) - keeps only icons + collapse button visible */
  #orgSidebar.collapsed {
    width: 75px !important;
    min-width: 75px !important;
    overflow: visible;
  }

  #orgSidebar.collapsed .Logo_main,
  #orgSidebar.collapsed .search-bar,
  #orgSidebar.collapsed .sidebar_top_left {
    display: none !important;
  }

  #orgSidebar.collapsed .sidebar_top {
    justify-content: center !important;
    align-items: center !important;
    padding: 10px 0 !important;
  }

  #orgSidebar.collapsed .sidebar_top_right {
    width: 100% !important;
    display: flex !important;
    justify-content: center !important;
    align-items: center !important;
    border-radius: 30px 30px 0 0 !important;
  }

  #orgSidebar.collapsed .button-list {
    border-radius: 0 0 25px 25px !important;
    padding-top: 5px !important;
    gap: 8px !important;
  }

  #orgSidebar.collapsed .sidebar-button {
    width: 60px !important;
    height: 60px !important;
    justify-content: center !important;
    align-items: center !important;
    padding: 0 !important;
    margin: 0 auto !important;
  }

  #orgSidebar.collapsed .sidebar-icon {
    margin: 0 !important;
    width: 50px !important;
    height: 50px !important;
  }

  #orgSidebar.collapsed .sidebar-button-text {
    display: none !important;
  }

  /* Adjust main content to occupy remaining space when collapsed */
  #org-main.collapsed-adjust {
    margin-left: 1.5rem !important;
    width: calc(100% - 75px - 3rem) !important;
  }

  /* Smooth transitions */
  #orgSidebar,
  #org-main {
    transition: width 0.22s ease, margin-left 0.22s ease;
  }
</style>

<div class="pms-page org-dashboard">
  <!-- New Sidebar based on HR Policy design -->
  <div class="sidebar_main" id="orgSidebar">
    <div class="sidebar_internal">
      <!-- Top Section with Search Bar and Toggle -->
      <div class="sidebar_top">
        <div class="sidebar_top_left">
          <div class="Logo_main sidebar-search" id="logoMain">
            <div class="search-bar">
              <input type="text" placeholder="Search..." id="searchInput">
            </div>
          </div>
        </div>
        <div class="sidebar_top_right">
          <div class="top_button_container">
            <button type="button" class="top_button" id="collapseButton" onclick="toggleOrgSidebar()">
              <i class="fas fa-chevron-right" id="collapseIcon"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Navigation -->
      <div class="sidebar_bottom">
        <div class="button-list" id="buttonList">
          <div class="dropdown-section">
            <a href="#org-summary" class="sidebar-button" data-target="org-summary">
              <div class="sidebar-icon">
                <i class="bi bi-pie-chart"></i>
              </div>
              <span class="sidebar-button-text">Summary</span>
            </a>
          </div>
          
          <div class="dropdown-section">
            <a href="#org-goals" class="sidebar-button" data-target="org-goals">
              <div class="sidebar-icon">
                <i class="bi bi-flag"></i>
              </div>
              <span class="sidebar-button-text">Goals</span>
            </a>
          </div>
          
          <div class="dropdown-section">
            <a href="#org-task-approvals" class="sidebar-button" data-target="org-task-approvals">
              <div class="sidebar-icon">
                <i class="bi bi-check2-square"></i>
              </div>
              <span class="sidebar-button-text">Task Approvals</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <main class="pms-main" id="org-main" style="margin-left: 1.5rem; width: calc(100% - 22% - 3rem); transition: margin-left 0.3s ease, width 0.3s ease;">
    <section id="org-summary" class="pms-panel visible">
        <div class="container">

    {{-- Summary metric cards --}}
    <div class="summary-wrap">
      <div class="ins-approval-header d-flex align-items-center gap-2">
        <span class="ins-approval-header-icon bi bi-flag-fill" aria-hidden="true"></span>
        <h5 class="m-0 ins-approval-header-title">Summary</h5>
      </div>
      <div class="summary-grid">
        <div class="metric-card metric-blue">
          <div class="metric-title">Total Goals</div>
          <div class="metric-row">
            <div class="metric-value" id="totalGoals">0</div>
            <svg class="metric-spark" viewBox="0 0 120 32" preserveAspectRatio="none" aria-hidden="true">
              <defs>
                <linearGradient id="grad-blue" x1="0" x2="0" y1="0" y2="1">
                  <stop offset="0%" stop-color="#7ba3ff" stop-opacity="1"/>
                  <stop offset="100%" stop-color="#cfe0ff" stop-opacity="0.2"/>
                </linearGradient>
              </defs>
              <path d="M1 22 C20 10, 40 18, 60 16 C80 14, 100 20, 119 6" stroke="#5b8cff" stroke-width="2" fill="none"/>
              <rect x="92" y="6" width="18" height="20" rx="3" fill="url(#grad-blue)" />
            </svg>
          </div>
        </div>
        <div class="metric-card metric-green">
          <div class="metric-title">Total Tasks</div>
          <div class="metric-row">
            <div class="metric-value" id="totalTasks">0</div>
            <svg class="metric-spark" viewBox="0 0 120 32" preserveAspectRatio="none" aria-hidden="true">
              <path d="M1 22 L40 22 C60 22, 80 22, 100 22 C108 22, 116 22, 119 20" stroke="#10b981" stroke-width="2" fill="none"/>
            </svg>
          </div>
        </div>
        <div class="metric-card metric-orange">
          <div class="metric-title">Pending Approvals</div>
          <div class="metric-row">
            <div class="metric-value" id="pendingApprovals">0</div>
            <svg class="metric-spark" viewBox="0 0 120 32" preserveAspectRatio="none" aria-hidden="true">
              <path d="M1 22 C20 24, 40 20, 60 22 C80 24, 100 20, 119 24" stroke="#f59e0b" stroke-width="2" fill="none"/>
            </svg>
          </div>
        </div>
      </div>
    </div>

        </div>
      </section>
      <section id="org-goals" class="pms-panel">
    <h2 class="goals-page-title">Goals</h2>
    <div class="card mb-4">
        <div class="card-header bg-light"><strong>Goals</strong></div>
        <div class="card-body">
            <form id="goalsForm">
                @csrf
                <input type="hidden" name="id" id="goal_id">

                <!-- Row 1: Title, Period, Priority -->
                <div class="row g-3 mb-2">
                    <div class="col-md-4">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" id="title" name="title" class="form-control" placeholder="Goal Title" required>
                    </div>
                    <div class="col-md-4">
                        <label for="org_setting_id" class="form-label">Period</label>
                        <select name="org_setting_id" id="org_setting_id" class="form-control" required></select>
                    </div>
                    <div class="col-md-4">
                        <label for="priority" class="form-label">Priority</label>
                        <select name="priority" id="priority" class="form-control">
                            <option value="Critical" selected>Critical</option>
                            <option value="high">High</option>
                            <option value="medium" selected>Medium</option>
                            <option value="low">Low</option>
                        </select>
                    </div>
                </div>

                <!-- Row 2: Start & End Dates issue no - (3817) startdate enddate validation  -->
                 <div class="row g-3 mb-2">
                    <div class="col-md-3">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" id="start_date" name="start_date" class="form-control" required
                        value="{{ old('start_date', $activeCycle->start_date ?? '') }}"
                        min="{{ $activeCycle->start_date ?? '' }}" 
                        max="{{ $activeCycle->end_date ?? '' }}">
                    </div>
                    <div class="col-md-3">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" id="end_date" name="end_date" class="form-control" required
                        value="{{ old('end_date', $activeCycle->end_date ?? '') }}"
                        min="{{ $activeCycle->start_date ?? '' }}" 
                        max="{{ $activeCycle->end_date ?? '' }}">
                    </div>
                </div>

                <!-- Row 3: Description and Save Button -->
                <div class="row g-3 mb-2">
                    <div class="col-md-9">
                        <label for="description" class="form-label">Description</label>
                        <textarea id="description" name="description" class="form-control" placeholder="Description"></textarea>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-success w-100">Save</button>
                    </div>
                </div>

                
            </form>

<!-- Fixed header + scrollable body (scrollbar hidden visually) -->
<div style="margin-top:1rem;">

  <div class="goals-subheader"><span class="flag bi bi-flag-fill" aria-hidden="true"></span><span>Goals Created by Organization</span></div>

  <!-- Header table (fixed) -->
  <div class="table-fixed-header">
    <table class="table table-bordered table-striped m-0"
           style="width:100%; table-layout:fixed; border-collapse:collapse; margin-bottom:0;">
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
          <th style="padding:8px; background:#fff; border:1px solid #dee2e6; box-sizing:border-box;">Title</th>
          <th style="padding:8px; background:#fff; border:1px solid #dee2e6; box-sizing:border-box;">Period</th>
          <th style="padding:8px; background:#fff; border:1px solid #dee2e6; box-sizing:border-box;">Start Date</th>
          <th style="padding:8px; background:#fff; border:1px solid #dee2e6; box-sizing:border-box;">End Date</th>
          <th style="padding:8px; background:#fff; border:1px solid #dee2e6; box-sizing:border-box;">Priority</th>
          <th style="padding:8px; background:#fff; border:1px solid #dee2e6; box-sizing:border-box;">Status</th>
          <th style="padding:8px; background:#fff; border:1px solid #dee2e6; box-sizing:border-box;">Action</th>
        </tr>
      </thead>
    </table>
  </div>

  <!-- Scrollable table body (visual scrollbar hidden) -->
  <div class="table-scroll-container no-scrollbar" id="goalsScroll">
    <table class="table table-bordered table-striped m-0"
           style="width:100%; table-layout:fixed; border-collapse:collapse; margin-bottom:0;">
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

        </div>
      </section>
      <section id="org-task-approvals" class="pms-panel">
    <div class="card mb-4">
        <div class="card-header bg-light"><strong>Tasks Approvals</strong></div>
        <div class="card-body">
            <div class="d-flex justify-content-end mb-2">
                <!-- <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#createTaskModal">Add Task</button> -->
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

          <!-- Row 2: Start & End Dates issue no - (3817) startdate enddate validation -->
          <div class="row g-3 mb-2">
            <div class="col-md-6">
              <label for="task_start" class="form-label">Start Date</label>
              <input type="date" id="task_start" name="start_date" class="form-control" required
              min="{{ $activeCycle->start_date ?? '' }}" 
              max="{{ $activeCycle->end_date ?? '' }}">
            </div>
            <div class="col-md-6">
              <label for="task_end" class="form-label">End Date</label>
              <input type="date" id="task_end" name="end_date" class="form-control" required
              min="{{ $activeCycle->start_date ?? '' }}" 
              max="{{ $activeCycle->end_date ?? '' }}">
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

          <!-- Row 2: Start & End Dates issue no - (3817) startdate enddate validation, Status -->
          <div class="row g-3 mb-2">
            <div class="col-md-3">
              <label for="edit_start_date" class="form-label">Start Date</label>
              <input type="date" id="edit_start_date" class="form-control" required
               min="{{ $activeCycle->start_date ?? '' }}" 
              max="{{ $activeCycle->end_date ?? '' }}">
            </div>
            <div class="col-md-3">
              <label for="edit_end_date" class="form-label">End Date</label>
              <input type="date" id="edit_end_date" class="form-control" required
              min="{{ $activeCycle->start_date ?? '' }}" 
              max="{{ $activeCycle->end_date ?? '' }}">
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

        // show modal (move to <body> to avoid z-index/overflow contexts)
        const modalEl = document.getElementById("editGoalModal");
        if (modalEl && modalEl.parentElement !== document.body) {
          try { document.body.appendChild(modalEl); } catch(_) {}
        }
        // Ensure high z-index in case global CSS overrides were removed
        if (modalEl) { modalEl.style.zIndex = '3000'; }
        const ModalCtor = (window.bootstrap && window.bootstrap.Modal) ? window.bootstrap.Modal : null;
        if (ModalCtor) {
          const modal = ModalCtor.getOrCreateInstance(modalEl, { backdrop: true, focus: true });
          modal.show();
        } else {
          // Fallback: toggle classes if Bootstrap not available
          modalEl?.classList.add('show');
          modalEl?.setAttribute('style', (modalEl?.getAttribute('style')||'') + '; display:block;');
          const back = document.createElement('div'); back.className = 'modal-backdrop fade show'; back.style.zIndex='2990'; document.body.appendChild(back);
        }

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
                <td>${g.title}<br>
                <small class="description">${g.description || '—'}</small>
                </td>
                <td>${g.period_name || '-'}</td>
                <td>${g.start_date ? new Date(g.start_date).toLocaleDateString('en-GB') : '-'}</td>
                <td>${g.end_date ? new Date(g.end_date).toLocaleDateString('en-GB') : '-'}</td>
                <td>${g.priority}</td>
                <td>${g.status}</td>
                <td>
                    <button class="btn btn-sm btn-warning" onclick="editGoal(${g.id})">Edit</button>
                </td>
            </tr>`;
        });

    // Apply 3-row scroll cap ASAP after rows are inserted
    requestAnimationFrame(() => {
        setGoalsScrollHeightToThreeRows();
        // re-run shortly to account for font/layout settling
        setTimeout(setGoalsScrollHeightToThreeRows, 50);
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

// Helper: set #goalsScroll max-height to exactly 3 rows
function setGoalsScrollHeightToThreeRows(){
    const scrollBox = document.getElementById('goalsScroll');
    const tbody = document.getElementById('goalsTable');
    if (!scrollBox || !tbody) return;
    const rows = Array.from(tbody.querySelectorAll('tr'));
    if (rows.length === 0) { scrollBox.style.maxHeight = '0px'; return; }
    let sum = 0;
    for (let i = 0; i < Math.min(3, rows.length); i++) {
        sum += rows[i].offsetHeight || 0;
    }
    // include table borders/padding safety
    scrollBox.style.maxHeight = (sum + 6) + 'px';
}

// Recompute on resize in case fonts/layout change row height
window.addEventListener('resize', () => requestAnimationFrame(setGoalsScrollHeightToThreeRows));

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
