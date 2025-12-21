   
<!DOCTYPE html>
<html lang="en">
<head>

<!-- Custom admin styles -->
 <link rel="stylesheet" href="{{ asset('Offical_admin/css/official_admin.css') }}">   
</head>

<body>

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

                        <!-- on input is used to Correct the validations at typing time -->
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
                        <label for="client_name">Client Name</label>
                    </div>

                    <!-- Company Name  -->
                    <div class="form-group">
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            placeholder=" "
                            maxlength="50" 
                            required
                        >
                        <label for="name">Company Name</label>
                    </div>

                    <!-- Contact Information -->
                    <div class="form-group">
                        <input 
                            type="text" 
                            id="contact_person" 
                            name="contact_person" 
                            placeholder=" "
                            required
                        >
                        <label for="contact_person">Contact Person</label>
                    </div>


                    <div class="form-group">
                        <!-- Email: Only allows email addresses. 
                         setCustomValidity is a built-in JavaScript method for HTML5 form validation that allows you to set a custom validation message -->
                         <input 
                            type="email"
                            id="email"
                            name="email"
                            placeholder=" "
                            autocomplete="username"
                            required
                            pattern="[a-zA-Z0-9._%+-]+@gmail\.com"
                            title="Please enter a valid Gmail address (example@gmail.com)"
                        >
                        <label for="email">Email</label>
                    </div>


                    
                    <div class="form-group">
                        <!-- Password: Only allows password -->
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control password-field"
                            placeholder=" "
                            minlength="8"
                            required
                            aria-describedby="passwordHelp"
                            autocomplete="new-password"
                        >
                        <label for="password">Password</label>
                        <small id="passwordHelp" class="error-text"></small>
                    </div>


                    <!-- Mobile Number: Only allows valid 10-digit mobile numbers. -->
                    <div class="form-group">
                        <input 
                            type="tel" 
                            id="mobile" 
                            name="mobile" 
                            placeholder=" " 
                            maxlength="10" 
                            title="Please enter a valid 10-digit mobile number" 
                            pattern="[0-9]{10}"
                            inputmode="numeric"
                            onkeypress="return (event.charCode >= 48 && event.charCode <= 57)"
                            oninput="this.value = this.value.replace(/\D/g, '')"
                            required
                        >
                        <label for="mobile">Phone</label>
                    </div>
                    
                    <!-- Address Fields -->
                    <div class="form-group">
                        <input
                            type="text"
                            id="building_no"
                            name="building_no"
                            placeholder=" "
                            maxlength="50"
                            required
                        >
                        <label for="building_no">Building/House No.</label>
                    </div>

                    <!-- Validation for premises name -->
                    <div class="form-group">
                        <input
                            type="text"
                            id="premises_name"
                            name="premises_name"
                            placeholder=" "
                            maxlength="100"
                        >
                        <label for="premises_name">Premises Name</label>
                    </div>

                    <!-- Validation for landmark -->
                    <div class="form-group">
                        <input
                            type="text"
                            id="landmark"
                            name="landmark"
                            placeholder=" "
                            maxlength="150"
                        >
                        <label for="landmark">Landmark</label>
                    </div>

                    <!-- Validation for road/street -->
                    <div class="form-group">
                        <input
                            type="text"
                            id="road_street"
                            name="road_street"
                            placeholder=" "
                            maxlength="150"
                            required
                        >
                        <label for="road_street">Road/Street</label>
                    </div>

                    <!-- Validation for pincode -->
                    <div class="form-group">
                        <input
                            type="text"
                            id="pincode"
                            name="pincode"
                            placeholder=" "
                            maxlength="6"
                            pattern="[0-9]{6}"
                            inputmode="numeric"
                            title="Enter valid 6 digit pincode"
                            onkeypress="return (event.charCode >= 48 && event.charCode <= 57)"
                            oninput="this.value = this.value.replace(/\D/g, '')"
                            required
                        >
                        <label for="pincode">Pincode</label>
                    </div>

                    <!-- Validation for district -->
                    <div class="form-group">
                        <input
                            type="text"
                            id="district"
                            name="district"
                            placeholder=" "
                            maxlength="50"
                            required
                        >
                        <label for="district">District</label>
                    </div>

                    <!-- Validation for state -->
                    <div class="form-group">
                        <input
                            type="text"
                            id="state"
                            name="state"
                            placeholder=" "
                            maxlength="50"
                            required
                        >
                        <label for="state">State</label>
                    </div>

                    <!-- Validation for country -->
                    <div class="form-group">
                        <input
                            type="text"
                            id="country"
                            name="country"
                            value="India"
                            readonly
                            placeholder=" "
                        >
                    </div>

                    <!-- Business Details -->
                    <div class="form-group">
                        <select id="industry_type" name="industry_type" required>
                            <option value=""> </option>
                            <option value="it">Information Technology</option>
                            <option value="manufacturing">Manufacturing</option>
                            <option value="healthcare">Healthcare</option>
                            <option value="finance">Finance</option>
                            <option value="retail">Retail</option>
                            <option value="other">Other</option>
                        </select>
                        <label for="industry_type">Industry Type</label>
                    </div>
                    
                    

                    <!-- Subscription Plans get from the subscription plan module where we cretae a subscritption plan -->
                    <div class="form-group">
                         <select id="software_package_plan" name="software_package_plan" required>
                            <option value="" disabled selected></option>

                            @foreach($subscriptionPlans as $plan)
                                <option value="{{ $plan->id }}">
                                    {{ $plan->plan_name }}
                                </option>
                            @endforeach
                        </select>
                        <label for="software_package_plan">Subscription Plan</label>
                    </div>

                    

                    <!-- Document Information -->
                   <div class="form-group">
                    <input
                        type="text"
                        id="GST_number"
                        name="GST_number"
                        placeholder=" "
                        maxlength="15"
                        required
                        pattern="[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z][1-9A-Z]Z[0-9A-Z]"
                        title="Enter a valid GSTIN (e.g., 22AAAAA0000A1Z5)"
                        
                    >
                    <label for="GST_number">GST Number</label>
                </div>


                    <!-- Validation for PAN -->
                    <div class="form-group">
                        <input 
                            type="text"
                            id="PAN"
                            name="PAN"
                            placeholder=" "
                            maxlength="10"
                            pattern="[A-Z]{5}[0-9]{4}[A-Z]{1}"
                            title="Enter a valid PAN (e.g., ABCDE1234F)"
                        >
                        <label for="PAN">PAN Number</label>
                    </div>

                    <!-- Validation for TAN -->
                    <!-- Validation for TAN -->
                    <div class="form-group">
                        <input
                            type="text"
                            id="TAN"
                            name="TAN"
                            placeholder=" "
                            maxlength="10"
                            pattern="[A-Z]{4}[0-9]{5}[A-Z]{1}"
                            title="Enter a valid TAN (e.g., ABCD12345E)"
                            required
                        >
                        <label for="TAN">TAN Number</label>
                    </div>


                    <!-- expire date -->
                    <div class="form-group">
                        <input 
                            type="date" 
                            id="expire_date"
                            name="expire_date"
                            placeholder=" "
                            required
                        >
                        <label for="expire_date">Expiry Date</label>
                    </div>


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

</body>
</html>
