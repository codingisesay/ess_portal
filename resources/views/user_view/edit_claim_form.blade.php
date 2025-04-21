@extends('user_view.header')
@section('content')
<head>
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script> 
  <link rel="stylesheet" href="{{ asset('/user_end/css/homepage.css') }}">
  <link rel="stylesheet" href="{{ asset('user_end/css/leave.css') }}"> 
  <link rel="stylesheet" href="{{ asset('/user_end/css/homepage.css') }}"> 
<style>
.reimbursement-container {
  margin: 10px 20px;
}
th {
  background-color: #8A3366 !important;}
  .submit2 {
    border: 1px solid #8A3366 !important;
    color: #8A3366;background:white;
    padding: 7px 12px;
    border-radius: 8px;
    margin-left: auto;
    border: none;
}
.reimbursement-details{background:white; padding:20px; border-radius:10px; box-shadow:0 0 10px rgba(0,0,0,0.1);}
</style>
<div class="reimbursement-container">
  <h2>Edit Reimbursement Form</h2>
 
  <!-- FORM STARTS HERE -->
  <form action="{{ route('update_reimbursement_claims', ['reimbursement_traking_id' => $reimbursement_traking_id]) }}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="reimbursement_tracking_id" value="{{ $reimbursement_traking_id }}">
    
  <div class="reimbursement-details">
    <!-- Initial form details -->
    <div class="row mb-2">
      <div class="col-3">
        <div class="form-group">
            <div class="floating-label-wrapper">
                <input type="text" required class="input-field" name="clam_comment" value="{{ $reimbursementClaims[0]->description ?? '' }}">
                <label for="project">Title of Claim</label>
            </div>
        </div>          
      </div>  
    </div> 
    <!-- Add Bills Button -->

     <div class="d-flex justify-content-between align-items-center mb-3">
     <h4  class="my-2">Bills Details</h4>
    </div>

    <div class="clearfix"></div>

    <div class="tbl-container">
      <!-- Bills Table -->
      <table class="table table-striped" id="billsTable">
        <thead>
          <tr>
            <th>S.no</th>
            <th>Date</th>
            <th>Type</th>
            <th>Max Amount</th>
            <th>Entry Amount</th>
            <th>Upload Bill</th>
            <th>Description</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($reimbursementClaims as $index => $claim)
          <tr>
            <td>{{ $index + 1 }}</td>
            <td>
              <input type="date" name="bill_date[{{ $index }}]" class="form-control" value="{{ \Carbon\Carbon::parse($claim->entry_date)->format('Y-m-d') }}" required>
            </td>
            <td>
              <select class="form-control rm_type" name="type[{{ $index }}]" required>
                <option value="">Select One</option>
                @foreach($reim_type as $rt)
                <option value="{{ $rt->id }}" {{ $rt->id == $claim->organisation_reimbursement_types_id ? 'selected' : '' }}>{{ $rt->name }}</option>
                @endforeach
              </select>
            </td>
            <td><input type="text" class="form-control" value="{{ $claim->max_amount ?? '' }}" disabled></td>
            <td><input type="number" name="entered_amount[{{ $index }}]" class="form-control" value="{{ $claim->entry_amount }}" step="0.01" required></td>
            <td>
              @if ($claim->upload_bill)
                <a href="{{ asset('storage/' . $claim->upload_bill) }}" target="_blank">View Bill</a>
              @else
                No Bill Uploaded
              @endif
              <input type="file" name="bills[{{ $index }}]" class="form-control mt-2" accept=".jpg,.jpeg,.png,.pdf">
            </td>
            <td><textarea class="form-control" rows="1" name="comments[{{ $index }}]" placeholder="Comment">{{ $claim->description_by_applicant }}</textarea></td>
          </tr>
          @endforeach
        </tbody>  
      </table>
    </div>
    <!-- Submit Button --> <br>
     <div style="text-align:right">
    <button type="submit" class="apply-leave">&nbsp;Save Changes&nbsp;</button>
</div>
    </div>
  </form>
  <!-- FORM ENDS HERE -->

</div>

<script>
  $(document).ready(function () {
    $(document).on('change', '.rm_type', function () {
      var rm_type_id = $(this).val();
      var $row = $(this).closest('tr');
      var $maxAmountInput = $row.find('input[name$="[max_amount]"]');

      $.ajax({
        url: '/user/get_max_amount/' + rm_type_id,
        type: 'GET',
        success: function (response) {
          $maxAmountInput.val(response.max_amount);
        },
        error: function (xhr, status, error) {
          console.error('Error:', error);
        }
      });
    });
  });
</script>
@endsection
