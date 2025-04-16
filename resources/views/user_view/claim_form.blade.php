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
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
</head>
<body>

<div class="container-fluid">
  <h2>Reimbursement Form</h2>

  <!-- FORM STARTS HERE -->
  <form action="{{ route('insert_Reimbursement_Form') }}" method="post" enctype="multipart/form-data">
    @csrf
    <!-- Initial form details -->
    <div class="row mb-3">
      <div class="col">
        <textarea class="form-control" rows="1" placeholder="Comment" name="clam_comment"></textarea>
      </div>
      <div class="col">
        <input type="date" class="form-control" name="start_date" placeholder="From Date" required>
      </div>
      <div class="col">
        <input type="date" class="form-control" name="end_date" placeholder="To Date" required>
      </div>
    </div>

    <!-- Add Bills Button -->
    <button type="button" class="btn btn-primary float-right mb-3" onclick="addRow()">Add Bills</button>

    <div class="clearfix"></div>

    <!-- Bills Table -->
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
        <!-- Dynamic rows will be added here -->
      </tbody>
    </table>

    <!-- Submit Button -->
    <button type="submit" class="btn btn-success">Submit</button>
  </form>
  <!-- FORM ENDS HERE -->

</div>

<!-- JavaScript -->
<script>
  function addRow() {
    const tableBody = document.querySelector('#billsTable tbody');
    const rowCount = tableBody.rows.length + 1;

    const row = document.createElement('tr');

    row.innerHTML = `
      <td>${rowCount}</td>
      <td><input type="date" name="bill_date[]" class="form-control" required></td>
      <td>
        <select class="form-control rm_type" name="type[]" required>
          <option value="">Select One</option>
          @foreach($reim_type as $rt)
          <option value="{{ $rt->id }}">{{ $rt->name }}</option>
          @endforeach
        </select>
      </td>
      <td><input type="text" name="max_amount[]" class="form-control" step="0.01" disabled></td>
      <td><input type="number" name="entered_amount[]" class="form-control" step="0.01" required></td>
      <td><input type="file" name="bills[]" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required></td>
      <td><textarea class="form-control" rows="1" name="comments[]" placeholder="Comment"></textarea></td>
      <td><button type="button" class="btn btn-danger" onclick="deleteRow(this)">Delete</button></td>
    `;

    tableBody.appendChild(row);
    updateSerialNumbers();
  }

  function deleteRow(button) {
    const row = button.closest('tr');
    row.remove();
    updateSerialNumbers();
  }

  function updateSerialNumbers() {
    const rows = document.querySelectorAll('#billsTable tbody tr');
    rows.forEach((row, index) => {
      row.cells[0].innerText = index + 1;
    });
  }


  $(document).ready(function () {
  // Delegated event for dynamically added .rm_type elements
  $(document).on('change', '.rm_type', function () {
    var rm_type_id = $(this).val(); // Selected value
    var $row = $(this).closest('tr'); // Get the current row
    var $maxAmountInput = $row.find('input[name="max_amount[]"]'); // Input in same row

    $.ajax({
      url: '/user/get_max_amount/' + rm_type_id,
      type: 'GET',
      success: function (response) {
        // Fill in the value returned by the server
        $maxAmountInput.val(response.max_amount);
        console.log(response.max_amount);
      },
      error: function (xhr, status, error) {
        console.error('Error:', error);
      }
    });
  });
});


</script>

</body>
</html>
