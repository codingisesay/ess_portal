@extends('user_view/employee_form_layout')  <!-- Extending the layout file -->
@section('content') 

<div class="tab-content active" id="tab7">
    <!-- <h3>Document Upload</h3> -->
    <p>Please ensure that all documents are clear and, if possible, converted to PDF format. This will
        improve
        file compatibility and readability.</p>
    <form action="submit_step.php" method="POST" enctype="multipart/form-data">
        
        <input type="hidden" name="form_step10" value="document_step">
        <!-- Scanned Copies of Previous Employment -->
        <div class="services-container">
            <div class="service-card">
                <div class="service-icon">📑</div>
                <div class="service-title">Previous Employment Documents</div>
                <div class="service-description">Upload past experience certificates, relieving letters, and
                    last 3 months' pay slips.</div>
                <input type="file" name="employmentDocuments[]" accept=".pdf, .jpg, .jpeg, .png" multiple
                    onchange="handleFileUpload(this)">
                <div class="file-preview1"></div>
            </div>

            <div class="service-card">
                <div class="service-icon">🎓</div>
                <div class="service-title">Academic Testimonials (Marks Cards & Certificates)</div>
                <div class="service-description">Upload documents for X Standard, XII Standard, Graduation,
                    Post-Graduation, and other qualifications.</div>
                <input type="file" name="academicDocuments[]" accept=".pdf, .jpg, .jpeg, .png" multiple
                    onchange="handleFileUpload(this)">
                <div class="file-preview2"></div>
            </div>

            <div class="service-card">
                <div class="service-icon">🪪</div>
                <div class="service-title">PAN Card</div>
                <div class="service-description">Upload your PAN card</div>
                <input type="file" name="panCard" accept=".pdf, .jpg, .jpeg, .png"
                    onchange="handleFileUpload(this)">
                <div class="file-preview3"></div>
            </div>

            <div class="service-card">
                <div class="service-icon">🏠</div>
                <div class="service-title">Address Proof</div>
                <div class="service-description">Upload your address proof (utility bill, rental agreement,
                    etc.).</div>
                <input type="file" name="addressProof[]" accept=".pdf, .jpg, .jpeg,
         .png" multiple onchange="handleFileUpload(this)">
                <div class="file-preview4"></div>
            </div>

            <div class="service-card">
                <div class="service-icon">🖼️</div>
                <div class="service-title">Passport Size Photographs (Self)</div>
                <div class="service-description">Upload passport size photos of yourself.</div>
                <input type="file" name="selfPhotos[]" accept=".jpg, .jpeg, .png" multiple
                    onchange="handleFileUpload(this)">
                <div class="file-preview5"></div>
            </div>

            <div class="service-card">
                <div class="service-icon">👪</div>
                <div class="service-title">Passport Size Photographs (Dependents)</div>
                <div class="service-description">Upload 1 passport size photograph of each dependent
                    (Parents,
                    Spouse,Children,Sibling and Other).</div>
                <input type="file" name="dependentPhotos[]" accept=".jpg, .jpeg, .png" multiple
                    onchange="handleFileUpload(this)">
                <div class="file-preview6"></div>
            </div>

            <div class="service-card">
                <div class="service-icon">📷</div>
                <div class="service-title">Passport Copy (if available)</div>
                <div class="service-description">Upload a scanned copy of your passport.</div>
                <input type="file" name="passportCopy" accept=".pdf, .jpg, .jpeg, .png"
                    onchange="handleFileUpload(this)">
                <div class="file-preview7"></div>
            </div>

            <div class="service-card">
                <div class="service-icon">🆔</div>
                <div class="service-title">Additional ID Proof</div>
                <div class="service-description">Upload Additional ID proof (Voter's ID, Driving License, or
                    Passport).</div>
                <input type="file" name="additionalIdProof[]" accept=".jpg, .jpeg, .png" multiple
                    onchange="handleFileUpload(this)">
                <div class="file-preview8"></div>
            </div>
        </div>

        <div class="button-container">
            <button class="previous-btn">
                <span>&#8249;</span>
            </button>
            <button type="submit" class="next-btn">Submit</button>
        </div>
    </form>
</div>
</div>
<script src="onboarding_form.js"></script>

@endsection