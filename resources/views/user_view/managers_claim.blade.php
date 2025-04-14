@extends('user_view.header')
@section('content')
<?php 
error_reporting(0);
?>
<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container-fluid">
  

  <!-- Reporting Manager Section -->
  <div class="row">
    <div class="col-md-12">
      <h3>Reporting Manager: <span id="manager-name">Paresh Sir</span></h3>
      <button id="view-approved-users" class="btn btn-primary">View</button>
    </div>
  </div>

  <!-- Approved Users Section -->
  <div id="approved-users-section" style="display:none; margin-top:20px;">
    <h4>Approved Users:</h4>
    <ul id="approved-users-list" class="list-group">
      <!-- Dynamically populated -->
    </ul>
  </div>

  <!-- Bundles Section -->
  <div id="user-bundles-section" style="display:none; margin-top:20px;">
    <h4 id="selected-user-name"></h4>
    <ul id="user-bundles-list" class="list-group">
      <!-- Dynamically populated -->
    </ul>
  </div>

  <!-- Bills Section -->
  <div id="bundle-bills-section" style="display:none; margin-top:20px;">
    <h4 id="selected-bundle-name"></h4>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>S.No.</th>
          <th>Date</th>
          <th>Type</th>
          <th>Max Amount</th>
          <th>Entered Amount</th>
          <th>Bill</th>
          <th>Claim Desc</th>
        </tr>
      </thead>
      <tbody id="bundle-bills-list">
        <!-- Dynamically populated -->
      </tbody>
    </table>
  </div>
</div>

<script>
  // Select all checkboxes with the class
  const checkboxes = document.querySelectorAll('.approval-checkbox');

  checkboxes.forEach(checkbox => {
    checkbox.addEventListener('change', function () {
      // Get the textarea next to the checkbox
      const textarea = this.nextElementSibling;

      if (!this.checked) {
        textarea.style.display = 'block';
      } else {
        textarea.style.display = 'none';
      }
    });
  });

  // Mock data for demonstration
  const approvedUsers = [
    { name: 'Ankita', bundles: [
      { id: 'bundle-001', name: 'Bundle 1', bills: [
        { sno: 1, date: '01/01/2020', type: 'Food', maxAmount: 250, enteredAmount: 500, bill: '', desc: 'Lunch' },
        { sno: 2, date: '02/01/2020', type: 'Travel', maxAmount: 300, enteredAmount: 400, bill: '', desc: 'Taxi' }
      ]},
      { id: 'bundle-002', name: 'Bundle 2', bills: [
        { sno: 1, date: '03/01/2020', type: 'Hotel', maxAmount: 1000, enteredAmount: 1200, bill: '', desc: 'Stay' }
      ]}
    ]},
    { name: 'om', bundles: [
      { id: 'bundle-003', name: 'Bundle 3', bills: [
        { sno: 1, date: '04/01/2020', type: 'Food', maxAmount: 200, enteredAmount: 250, bill: '', desc: 'Dinner' }
      ]}
    ]}
  ];

  // Show approved users on "View" button click
  document.getElementById('view-approved-users').addEventListener('click', function() {
    const usersSection = document.getElementById('approved-users-section');
    const usersList = document.getElementById('approved-users-list');
    usersList.innerHTML = ''; // Clear previous data

    approvedUsers.forEach(user => {
      const li = document.createElement('li');
      li.className = 'list-group-item';
      li.textContent = user.name;
      li.style.cursor = 'pointer';
      li.addEventListener('click', function() {
        showUserBundles(user);
      });
      usersList.appendChild(li);
    });

    usersSection.style.display = 'block';
  });

  // Show bundles of the selected user
  function showUserBundles(user) {
    const bundlesSection = document.getElementById('user-bundles-section');
    const bundlesList = document.getElementById('user-bundles-list');
    const userName = document.getElementById('selected-user-name');
    bundlesList.innerHTML = ''; // Clear previous data
    userName.textContent = `Bundles of ${user.name}`;

    user.bundles.forEach(bundle => {
      const li = document.createElement('li');
      li.className = 'list-group-item';
      li.textContent = bundle.name;
      li.style.cursor = 'pointer';
      li.addEventListener('click', function() {
        showBundleBills(bundle);
      });
      bundlesList.appendChild(li);
    });

    bundlesSection.style.display = 'block';
  }

  // Show bills of the selected bundle
  function showBundleBills(bundle) {
    const billsSection = document.getElementById('bundle-bills-section');
    const billsList = document.getElementById('bundle-bills-list');
    const bundleName = document.getElementById('selected-bundle-name');
    billsList.innerHTML = ''; // Clear previous data
    bundleName.textContent = `Bills in ${bundle.name}`;

    bundle.bills.forEach((bill, index) => {
      const row = document.createElement('tr');
      row.innerHTML = `
        <td>${index + 1}</td>
        <td>${bill.date}</td>
        <td>${bill.type}</td>
        <td>${bill.maxAmount}</td>
        <td>${bill.enteredAmount}</td>
        <td>${bill.bill}</td>
        <td>${bill.desc}</td>
      `;
      billsList.appendChild(row);
    });

    billsSection.style.display = 'block';
  }
</script>
</body>
</html>
@endsection
