@extends('user_view/employee_form_layout')
@section('content') 
<link rel="stylesheet" href="{{ asset('errors/error.css') }}">
{{-- @if(session('success'))
<div class="alert custom-alert-success">
    <strong>{{ session('success') }}</strong> 
    <button class="close-btn" onclick="this.parentElement.style.display='none';">&times;</button>
    
</div>
@endif

@if(session('error'))
<div class="alert custom-alert-error">
<strong> {{ session('error') }}</strong>
<button class="close-btn" onclick="this.parentElement.style.display='none';">&times;</button>
</div>
@endif --}}

@if($errors->any())
<div class="alert custom-alert-warning">
<ul>
@foreach($errors->all() as $error)
<li style="color: red;">{{ $error }}</li>

@endforeach
</ul>
</div>
@endif

<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<style>
/* Reduce the width and height of the Dropzone container */
.dropzone {
    width: 100%;  /* Adjust as needed */
    height: 200px; /* Adjust to the desired height */
    border: 2px dashed #ccc; /* Optional: Style the border */
    border-radius: 8px; /* Optional: Rounded corners */
    padding: 20px; /* Optional: Add some padding */
}

/* Customize the inner dropzone content (for example the file preview area) */
.dropzone .dz-preview {
    max-width: 100%; /* Ensure the preview images don't overflow */
}

/* Optional: Increase the size of the file input area */
.dropzone input[type="file"] {
    width: 100%; /* Adjust width */
    height: 100%; /* Adjust height */
    opacity: 0; /* Hide the default file input element */
}
</style>

<div class="tab-content active" id="tab7">
    <p>Please ensure that all documents are clear and, if possible, converted to PDF format. This will improve file compatibility and readability.</p>
    
    <form action="/file-upload" method="POST" enctype="multipart/form-data" id="">
        @csrf
        
        <div class="services-container">
            <!-- Previous Employment Documents -->
            <div class="service-card">
                <div class="service-icon">📑</div>
                <div class="service-title">Previous Employment Documents</div>
                <div class="service-description">Upload past experience certificates, relieving letters, and last 3 months' pay slips.</div>
                <div class="dropzone" id="previous-employment-documents"></div>
            </div>

            <!-- Academic Testimonials (Marks Cards & Certificates) -->
            <div class="service-card">
                <div class="service-icon">🎓</div>
                <div class="service-title">Academic Testimonials (Marks Cards & Certificates)</div>
                <div class="service-description">Upload documents for X Standard, XII Standard, Graduation, Post-Graduation, and other qualifications.</div>
                <div class="dropzone" id="academic-documents"></div>
            </div>

            <!-- PAN Card -->
            <div class="service-card">
                <div class="service-icon">🪪</div>
                <div class="service-title">PAN Card</div>
                <div class="service-description">Upload your PAN card</div>
                <div class="dropzone" id="pan-card"></div>
            </div>

            <!-- Address Proof -->
            <div class="service-card">
                <div class="service-icon">🏠</div>
                <div class="service-title">Address Proof</div>
                <div class="service-description">Upload your address proof (utility bill, rental agreement, etc.).</div>
                <div class="dropzone" id="address-proof"></div>
            </div>

            <!-- Passport Size Photographs (Self) -->
            <div class="service-card">
                <div class="service-icon">🖼️</div>
                <div class="service-title">Passport Size Photographs (Self)</div>
                <div class="service-description">Upload passport size photos of yourself.</div>
                <div class="dropzone" id="passport-size-self"></div>
            </div>

            <!-- Passport Size Photographs (Dependents) -->
            <div class="service-card">
                <div class="service-icon">👪</div>
                <div class="service-title">Passport Size Photographs (Dependents)</div>
                <div class="service-description">Upload 1 passport size photograph of each dependent (Parents, Spouse, Children, Sibling, and Other).</div>
                <div class="dropzone" id="passport-size-dependents"></div>
            </div>

            <!-- Passport Copy -->
            <div class="service-card">
                <div class="service-icon">📷</div>
                <div class="service-title">Passport Copy (if available)</div>
                <div class="service-description">Upload a scanned copy of your passport.</div>
                <div class="dropzone" id="passport-copy"></div>
            </div>

            <!-- Additional ID Proof -->
            <div class="service-card">
                <div class="service-icon">🆔</div>
                <div class="service-title">Additional ID Proof</div>
                <div class="service-description">Upload Additional ID proof (Voter's ID, Driving License, or Passport).</div>
                <div class="dropzone" id="additional-id-proof"></div>
            </div>
        </div>
    </form>
        <div class="button-container">
            <a href="{{ route('user.preemp') }}" style="text-decoration:none;">
                <button type="button" class="previous-btn">
                    <span>&#8249;</span>
                </button>
            </a>
            <form action="{{ route('homePage') }}" method="POST">
                @csrf
            <button type="submit" class="next-btn">Submit</button>
            </form>
        </div>
    
</div>

<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<script>
    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    var myDropZone = new Dropzone('#previous-employment-documents',{
            url: "{{ route('documents.upload') }}",
            paramName: "photo",
            maxFilesize: 10,
            acceptedFiles: ".pdf,.jpg,.jpeg,.png",
            uploadMultiple: true,
            parallelUploads: 4,
            addRemoveLinks: true,
            maxFiles: 10,
            headers: {
                    'X-CSRF-TOKEN': csrfToken // Include CSRF token in the request headers
                     },
            success: function(file,response){
                if(response == true){

                    alert('File Uploaded');

                }else{

                    alert('File Not uploaded');

                }
            }

    });

    // Initialize Dropzone for each section
    var myDropZone = new Dropzone('#academic-documents',{
            url: "{{ route('documents.upload') }}",
            paramName: "photo",
            maxFilesize: 10,
            acceptedFiles: ".pdf,.jpg,.jpeg,.png",
            uploadMultiple: true,
            parallelUploads: 4,
            addRemoveLinks: true,
            maxFiles: 10,
            headers: {
                    'X-CSRF-TOKEN': csrfToken // Include CSRF token in the request headers
                     },
            success: function(file,response){
                if(response == true){

                    alert('File Uploaded');

                }else{

                    alert('File Not uploaded');

                }
            }

    });

    var myDropZone = new Dropzone('#pan-card',{
            url: "{{ route('documents.upload') }}",
            paramName: "photo",
            maxFilesize: 10,
            acceptedFiles: ".pdf,.jpg,.jpeg,.png",
            uploadMultiple: true,
            parallelUploads: 4,
            addRemoveLinks: true,
            maxFiles: 1,
            headers: {
                    'X-CSRF-TOKEN': csrfToken // Include CSRF token in the request headers
                     },
            success: function(file,response){
                if(response == true){

                    alert('File Uploaded');

                }else{

                    alert('File Not uploaded');

                }
            }

    });

    var myDropZone = new Dropzone('#address-proof',{
            url: "{{ route('documents.upload') }}",
            paramName: "photo",
            maxFilesize: 10,
            acceptedFiles: ".pdf,.jpg,.jpeg,.png",
            uploadMultiple: true,
            parallelUploads: 4,
            addRemoveLinks: true,
            maxFiles: 1,
            headers: {
                    'X-CSRF-TOKEN': csrfToken // Include CSRF token in the request headers
                     },
            success: function(file,response){
                if(response == true){

                    alert('File Uploaded');

                }else{

                    alert('File Not uploaded');

                }
            }

    });

    var myDropZone = new Dropzone('#passport-size-self',{
            url: "{{ route('documents.upload') }}",
            paramName: "photo",
            maxFilesize: 10,
            acceptedFiles: ".pdf,.jpg,.jpeg,.png",
            uploadMultiple: true,
            parallelUploads: 4,
            addRemoveLinks: true,
            maxFiles: 1,
            headers: {
                    'X-CSRF-TOKEN': csrfToken // Include CSRF token in the request headers
                     },
            success: function(file,response){
                if(response == true){

                    alert('File Uploaded');

                }else{

                    alert('File Not uploaded');

                }
            }

    });

    var myDropZone = new Dropzone('#passport-size-dependents',{
            url: "{{ route('documents.upload') }}",
            paramName: "photo",
            maxFilesize: 10,
            acceptedFiles: ".pdf,.jpg,.jpeg,.png",
            uploadMultiple: true,
            parallelUploads: 4,
            addRemoveLinks: true,
            maxFiles: 10,
            headers: {
                    'X-CSRF-TOKEN': csrfToken // Include CSRF token in the request headers
                     },
            success: function(file,response){
                if(response == true){

                    alert('File Uploaded');

                }else{

                    alert('File Not uploaded');

                }
            }

    });

    var myDropZone = new Dropzone('#passport-copy',{
            url: "{{ route('documents.upload') }}",
            paramName: "photo",
            maxFilesize: 10,
            acceptedFiles: ".pdf,.jpg,.jpeg,.png",
            uploadMultiple: true,
            parallelUploads: 4,
            addRemoveLinks: true,
            maxFiles: 1,
            headers: {
                    'X-CSRF-TOKEN': csrfToken // Include CSRF token in the request headers
                     },
            success: function(file,response){
                if(response == true){

                    alert('File Uploaded');

                }else{

                    alert('File Not uploaded');

                }
            }

    });

    var myDropZone = new Dropzone('#additional-id-proof',{
            url: "{{ route('documents.upload') }}",
            paramName: "photo",
            maxFilesize: 10,
            acceptedFiles: ".pdf,.jpg,.jpeg,.png",
            uploadMultiple: true,
            parallelUploads: 4,
            addRemoveLinks: true,
            maxFiles: 3,
            headers: {
                    'X-CSRF-TOKEN': csrfToken // Include CSRF token in the request headers
                     },
            success: function(file,response){
                if(response == true){

                    alert('File Uploaded');

                }else{

                    alert('File Not uploaded');

                }
            }

    });
</script>

@endsection
