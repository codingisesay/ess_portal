<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Add Bills</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container-fluid">
  <h2>Reimbursement Form</h2>

  <!-- Initial static input (optional) -->
  <div class="row">
    <div class="col">
      <textarea class="form-control" rows="1" placeholder="Comment"></textarea>
    </div>
    <div class="col">
      <input type="date" class="form-control" placeholder="From Date">
    </div>
    <div class="col">
      <input type="date" class="form-control" placeholder="To Date">
    </div>
  </div>
  <br>

  <!-- Add Bills Button -->
  <button class="btn btn-primary float-right" onclick="addRow()">Add Bills</button>
  <br>
</div>

<!-- Table to show/edit submitted bills -->
<div class="container-fluid">
    <h4>Submit Bills Details</h4>
    <table class="table table-bordered" id="billsTable">
      <thead>
        <tr>
          <th>S.no</th>
          <th>Date</th>
          <th>Type</th>
          <th>Max Amount</th>
          <th>Entry Amount</th>
          <th>Upload Bill</th>
          <th>Description</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <!-- Editable rows will be added here -->
        
      </tbody>
      
    </table>
    <button type="">Submit</button>
  </div>
  
  <script>
    function addRow() {
      const tableBody = document.querySelector('#billsTable tbody');
      const row = document.createElement('tr');
  
      row.innerHTML = `
        <td>1</td>
        <td><input type="date" class="form-control"></td>
        <td>
            <select class="form-control">
                <option>Select One</option>
                <option>Food</option>
                <option>Movie</option>
                <option>Hotel</option>
                </select>
            </td>
        <td><input type="number" class="form-control"></td>
        <td><input type="number" class="form-control"></td>
        <td><input type="file" class="form-control"></td>
        <td><textarea class="form-control" rows="1" placeholder="Comment"></textarea></td>
        <td><button class="btn btn-danger" onclick="deleteRow(this)">Delete</button></td>
      `;
  
      tableBody.appendChild(row);
    }
  
  
    function deleteRow(button) {
      const row = button.closest('tr');
      row.remove();
    }
  </script>

</body>
</html>
