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
            <th>Manager Description</th>
          </tr>
        </thead>
      
<!--         
        <tbody>
          @foreach ($reimbursementClaims as $index => $claim)
          <tr>
            <td>{{ $index + 1 }}</td>
            <td>
              <input type="hidden" name="entry_ids[]" value="{{ $claim->id }}" />  
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
              <div class="file-upload">
                <div class="file-select d-flex align-items-center">
                  @if ($claim->upload_bill)
                    @if (Str::endsWith($claim->upload_bill, ['.jpg', '.jpeg', '.png']))
                      <div class="imagePreview" style="background-image: url('{{ asset('storage/' . $claim->upload_bill) }}'); display: block;" data-image-src="{{ asset('storage/' . $claim->upload_bill) }}"></div>
                    @elseif (Str::endsWith($claim->upload_bill, '.pdf'))
                      <div class="imagePreview" style="background-image: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIiBzdHJva2U9IiM4QTMzNjYiIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIiBjbGFzcz0ibHVjaWRlIGx1Y2lkZS1maWxlLXRleHQiPjxwYXRoIGQ9Ik0xNSAydjRhMiAyIDAgMCAwIDIgMmg0Ii8+PHBhdGggZD0iTTE0IDJ2NGg0Ii8+PHBhdGggZD0iTTkgMjBWNGEyIDIgMCAwIDEgMi0yaDdsNCA0djEzYTIgMiAwIDAgMS0yIDJIOGEyIDIgMCAwIDEtMi0yWiIvPjxwYXRoIGQ9Ik05IDloMSIvPjxwYXRoIGQ9Ik05IDEyaDEiLz48cGF0aCBkPSJNOSAxNWgxIi8+PHBhdGggZD0iTTkgMThoMSIvPjwvc3ZnPg=='); display: block;"></div>
                    @endif
                  @else
                    <span class="me-2 my-2"><x-icon name="upload" /></span>
                  @endif
                  <input type="file" name="bills[{{ $index }}]" class="profileimg" accept=".jpg,.jpeg,.png,.pdf">
                </div>
              </div>
              @if ($claim->upload_bill)
                <small class="text-muted">
                  <a href="{{ asset('storage/' . $claim->upload_bill) }}" target="_blank">View Original</a>
                </small>
              @endif
            </td>
            <td><textarea class="form-control" rows="1" name="comments[{{ $index }}]" placeholder="Comment">{{ $claim->description_by_applicant }}</textarea></td>
            <td><textarea class="form-control" rows="1" name="comments[{{ $index }}]" disabled placeholder="Comment">{{ $claim->description_by_manager }}</textarea></td>
          </tr>
          @endforeach
</tbody> -->


<tbody>
  @foreach ($reimbursementClaims as $index => $claim)
  <tr>
    <td>{{ $index + 1 }}</td>
    <td>
      <input type="hidden" name="entry_ids[]" value="{{ $claim->id }}" />
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
      <div class="file-upload d-flex">
        <div class="file-select d-flex align-items-center">
          <div class="image-preview-container me-2 d-flex align-items-center" >
            <div  class="upload-icon-input me-2">
              <x-icon name="upload" />
              <input type="file" name="bills[{{ $index }}]" class="file-input " accept=".jpg,.jpeg,.png,.pdf" data-index="{{ $index }}" >
            </div>
            @if ($claim->upload_bill)
              @if (Str::endsWith($claim->upload_bill, ['.jpg', '.jpeg', '.png']))
                <img src="{{ asset('storage/' . $claim->upload_bill) }}" 
                     class="existing-image img-thumbnail" width="100" height="100" style="display:block;">
                <img src="#" class="new-image-preview img-thumbnail" width="100" height="100" style="display:none;">
              @elseif (Str::endsWith($claim->upload_bill, '.pdf'))
                <div class="pdf-preview d-flex flex-column align-items-center justify-content-center bg-light" style="width:100px;height:100px;">
                  <x-icon name="file-text" class="text-primary" size="48" />
                  <small class="text-muted mt-1">PDF</small>
                </div>
              @endif
            @else
              <div class="no-file-placeholder d-flex align-items-center justify-content-center bg-light" style="width:100px;height:100px;">
                <x-icon name="upload" size="24" class="text-muted" />
              </div>
              <img src="#" class="new-image-preview img-thumbnail" width="100" height="100" style="display:none;">
            @endif
          </div>
        </div>
        <!-- @if ($claim->upload_bill)
          <small class="text-muted d-block mt-2">
            <a href="{{ asset('storage/' . $claim->upload_bill) }}" target="_blank" class="text-decoration-none">
              <x-icon name="external-link" size="14" /> View Original
            </a>
          </small>
        @endif -->
      </div>
    </td>
    <td><textarea class="form-control" rows="1" name="comments[{{ $index }}]" placeholder="Comment">{{ $claim->description_by_applicant }}</textarea></td>
    <td><textarea class="form-control" rows="1" name="comments[{{ $index }}]" disabled placeholder="Comment">{{ $claim->description_by_manager }}</textarea></td>
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
