@extends('user_view/employee_form_layout')
@section('content') 

@if($errors->any())
<ul>
    @foreach($errors->all() as $error)
        <li style="color: red;">{{ $error }}</li>
    @endforeach
</ul>
@endif

<div class="w3-container">
    @if(session('success'))
    <div class="w3-panel w3-green">
        {{ session('success') }} 
    </div>
    @endif
    
    @if(session('error'))
    <div class="w3-panel w3-red">
        {{ session('error') }} 
    </div>
    @endif
</div>



<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<style>
/* Increase the width and height of the Dropzone container */
.dropzone {
    width: 100%;  /* Adjust as needed */
    height: 300px; /* Adjust to the desired height */
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
        
        <!-- Previous Employment Documents -->
        <div class="service-card">
            <div class="service-icon">📑</div>
            <div class="service-title">Previous Employment Documents</div>
            <div class="service-description">Upload past experience certificates, relieving letters, and last 3 months' pay slips.</div>
            <div class="dropzone" id="previous-employment-documents"></div>
            {{-- <input type="file" name="file" /> --}}
        </div>
    </form>

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

        <div class="button-container">
            <a href="{{ route('user.preemp') }}" style="text-decoration:none;">
                <button type="button" class="previous-btn">
                    <span>&#8249;</span>
                </button>
            </a>
            <button type="submit" class="next-btn">Submit</button>
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

    // $('document').on('change',function(){

    //     myDropZone.processQueue();

    // });

    // // Initialize Dropzone for each section
    // Dropzone.options.previousEmploymentDocuments = {
    //     url: "{{ route('documents.upload') }}",
    //     paramName: "file",
    //     maxFilesize: 10,
    //     acceptedFiles: ".pdf,.jpg,.jpeg,.png",
    //     uploadMultiple: true,
    //     parallelUploads: 4,
    //     addRemoveLinks: true,
    //     maxFiles: 3,
    //     maxFilesMessage: "You can only upload 3 files.",
    //     init: function() {
    //         this.on("sending", function(file, xhr, formData) {
    //             formData.append("_token", csrfToken); // Add CSRF token
    //             formData.append("category", "previous_employment_documents"); // Add category to each file
    //             console.log('dfssd');
    //         });
    //     }
    // };

    // Dropzone.options.academicDocuments = {
    //     url: "{{ route('documents.upload') }}",
    //     paramName: "file",
    //     maxFilesize: 2,
    //     acceptedFiles: ".pdf,.jpg,.jpeg,.png",
    //     addRemoveLinks: true,
    //     init: function() {
    //         this.on("sending", function(file, xhr, formData) {
    //             formData.append("_token", csrfToken);
    //             formData.append("category", "academic_documents"); // Add category to each file
    //         });
    //     }
    // };

    // Dropzone.options.panCard = {
    //     url: "{{ route('documents.upload') }}",
    //     paramName: "file",
    //     maxFilesize: 2,
    //     acceptedFiles: ".pdf,.jpg,.jpeg,.png",
    //     addRemoveLinks: true,
    //     init: function() {
    //         this.on("sending", function(file, xhr, formData) {
    //             formData.append("_token", csrfToken);
    //             formData.append("category", "pan_card"); // Add category to each file
                
    //         });
    //     }
    // };

    // Dropzone.options.addressProof = {
    //     url: "{{ route('documents.upload') }}",
    //     paramName: "file",
    //     maxFilesize: 2,
    //     acceptedFiles: ".pdf,.jpg,.jpeg,.png",
    //     addRemoveLinks: true,
    //     init: function() {
    //         this.on("sending", function(file, xhr, formData) {
    //             formData.append("_token", csrfToken);
    //             formData.append("category", "address_proof"); // Add category to each file
    //         });
    //     }
    // };

    // Dropzone.options.passportSizeSelf = {
    //     url: "{{ route('documents.upload') }}",
    //     paramName: "file",
    //     maxFilesize: 2,
    //     acceptedFiles: ".jpg,.jpeg,.png",
    //     addRemoveLinks: true,
    //     init: function() {
    //         this.on("sending", function(file, xhr, formData) {
    //             formData.append("_token", csrfToken);
    //             formData.append("category", "passport_size_self"); // Add category to each file
                
    //         });
    //     }
    // };

    // Dropzone.options.passportSizeDependents = {
    //     url: "{{ route('documents.upload') }}",
    //     paramName: "file",
    //     maxFilesize: 2,
    //     acceptedFiles: ".jpg,.jpeg,.png",
    //     addRemoveLinks: true,
    //     init: function() {
    //         this.on("sending", function(file, xhr, formData) {
    //             formData.append("_token", csrfToken);
    //             formData.append("category", "passport_size_dependents"); // Add category to each file
    //         });
    //     }
    // };

    // Dropzone.options.passportCopy = {
    //     url: "{{ route('documents.upload') }}",
    //     paramName: "file",
    //     maxFilesize: 2,
    //     acceptedFiles: ".pdf,.jpg,.jpeg,.png",
    //     addRemoveLinks: true,
    //     init: function() {
    //         this.on("sending", function(file, xhr, formData) {
    //             formData.append("_token", csrfToken);
    //             formData.append("category", "passport_copy"); // Add category to each file
    //         });
    //     }
    // };

    // Dropzone.options.additionalIdProof = {
    //     url: "{{ route('documents.upload') }}",
    //     paramName: "file",
    //     maxFilesize: 2,
    //     acceptedFiles: ".pdf,.jpg,.jpeg,.png",
    //     addRemoveLinks: true,
    //     init: function() {
    //         this.on("sending", function(file, xhr, formData) {
    //             formData.append("_token", csrfToken);
    //             formData.append("category", "additional_id_proof"); // Add category to each file
    //         });
    //     }
    // };
</script>

@endsection
