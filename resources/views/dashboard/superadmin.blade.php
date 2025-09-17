@extends('superadmin_view/superadmin_layout')  <!-- Extending the layout file -->
@section('content')  <!-- Defining the content section -->
<link rel="stylesheet" href="{{ asset('errors/error.css') }}">

<?php 
$id = Auth::guard('superadmin')->user()->id;
?>

 
<link rel="stylesheet" href="{{ asset('admin_end/css/admin_dashboard.css') }}" />

  <div class="container">
    <div class="topbar">
      <div class="brand">
        <div class="logoo">PV</div>
        <div>
          <h1 class="h-title">Super Admin Dashboard </h1>
          <div class="h-sub">Human Resource Management System</div>
        </div>
      </div>

      <!-- Logout -->
      <a href="{{ route('superadmin.logout') }}" class="logout-btn" title="Logout">
        <!-- logout icon (simple door arrow) -->
        <svg viewBox="0 0 24 24" fill="none" aria-hidden><path d="M16 17l5-5-5-5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><path d="M21 12H9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><path d="M13 5H6a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
        Logout
      </a>
    </div>

    <!-- Combined Card -->
    <section class="card" aria-labelledby="branch-users" style="margin-bottom:18px">
      <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;">
        <div>
          <h2 id="branch-users" style="margin:0;font-size:16px;display:flex;gap:10px;align-items:center;">
            <span class="badge">U</span>
            Branch Users
          </h2>
          <div class="small">User distribution across branches</div>
        </div>
        <!-- aggregated totals removed (left empty) -->
        <div class="small" id="summary-small" style="text-align:right"></div>
      </div>

      <!-- KPI Strip -->
      <div class="kpi-grid" id="kpi-strip"></div>

      <!-- Branch scroller (no global arrows) -->
      <div class="carousel-wrap">
        <div class="branch-scroller" id="branch-scroller" tabindex="0" aria-label="Branch list"></div>
      </div>
    </section>

    <!-- Departments & Policies row (both use same pattern) -->
    <div class="row">
      <!-- Departments (acts like policies) -->
      <section class="card">
        <div class="section-title">
          <div class="badge">D</div>
          <div>
            <div style="font-weight:700">Departments</div>
            <div class="small">Searchable categories (tap to expand)</div>
          </div>
        </div>

        <div class="shared-search">
          <input id="dept-search" placeholder="Search departments or roles..." aria-label="Search departments"/>
        </div>

        <div id="departments-list" class="shared-list" aria-live="polite"></div>
      </section>

      <!-- Policies -->
      <section class="card">
        <div class="section-title">
          <div class="badge">P</div>
          <div>
            <div style="font-weight:700">Company Policies</div>
            <div class="small">Categories & guidelines</div>
          </div>
        </div>

        <div class="shared-search">
          <input id="policy-search" placeholder="Search policies..." aria-label="Search policies"/>
        </div>

        <div id="policies-list" class="shared-list" aria-live="polite"></div>
      </section>
    </div>
  </div>

  <!-- modal (hidden) -->
  <div id="modalRoot" style="display:none"></div>

<script>
/* --------------------------
   DATA (kept same as your original)
----------------------------*/
const branchData = [
  { name: "Payvance - Mumbai", totalEmployees: 300, activeCount: 245, inactiveCount: 55, departmentsCount: 8 },
  { name: "Payvance - Pune", totalEmployees: 120, activeCount: 95, inactiveCount: 25, departmentsCount: 5 },
  { name: "Payvance - Bangalore", totalEmployees: 180, activeCount: 150, inactiveCount: 30, departmentsCount: 6 },
  { name: "Payvance - Delhi", totalEmployees: 220, activeCount: 185, inactiveCount: 35, departmentsCount: 7 },
  { name: "Payvance - Chennai", totalEmployees: 90, activeCount: 75, inactiveCount: 15, departmentsCount: 4 },
];

const departments = [
  { name: "HR", items: ["HR Manager", "Recruiter", "HR Executive", "Training Coordinator"] },
  { name: "Accounts", items: ["Accountant", "Finance Manager", "Accounts Executive", "Auditor"] },
  { name: "Admin", items: ["Admin Manager", "Office Assistant", "Facility Manager", "Security Officer"] },
  { name: "Corporate", items: ["Corporate Manager", "Business Analyst", "Strategy Consultant", "Operations Head"] },
  { name: "Development", items: ["Software Engineer", "Senior Developer", "Tech Lead", "DevOps Engineer", "QA Engineer"] },
  { name: "PMO", items: ["Project Manager", "Scrum Master", "Business Analyst", "Program Manager"] },
  { name: "Testing", items: ["QA Tester", "Test Lead", "Automation Engineer", "Performance Tester"] },
  { name: "Management", items: ["CEO", "CTO", "VP Engineering", "Director", "General Manager"] },
];

const policies = [
  { category: "Leave Policy", description: "Guidelines for leave applications", items: ["Annual Leave", "Sick Leave", "Maternity Leave", "Paternity Leave", "Emergency Leave"] },
  { category: "Work From Home Policy", description: "Remote work & equipment", items: ["Remote Work Guidelines", "Equipment Policy", "Communication Standards", "Performance Metrics"] },
  { category: "Travel Policy", description: "Travel & expense", items: ["Domestic Travel", "International Travel", "Accommodation Guidelines", "Expense Limits"] },
  { category: "Expense Policy", description: "Reimbursement rules", items: ["Meal Allowances", "Transportation", "Client Entertainment", "Training Expenses"] },
  { category: "Code of Conduct", description: "Behavior & ethics", items: ["Professional Behavior", "Confidentiality", "Conflict of Interest", "Social Media Guidelines"] },
];

/* --------------------------
   Helpers: SVG donut (colors use blue & orange)
----------------------------*/
function createDonutSVG(active, inactive, total) {
  const ns = 'http://www.w3.org/2000/svg';
  const svg = document.createElementNS(ns,'svg');
  svg.setAttribute('viewBox','0 0 100 100');
  svg.className = 'donut-svg';

  const r = 30, cx = 50, cy = 50, c = 2*Math.PI*r;
  const aRatio = total ? active/total : 0;
  const iRatio = total ? inactive/total : 0;

  const bg = document.createElementNS(ns,'circle');
  bg.setAttribute('cx',cx); bg.setAttribute('cy',cy); bg.setAttribute('r',r);
  bg.setAttribute('fill','transparent'); bg.setAttribute('stroke','#f3f4f6'); bg.setAttribute('stroke-width','14');
  svg.appendChild(bg);

  // Active: blue (#5fcdcf)
  const a = document.createElementNS(ns,'circle');
  a.setAttribute('cx',cx); a.setAttribute('cy',cy); a.setAttribute('r',r);
  a.setAttribute('fill','transparent'); a.setAttribute('stroke','#5fcdcf'); a.setAttribute('stroke-width','14');
  a.setAttribute('stroke-dasharray', `${(c*aRatio).toFixed(2)} ${c.toFixed(2)}`);
  a.setAttribute('stroke-linecap','round'); a.setAttribute('transform',`rotate(-90 ${cx} ${cy})`);
  svg.appendChild(a);

  // Inactive: lightblue (#b2eced)
  const b = document.createElementNS(ns,'circle');
  b.setAttribute('cx',cx); b.setAttribute('cy',cy); b.setAttribute('r',r);
  b.setAttribute('fill','transparent'); b.setAttribute('stroke','#b2eced'); b.setAttribute('stroke-width','14');
  b.setAttribute('stroke-dasharray', `${(c*iRatio).toFixed(2)} ${c.toFixed(2)}`);
  b.setAttribute('stroke-dashoffset', `-${(c*aRatio).toFixed(2)}`);
  b.setAttribute('stroke-linecap','round'); b.setAttribute('transform',`rotate(-90 ${cx} ${cy})`);
  svg.appendChild(b);

  const percent = total ? Math.round((active/total)*100) : 0;
  const text = document.createElementNS(ns,'text');
  text.setAttribute('x',cx); text.setAttribute('y',cy); text.setAttribute('text-anchor','middle');
  text.setAttribute('dominant-baseline','middle'); text.setAttribute('font-size','12'); text.setAttribute('fill','#071127');
  text.textContent = percent + '%';
  svg.appendChild(text);

  return svg;
}

/* --------------------------
   Render Branch Tiles (Details buttons removed)
----------------------------*/
const scroller = document.getElementById('branch-scroller');

function renderBranchTiles(){
  scroller.innerHTML = '';
  branchData.forEach((b, idx) => {
    const tile = document.createElement('div');
    tile.className = 'branch-tile';

    tile.innerHTML = `
      <div class="tile-head">
        <h3>${escapeHtml(b.name)}</h3>
        <p>${b.totalEmployees} Total Employees</p>
      </div>
    `;

    const body = document.createElement('div'); body.className = 'tile-body';

    const donutWrap = document.createElement('div'); donutWrap.className = 'donut-wrap';
    donutWrap.appendChild(createDonutSVG(b.activeCount, b.inactiveCount, b.totalEmployees));

    const right = document.createElement('div');
    right.innerHTML = `
      <div class="legend">
        <div class="row"><span style="display:inline-block;width:12px;height:12px;background:#0066CC;border-radius:3px"></span> Active Users</div>
        <div class="row"><span style="display:inline-block;width:12px;height:12px;background:#b2eced;border-radius:3px"></span> Inactive Users</div>
      </div>
    `;
    donutWrap.appendChild(right);
    body.appendChild(donutWrap);

    const stats = document.createElement('div'); stats.className = 'tile-stats';
    stats.innerHTML = `
      <div class="stat-box"><div class="value">${b.activeCount}</div><div class="desc">Active (${Math.round((b.activeCount/b.totalEmployees)*100)}%)</div></div>
      <div class="stat-box"><div class="value" style="color:#b2eced">${b.inactiveCount}</div><div class="desc">Inactive (${Math.round((b.inactiveCount/b.totalEmployees)*100)}%)</div></div>
    `;
    body.appendChild(stats);
    tile.appendChild(body);
    scroller.appendChild(tile);
  });
}
renderBranchTiles();

/* --------------------------
   KPI Strip and summary (summary cleared)
----------------------------*/
function updateKPIs(){
  const totalEmployees = branchData.reduce((s,b)=>s+b.totalEmployees,0);
  const totalActive = branchData.reduce((s,b)=>s+b.activeCount,0);
  const totalInactive = branchData.reduce((s,b)=>s+b.inactiveCount,0);
  const totalBranches = branchData.length;

  const kpi = document.getElementById('kpi-strip');
  kpi.innerHTML = `
    <div class="kpi"><div class="num">${totalEmployees}</div><div class="label">Total Employees</div></div>
    <div class="kpi" style="background:linear-gradient(180deg,rgba(112,40,81,0.05),rgba(138,51,102,0.03));border-color:rgba(138,51,102,0.08)"><div class="num">${totalActive}</div><div class="label">Total Active</div></div>
    <div class="kpi" style="background:linear-gradient(180deg,rgba(138,51,102,0.03),rgba(138,51,102,0.01));border-color:rgba(138,51,102,0.06)"><div class="num" style="color:#8A3366">${totalInactive}</div><div class="label">Total Inactive</div></div>
    <div class="kpi"><div class="num">${totalBranches}</div><div class="label">Branches</div></div>
  `;

  // Clear the small summary text (you asked to remove it)
  document.getElementById('summary-small').innerHTML = '';
}
updateKPIs();

/* --------------------------
   Department & Policy shared renderer (same UI)
   NOTE: For departments we removed the count text under header (only name + dropdown)
----------------------------*/
function renderSharedList(containerId, items, searchInputId, isDepartment){
  const container = document.getElementById(containerId);
  const input = document.getElementById(searchInputId);

  function doRender(filter = ''){
    container.innerHTML = '';
    const f = filter.trim().toLowerCase();
    const filtered = items.filter(it => {
      if(!f) return true;
      const hay = (it.name || it.category || '').toLowerCase();
      const extra = (it.items || it.designations || it.items || []).join(' ').toLowerCase();
      return hay.includes(f) || extra.includes(f) || (it.description && it.description.toLowerCase().includes(f));
    });

    if(filtered.length === 0){
      container.innerHTML = `<div class="small" style="padding:12px">No results for "${escapeHtml(f)}"</div>`;
      return;
    }

    filtered.forEach((it, idx) => {
      const wrapper = document.createElement('div'); wrapper.className = 'shared-card';
      const header = document.createElement('div'); header.className = 'shared-header';
      // For departments: show only name; for policies: show category + subtitle
      const label = isDepartment ? it.name : it.category;
      const subtitle = isDepartment ? '' : (it.description || '');
      // header: label + (subtitle only for policies)
      header.innerHTML = `<div><strong>${escapeHtml(label)}</strong>${subtitle ? `<div style="font-size:13px;opacity:.9">${escapeHtml(subtitle)}</div>` : ''}</div><div class="small">+</div>`;
      const body = document.createElement('div'); body.className = 'shared-body'; body.style.display = 'none';
      const list = (isDepartment ? it.items : it.items || []);
      list.forEach(li => {
        const d = document.createElement('div'); d.className = 'designation-card'; d.textContent = li;
        body.appendChild(d);
      });

      header.addEventListener('click', () => {
        const open = body.style.display === 'block';
        body.style.display = open ? 'none' : 'block';
        header.querySelector('div:last-child').textContent = open ? '+' : '-';
      });

      wrapper.appendChild(header); wrapper.appendChild(body);
      container.appendChild(wrapper);
    });
  }

  input.addEventListener('input', (e) => doRender(e.target.value));
  doRender('');
}

/* departments now use same pattern as policies */
const deptItems = departments.map(d => ({ name: d.name, items: d.items }));
const policyItems = policies.map(p => ({ category: p.category, description: p.description, items: p.items }));
renderSharedList('departments-list', deptItems, 'dept-search', true);
renderSharedList('policies-list', policyItems, 'policy-search', false);

/* --------------------------
   Modal for branch details (unchanged)
----------------------------*/
const modalRoot = document.getElementById('modalRoot');
function openBranchModal(branch){
  modalRoot.innerHTML = `
    <div class="modal-backdrop" role="dialog" aria-modal="true">
      <div class="modal">
        <h3>${escapeHtml(branch.name)}</h3>
        <p class="small">Employees: <strong>${branch.totalEmployees}</strong> • Active: <strong style="color:var(--color-1)">${branch.activeCount}</strong> • Inactive: <strong style="color:#FF8A00">${branch.inactiveCount}</strong></p>
        <hr style="margin:12px 0;border:none;border-top:1px solid rgba(16,24,40,0.05)"/>
        <p style="margin:0 0 10px">Departments: ${branch.departmentsCount}</p>
        <div style="display:flex;gap:8px;justify-content:flex-end;">
          <button id="closeModal" style="padding:8px 12px;border-radius:10px;border:1px solid rgba(16,24,40,0.06);background:#fff;cursor:pointer">Close</button>
          <button id="viewMore" style="padding:8px 12px;border-radius:10px;background:linear-gradient(90deg,var(--color-1),var(--color-2));color:#fff;border:none;cursor:pointer">View Branch</button>
        </div>
      </div>
    </div>
  `;
  modalRoot.style.display = 'block';

  document.getElementById('closeModal').addEventListener('click', closeModal);
  document.getElementById('viewMore').addEventListener('click', () => {
    alert('Open branch detail page for: ' + branch.name);
  });
}
function closeModal(){ modalRoot.style.display = 'none'; modalRoot.innerHTML = ''; }

/* --------------------------
   Logout action
----------------------------*/
document.getElementById('logoutBtn').addEventListener('click', () => {
  // placeholder: replace with real logout
  if(confirm('Do you want to logout?')) {
    // in real app: call logout endpoint, clear tokens, redirect
    alert('Logged out (demo)');
  }
});

/* --------------------------
   Utilities
----------------------------*/
function escapeHtml(unsafe){
  if(!unsafe) return '';
  return String(unsafe).replace(/[&<"'>]/g, m => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[m]));
}
</script>
@endsection

