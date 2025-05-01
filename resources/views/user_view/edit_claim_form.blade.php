@extends('user_view.header')
@section('content')
<head>
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script> 
  <link rel="stylesheet" href="{{ asset('/user_end/css/homepage.css') }}">
  <link rel="stylesheet" href="{{ asset('user_end/css/leave.css') }}"> 
  <link rel="stylesheet" href="{{ asset('/user_end/css/homepage.css') }}"> 
 
<div class="mx-3">
  <h2> <span class="back-btn mx-3" onclick="history.back()"> &lt; </span>Edit Reimbursement Form</h2>
 
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
      <table id="billsTable">
        <thead>
          <tr>
            <th>Sr.No.</th>
            <th>Date</th>
            <th>Type</th>
            <th>Max Amount</th>
            <th>Entry Amount</th>
            <th>Upload Bill</th>
            <th>Description</th>
            <th>Manager Description</th>
            <th>Account Description</th>
          </tr>
        </thead>
<tbody>
  @foreach ($reimbursementClaims as $index => $claim)
  <tr>
    <td>{{ $index + 1 }}</td>
    <td>
      <input type="hidden" name="entry_ids[]" value="{{ $claim->id }}" />
      <input type="date" name="bill_date[{{ $index }}]" class="form-control" 
             value="{{ \Carbon\Carbon::parse($claim->entry_date)->format('Y-m-d') }}" 
             {{ $claim->status != 'REVERT' ? 'disabled' : '' }} required>
    </td>
    <td>
      <select class="form-control rm_type" name="type[{{ $index }}]" 
              {{ $claim->status != 'REVERT' ? 'disabled' : '' }} required>
        <option value="">Select One</option>
        @foreach($reim_type as $rt)
        <option value="{{ $rt->id }}" {{ $rt->id == $claim->organisation_reimbursement_types_id ? 'selected' : '' }}>
          {{ $rt->name }}
        </option>
        @endforeach
      </select>
    </td>
    <td>
      <input type="text" class="form-control text-end" value="{{ $claim->max_amount ?? '' }}" disabled>
    </td>
    <td>
      <input type="number" name="entered_amount[{{ $index }}]" class="form-control text-end" 
             value="{{ $claim->entry_amount }}" step="0.01" 
             {{ $claim->status != 'REVERT' ? 'disabled' : '' }} required>
    </td>
    <td>
      <div class="file-upload d-flex">
        <div class="file-select d-flex align-items-center">
          <div class="image-preview-container me-2 d-flex align-items-center">
            <div class="upload-icon-input me-2">
              <x-icon name="upload" />
              <input type="file" name="bills[{{ $index }}]" class="file-input" 
                     accept=".jpg,.jpeg,.png,.pdf" data-index="{{ $index }}" 
                     {{ $claim->status != 'REVERT' ? 'disabled' : '' }}>
            </div>
            @if ($claim->upload_bill)
              @if (Str::endsWith($claim->upload_bill, ['.jpg', '.jpeg', '.png']))
                <img src="{{ asset('storage/' . $claim->upload_bill) }}" class="existing-image img-thumbnail" 
                     width="50" height="50" style="cursor: pointer;" 
                     data-bs-toggle="modal" data-bs-target="#imageModal" 
                     data-img="{{ asset('storage/' . $claim->upload_bill) }}">
              @elseif (Str::endsWith($claim->upload_bill, '.pdf'))
                <div class="pdf-preview d-flex flex-column align-items-center justify-content-center bg-light">
                  <x-icon name="file-text" class="text-primary" size="48" />
                  <small class="text-muted mt-1">PDF</small>
                </div>
              @endif
            @else
              <img src="#" class="new-image-preview img-thumbnail" width="50" height="50" style="display:none;">
            @endif
          </div>
        </div>
      </div>
    </td>
    <td>
      <textarea class="form-control" rows="1" name="comments[{{ $index }}]" 
                placeholder="Comment" {{ $claim->status != 'REVERT' ? 'disabled' : '' }}>
        {{ $claim->description_by_applicant }}
      </textarea>
    </td>
    <td>
      <textarea class="form-control" rows="1" name="manager_comments[{{ $index }}]" 
                disabled placeholder="Comment">{{ $claim->description_by_manager }}</textarea>
    </td>
    <td>
      <textarea class="form-control" rows="1" name="finance_comments[{{ $index }}]" 
                disabled placeholder="Comment">{{ $claim->description_by_finance }}</textarea>
    </td>
  </tr>
  @endforeach
</tbody>

<script>
document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('.file-input').forEach(input => {
    input.addEventListener('change', function(e) {
      const index = this.getAttribute('data-index');
      const file = e.target.files[0];
      const previewContainer = this.closest('.file-select').querySelector('.image-preview-container');
      
      if (file) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
          // Hide existing previews
          previewContainer.querySelector('.existing-image')?.style.setProperty('display', 'none');
          previewContainer.querySelector('.pdf-preview')?.style.setProperty('display', 'none');
          previewContainer.querySelector('.no-file-placeholder')?.style.setProperty('display', 'none');
          
          // Show or create new image preview
          let newPreview = previewContainer.querySelector('.new-image-preview');
          if (!newPreview) {
            newPreview = document.createElement('img');
            newPreview.className = 'new-image-preview img-thumbnail';
            newPreview.width = 100;
            newPreview.height = 100;
            previewContainer.appendChild(newPreview);
          }
          
          if (file.type.match('image.*')) {
            newPreview.src = e.target.result;
            newPreview.style.display = 'block';
          } else if (file.name.endsWith('.pdf')) {
            // For PDF files, show PDF icon
            const pdfPreview = document.createElement('div');
            pdfPreview.className = 'pdf-preview d-flex flex-column align-items-center justify-content-center bg-light';
            pdfPreview.style.width = '100px';
            pdfPreview.style.height = '100px';
            pdfPreview.innerHTML = `
              <x-icon name="file-text" class="text-primary" size="48" />
              <small class="text-muted mt-1">PDF</small>
            `;
            previewContainer.appendChild(pdfPreview);
          }
        }
        
        if (file.type.match('image.*')) {
          reader.readAsDataURL(file);
        } else if (file.name.endsWith('.pdf')) {
          // Trigger onload for PDF
          reader.readAsDataURL(new Blob(['PDF'], {type: 'application/pdf'}));
        }
      }
    });
  });
});
</script>



 
      </table>
    </div>
    <!-- Submit Button --> <br>
     <div style="text-align:right">
     <button type="button" class="btn btn-secondary py-2 me-3 fw-normal" id="cancelButton">&nbsp;Cancel&nbsp;</button>
     <button type="submit" class="apply-leave">&nbsp;Save Changes&nbsp;</button>
  </div>
    </div>
  </form>
  <!-- FORM ENDS HERE -->
 <!-- Hidden Cancel Form -->
<form id="cancelForm" action="{{ route('cancel.reimbursement', ['reimbursement_traking_id' => $reimbursement_traking_id]) }}" method="post" style="display: none;">
    @csrf
</form>
</div>

<script>
    document.getElementById('cancelButton').addEventListener('click', function () {
        if (confirm('Are you sure you want to cancel this reimbursement?')) {
            document.getElementById('cancelForm').submit();
        }
    });
</script>

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


<!-- image handel below -->
 <!-- Bootstrap Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
  <div class="modal-header p-0">
    <h6 class="modal-title mb-2">Image Preview</h6>
    <span class=" " data-bs-dismiss="modal" aria-label="Close" >&times;</span> 
  </div>
      <div class="modal-body text-center">
        <img src="" id="modalImage" class="img-fluid" alt="Zoomed Image">
      </div>
    </div>
  </div>
</div>
<script>
    // Wait until the DOM is loaded
    document.addEventListener('DOMContentLoaded', function () {
        const modalImage = document.getElementById('modalImage');
        const imageModal = document.getElementById('imageModal');

        document.querySelectorAll('.existing-image').forEach(img => {
            img.addEventListener('click', function () {
                const imgSrc = this.getAttribute('data-img');
                modalImage.src = imgSrc;
            });
        });

        // Optional: Clear the image when modal is closed
        imageModal.addEventListener('hidden.bs.modal', function () {
            modalImage.src = '';
        });
    });
</script>
<style>
  .image-preview-container {
    position: relative;
  }
  .existing-image, .new-image-preview, .pdf-preview, .no-file-placeholder {
    border: 1px solid #dee2e6;
    border-radius: 4px;
    object-fit: contain;
  }
  .file-input {
    width: 20px;
    height: 50px;
    opacity: 1;
    overflow: hidden;
    position: absolute; 
  }
  .upload-icon-input{position: relative;}
  .upload-icon-input input{position:absolute; top:0; left:0; width:100%; height:100%; opacity:0;}
</style>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

@endsection
