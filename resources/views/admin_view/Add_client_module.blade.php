   
<!-- Custom admin styles -->
 <link rel="stylesheet" href="{{ asset('Offical_admin/css/official_admin.css') }}">   

<!-- =========================
         ADD CLIENT MODAL
         ========================= -->
         <!-- add client model div start -->
    <div id="addClientModal" class="modal">

        <!-- Modal content div start -->
        <div class="modal-content">
             <!-- Modal header div start -->
            <div class="modal-header">
                <h2>Add New Client</h2>
                <span class="close-btn">&times;</span>
            </div>
            <!-- Client creation form -->
            <form id="addClientForm"
                class="compact-form"
                method="POST"
                action="{{ route('organisation.store') }}"
                enctype="multipart/form-data">
            
                @csrf
                <div class="form-grid">
                    <!-- Basic Information -->
                    <div class="form-group">
                        <!-- Client Name: Only allows letters and spaces.  -->
                        <input 
                            type="text"
                            id="client_name" 
                            name="client_name" 
                            placeholder="Client Name *" 
                            maxlength="225" 
                            pattern="[A-Za-z\s]+"
                            title="Please enter only letters and spaces (no numbers or special characters)"
                            oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')"
                            required
                        >
                    </div>
                    <!-- Company Name: Only allows letters and spaces.  -->

                    <div class="form-group">
                        <input type="text" id="name" name="name" placeholder="Company Name *" 
                        maxlength="50" 
                            pattern="[A-Za-z\s]+"
                            title="Please enter only letters and spaces (no numbers or special characters)"
                            oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')"
                            required>
                    </div>

                    <!-- Contact Information -->
                    <div class="form-group">
                        <input type="text" id="contact_person" name="contact_person" placeholder="Contact Person *" required>
                    </div>
                    <div class="form-group">

                        <!-- Email: Only allows valid email addresses. 
                         setCustomValidity is a built-in JavaScript method for HTML5 form validation that allows you to set a custom validation message -->
                        <input type="email" id="email" name="email" placeholder="Email *" 
                        pattern="[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$"
                        title="Please enter a valid email address (e.g., example@domain.com)"
                        oninput="this.setCustomValidity('')"
                        oninvalid="this.setCustomValidity('Please enter a valid email address (e.g., example@domain.com)')"
                    
                        required>
                    </div>

                    <div class="form-group">
                        <input type="text" id="password" name="password" placeholder="passsword ">
                    </div>


                    <!-- Mobile Number: Only allows valid 10-digit mobile numbers. -->
                    <div class="form-group">
                        <input 
                            type="tel" 
                            id="mobile" 
                            name="mobile" 
                            placeholder="Phone *" 
                            maxlength="10" 
                            title="Please enter a valid 10-digit mobile number" 
                            pattern="[0-9]{10}"
                            inputmode="numeric"
                            onkeypress="return (event.charCode >= 48 && event.charCode <= 57)"
                            oninput="this.value = this.value.replace(/\D/g, '')"
                            required
                        >
                    </div>
                    
                    <!-- Address Fields -->
                    <div class="form-group">
                        <input
                            type="text"
                            id="building_no"
                            name="building_no"
                            placeholder="Building/House No. *"
                            maxlength="50"
                            required
                        >
                    </div>

                    <!-- Validation for premises name -->
                    <div class="form-group">
                        <input
                            type="text"
                            id="premises_name"
                            name="premises_name"
                            placeholder="Premises Name"
                            maxlength="100"
                        >
                    </div>

                    <!-- Validation for landmark -->
                    <div class="form-group">
                        <input
                            type="text"
                            id="landmark"
                            name="landmark"
                            placeholder="Landmark"
                            maxlength="150"
                            pattern="[A-Za-z\s\-,.()]+"
                            title="Only letters, spaces, and basic punctuation (-,.()) allowed"
                            oninput="this.value = this.value.replace(/[^A-Za-z\s\-,.()]/g, '')"
    
                        >
                    </div>

                    <!-- Validation for road/street -->
                    <div class="form-group">
                        <input
                            type="text"
                            id="road_street"
                            name="road_street"
                            placeholder="Road/Street *"
                            maxlength="150"
                            required
                        >
                    </div>

                    <!-- Validation for pincode -->
                    <div class="form-group">
                        <input
                            type="text"
                            id="pincode"
                            name="pincode"
                            placeholder="Pincode *"
                            maxlength="6"
                            pattern="[0-9]{6}"
                            inputmode="numeric"
                            title="Enter valid 6 digit pincode"
                            onkeypress="return (event.charCode >= 48 && event.charCode <= 57)"
                            oninput="this.value = this.value.replace(/\D/g, '')"
                            required
                        >
                    </div>

                    <!-- Validation for district -->
                    <div class="form-group">
                        <input
                            type="text"
                            id="district"
                            name="district"
                            placeholder="District *"
                            maxlength="50"
                            
                            required
                        >
                    </div>

                    <!-- Validation for state -->
                    <div class="form-group">
                        <input
                            type="text"
                            id="state"
                            name="state"
                            placeholder="State *"
                            maxlength="50"
                            pattern="[A-Za-z\s\]+"
                            title="Only letters, spaces, and basic punctuation (-,.()) allowed"
                            oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')"
                            required
                        >
                    </div>

                    <!-- Validation for country -->
                    <div class="form-group">
                        <input
                            type="text"
                            id="country"
                            name="country"
                            value="India"
                            readonly
                        >
                    </div>

                    <!-- Validation for industry type -->
                    <!-- Business Details -->
                    <div class="form-group">
                        <select id="industry_type" name="industry_type" required>
                            <option value="">Select Industry *</option>
                            <option value="it">Information Technology</option>
                            <option value="manufacturing">Manufacturing</option>
                            <option value="healthcare">Healthcare</option>
                            <option value="finance">Finance</option>
                            <option value="retail">Retail</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="number" id="number_of_emplooyees" name="number_of_emplooyees" placeholder="Number of Employees *" required>
                    </div>

                    <!-- software Package Information -->
                    <div class="form-group">
                        <select id="software_package_plan" name="software_package_plan" required>
                            <option value="">Select Plan *</option>
                            <option value="basic">Basic</option>
                            <option value="standard">Standard</option>
                            <option value="enterprise">Enterprise</option>
                        </select>
                    </div>

                    <!-- storage limit -->
                    <div class="form-group">
                        <input type="number" id="storage_limit" name="storage_limit" placeholder="Storage (GB) *" maxlength="4" required>
                    </div>

                    <!-- number of user allowed -->
                    <div class="form-group">
                        <input type="number" id="number_of_user_allowed" name="number_of_user_allowed" placeholder="Max Users *" required>
                    </div>

                    <!-- organisation status -->
                    <div class="form-group">
                        <select id="organisation_status" name="organisation_status" required>
                            <option value="">Select Status *</option>
                            <option value="Active">active</option>
                            <option value="Incative">incative</option>
                        </select>
                    </div>

                    <!-- Document Information -->
                    <div class="form-group">
                         <input  
                            type="text" 
                            id="GST_number" 
                            name="GST_number" 
                            placeholder="GSTIN (e.g., 22AAAAA0000A1Z5)" 
                           maxlength="15"
                      >
                    </div>

                    <!-- Validation for PAN -->
                    <div class="form-group">
                    <input 
                        type="text" 
                        id="PAN" 
                        name="PAN" 
                        placeholder="PAN (e.g., AAAAA9999A)" 
                        maxlength="10"
                        required
                    >
                </div>

                    <!-- Validation for TAN -->
                    <div class="form-group">
                        <input 
                            type="text" 
                            id="TAN" 
                            name="TAN" 
                            placeholder="TAN (e.g., bbbbb9999A)" 
                            maxlength="10"
                            required
                        >
                    </div>

                    <!-- expire date -->
                    <div class="form-group">
                         <input 
                        type="date" 
                        id="expire_date" 
                        name="expire_date" 
                        min="" 
                        oninput="validateExpiryDate(this)"
                        required
                    > </div>

                    <!-- certificate uploaded files -->
                    <div class="certificate-files">
                        <div class="form-group">
                            <label for="GST_registration_certificate" class="file-upload-label">GST Certificate</label>
                            <input type="file" id="GST_registration_certificate" name="GST_registration_certificate" class="file-upload-input">
                        </div>
                        <div class="form-group">
                            <label for="MSME_udyam_certificate" class="file-upload-label">MSME Certificate</label>
                            <input type="file" id="MSME_udyam_certificate" name="MSME_udyam_certificate" class="file-upload-input">
                        </div>
                    </div>
                </div>
                <!-- Form actions -->
                <div class="form-actions">
                    <button type="button" id="cancelBtn" class="btn btn-secondary">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </form>
        </div> <!-- Modal content div end -->
    </div> <!-- add client model div end -->

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get the modal and buttons
    const modal = document.getElementById('addClientModal');
    const btn = document.getElementById('addClientBtn');
    const closeBtn = modal ? modal.querySelector('.close-btn') : null;
    const form = document.getElementById('addClientForm');
    const cancelBtn = document.getElementById('cancelBtn');

    /* -----------------------------------------
    ADD CLIENT MODAL – OPEN / CLOSE
    -----------------------------------------
    These functions simply show or hide
    the "Add Client" popup.
    */
    function showModal() {
        if (modal) {
            modal.style.display = 'flex';
            modal.classList.add('show');
            document.body.style.overflow = 'hidden'; // Prevent scrolling when modal is open
            setDefaultDates();
        }
    }

    // Function to hide modal
    function hideModal() {
        if (modal) {
            modal.style.display = 'none';
            modal.classList.remove('show');
            document.body.style.overflow = ''; // Re-enable scrolling
        }
    }

    // Set default dates for validity 
    function setDefaultDates() {
        const today = new Date();
        const nextYear = new Date();
        nextYear.setFullYear(today.getFullYear() + 1);
        
        const expireDateInput = document.getElementById('expire_date');
        if (expireDateInput) {
            expireDateInput.min = today.toISOString().split('T')[0];
            expireDateInput.value = nextYear.toISOString().split('T')[0];
        }
    }

    // Add event listeners
    if (btn) {
        btn.addEventListener('click', showModal);
    }

    if (closeBtn) {
        closeBtn.addEventListener('click', hideModal);
    }

    if (cancelBtn) {
        cancelBtn.addEventListener('click', hideModal);
    }

    // Close when clicking outside the modal content
    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            hideModal();
        }
    });

    // Close with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal && modal.classList.contains('show')) {
            hideModal();
        }
    });

    // Handle form submission
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Show success modal or handle form submission
            const successModal = document.getElementById('successModal');
            if (successModal) {
                successModal.style.display = 'flex';
                successModal.classList.add('show');
            }
            
            // Submit form after delay
            setTimeout(() => {
                form.submit();
            }, 1000);
        });
    }
});
</script>
@endpush
