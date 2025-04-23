@extends('user_view.header')
@section('content')
 
 
  <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>-->
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script> 
  <link rel="stylesheet" href="{{ asset('/user_end/css/homepage.css') }}">
 <!-- Option 1: Include in HTML --> 
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
 <style>
 
        .file-upload {
            position: relative;
            overflow: hidden; 
        }
   
      
        .imagePreview {
            height:30px;
            width: 50px;
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center; 
            border-radius: 4px;
            display: none;
        }
        .profileimg {
            position: absolute;
            top: 0;
            left: 0; 
            opacity: 0; 
            width:15px;
            cursor: pointer;
        }
        .modal-backdrop.fade.show{display:none}
    </style>
      <div class="reimbursement-container">
        <h2>Reimbursement Form</h2>
    


        <!-- FORM STARTS HERE -->
        <form action="{{ route('insert_Reimbursement_Form') }}" method="post" enctype="multipart/form-data">
          @csrf
          
          <div class="reimbursement-details">
            <!-- Initial form details -->
            <div class="row mb-2">
              <!-- {{-- <div class="col-3">
                <div class="form-group">
                    <div class="floating-label-wrapper">
                        <input type="text" class="input-field" value="John Doe" disabled >
                        <label for="project">Employee Name</label>
                    </div>
                </div>          
              </div>   --}}
              {{-- <div class="col-3">
                <div class="form-group">
                    <div class="floating-label-wrapper">
                        <input type="date" class="input-field" palceholder="Enter title for claim" disabled >
                        <label for="project">Claim Date</label>
                    </div>
                </div>          
              </div>   --}} -->
              <div class="col-3">
                <div class="form-group">
                    <div class="floating-label-wrapper">
                        <input type="text" required class="input-field" name="clam_comment" >
                        <label for="project">Title of Claim</label>
                    </div>
                </div>          
              </div>  
            </div> 
            <!-- Add Bills Button -->

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4  class="my-2">Bills Details</h4>
                <button type="button" class="submit2" onclick="addRow()"> +&nbsp;Add&nbsp;Bills</button>
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
                    <th class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- Dynamic rows will be added here -->
                </tbody>  
                    
                <tfoot> 
                  <tr>
                    <td colspan="3" class="text-end"><strong>Total</strong></td>
                    <td class="text-end"><strong id="totalMaxAmount" >₹0.00</strong></td>
                    <td class="text-end"><strong id="totalEntryAmount" >₹0.00</strong></td>
                    <td colspan="3"></td>
                  </tr>
                </tfoot>
              </table>
            </div>
            <!-- Submit Button --> <br>
            <div style="text-align:right">
              <button type="submit" class="apply-leave">&nbsp;Submit&nbsp;</button>
            </div>
          </div>
        </form>
        <!-- FORM ENDS HERE -->

      </div>

<!-- JavaScript -->
<script>

  function updateTotals() {
      let totalMax = 0;
      let totalEntry = 0;

      $('#billsTable tbody tr').each(function () {
        const maxAmount = parseFloat($(this).find('input[name="max_amount[]"]').val()) || 0;
        const entryAmount = parseFloat($(this).find('input[name="entered_amount[]"]').val()) || 0;

        totalMax += maxAmount;
        totalEntry += entryAmount;
      });

      $('#totalMaxAmount').text('₹' + totalMax.toFixed(2));
      $('#totalEntryAmount').text('₹' + totalEntry.toFixed(2));
    }

    // Update totals when amounts change
    $(document).on('input', 'input[name="entered_amount[]"], input[name="max_amount[]"]', function () {
      updateTotals();
    });

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
        <td><input type="text" name="max_amount[]" class="form-control text-end" step="0.01" disabled></td>
        <td><input type="number" name="entered_amount[]" class="form-control text-end" step="0.01" required></td>
        <td> 
        <div class="file-upload">
            <div class="file-select d-flex align-items-center">
                <span class="me-2 my-2"><x-icon name="upload" /></span> 
                <input type="file" name="bills[]" class="profileimg" accept=".jpg,.jpeg,.png,.pdf" required>
                <div class="imagePreview"></div>
            </div>
        </div>
            
        </td>
        <td><textarea class="form-control" rows="1" name="comments[]" placeholder="Comment"></textarea></td>
        <td><button type="button" class="btn border-0 text-danger" onclick="deleteRow(this)"><x-icon name="trash" /></button></td>
      `;

      tableBody.appendChild(row);
      updateSerialNumbers();
      updateTotals();
    }

    function deleteRow(button) {
      const row = button.closest('tr');
      row.remove();
      updateSerialNumbers();
      updateTotals();
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
          // console.log(response.max_amount);
          updateTotals();
        },
        error: function (xhr, status, error) {
          console.error('Error:', error);
        }
      });
    });
  });
  
</script>
<!--  
<script>
    const today = new Date();
    const year = today.getFullYear();
    let month = today.getMonth() + 1;
    let day = today.getDate();

    month = month < 10 ? '0' + month : month;
    day = day < 10 ? '0' + day : day;

    const formattedDate = `${year}-${month}-${day}`;
    document.getElementById('todayDate').value = formattedDate;
</script> -->



<script>
        $(document).ready(function() {
            $(document).on('change', '.file-upload input[type="file"]', function() {
                var filename = $(this).val();
                if (/^\s*$/.test(filename)) {
                    $(this).parents(".file-upload").find(".file-select-name").text("No file chosen...");
                    $(this).parents(".file-upload").find(".imagePreview").hide();
                } else {
                    $(this).parents(".file-upload").find(".file-select-name").text(filename.substring(filename.lastIndexOf("\\") + 1, filename.length));
                }

                var uploadFile = $(this);
                var files = !!this.files ? this.files : [];
                if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

                if (/^image/.test(files[0].type)) { // only image file
                    var reader = new FileReader(); // instance of the FileReader
                    reader.readAsDataURL(files[0]); // read the local file

                    reader.onloadend = function() { // set image data as background of div
                        var preview = uploadFile.closest(".file-upload").find('.imagePreview');
                        preview.css("background-image", "url(" + this.result + ")");
                        preview.show(); preview.data('image-src', this.result);
                    }
                } else if (files[0].type === 'application/pdf') {
                    // For PDF files, show a PDF icon or text
                    var preview = uploadFile.closest(".file-upload").find('.imagePreview');
                    preview.css("background-image", "url('')");
                    preview.show();   preview.removeData('image-src');
                } else {
                    // For other file types, hide the preview
                    uploadFile.closest(".file-upload").find('.imagePreview').hide();
                }
            });

            var imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
                   // Click handler for image preview
                   $(document).on('click', '.imagePreview', function() {
                var imageSrc = $(this).data('image-src'); 
                if (imageSrc) {
                    $('#modalImage').attr('src', $(this).data('image-src'));
                    imageModal.show();
                }
            });
        });
</script>


    <!-- Modal for enlarged image -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header p-0">
                    <h6 class="modal-title mb-3">Image Preview</h6>
                    <span class="btn-close fw-normal" data-bs-dismiss="modal" aria-label="Close" ></span>
                    <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                </div>
                <div class="modal-body text-center">
                    <img src="" class="modal-image-preview" id="modalImage">
                </div>
                <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div> -->
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">

 <!--  // <td><input type="file" name="bills[]" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required></td> -->
@endsection