   
<!DOCTYPE html>
<html lang="en">
<head>

<!-- Custom admin styles -->
 <link rel="stylesheet" href="{{ asset('Offical_admin/css/official_admin.css') }}">   

 <!-- added sweetalert2 script for alert messages -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                         <!-- pattern <span style="color: red;">*</span> is used to validate the input fileds are required -->
                        <input 
                            type="text"
                            id="client_name" 
                            name="client_name" 
                            placeholder="" 
                            maxlength="225" 
                            pattern="[A-Za-z\s]+"
                            title="Please enter only letters and spaces (no numbers or special characters)"
                            oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')"
                            required
                        >
                        <label for="client_name">
                            Client Name <span style="color: red;">*</span>
                        </label>
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
                        <label for="name">Company Name
                            <span style="color: red;">*</span>
                        </label>
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
                        <label for="contact_person">Contact Person
                            <span style="color: red;">*</span>
                    </label>
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
                        <label for="email">Email
                            <span style="color: red;">*</span>
                        </label>
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
                        <label for="password">Password
                            <span style="color: red;">*</span>
                        </label>
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
                        <label for="mobile">Phone
                            <span style="color: red;">*</span>
                        </label>
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
                        <label for="building_no">Building/House No.
                            <span style="color: red;">*</span>
                        </label>
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
                        <label for="premises_name">Premises Name
                            <span style="color: red;">*</span>
                        </label>
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
                        <label for="landmark">Landmark
                            <span style="color: red;">*</span>
                        </label>
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
                        <label for="road_street">Road/Street
                            <span style="color: red;">*</span>
                        </label>
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
                        <label for="pincode">Pincode
                            <span style="color: red;">*</span>
                        </label>
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
                        <label for="district">District
                                <span style="color: red;">*</span>
                        </label>
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
                        <label for="state">State
                            <span style="color: red;">*</span>
                        </label>
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
                     <!-- added the default value to the select option -->
                    <div class="form-group">
                        <select id="industry_type" name="industry_type" required>
                            <option value="">Select Industry Type</option>
                            <option value="it">Information Technology</option>
                            <option value="manufacturing">Manufacturing</option>
                            <option value="healthcare">Healthcare</option>
                            <option value="finance">Finance</option>
                            <option value="retail">Retail</option>
                            <option value="other">Other</option>
                        </select>
                        <label for="industry_type">Industry Type
                            <span style="color: red;">*</span>
                        </label>
                    </div>
                    
                    

                    <!-- Subscription Plans get from the subscription plan module where we cretae a subscritption plan -->
                    <!-- added the default value to the select option -->
                    <div class="form-group">
                         <select id="software_package_plan" name="software_package_plan" required>
                            <option value="" disabled selected>select Subscription Plan</option>

                            @foreach($subscriptionPlans as $plan)
                                <option value="{{ $plan->id }}">
                                    {{ $plan->plan_name }}
                                </option>
                            @endforeach
                        </select>
                        <label for="software_package_plan">Subscription Plan
                            <span style="color: red;">*</span>
                        </label>
                    </div>

                    

                    <!-- Document Information -->
                     <!-- updated the GST input field to automatically convert lowercase letters to uppercase as the user types -->
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
                        oninput="this.value = this.value.toUpperCase()"
                        style="text-transform: uppercase"
                        
                    >
                    <label for="GST_number">GST Number
                        <span style="color: red;">*</span>
                    </label>
                </div>


                    <!-- Validation for PAN -->
                     <!-- updated the PAN input field to automatically convert lowercase letters to uppercase as the user types -->
                    <div class="form-group">
                        <input 
                            type="text"
                            id="PAN"
                            name="PAN"
                            placeholder=" "
                            maxlength="10"
                            required
                            pattern="[A-Z]{5}[0-9]{4}[A-Z]{1}"
                            title="Enter a valid PAN (e.g., ABCDE1234F)"
                            oninput="this.value = this.value.toUpperCase()"
                            style="text-transform: uppercase"
                        >
                        <label for="PAN">PAN Number
                            <span style="color: red;">*</span>
                        </label>
                    </div>

                    <!-- Validation for TAN -->
                    <!-- Validation for TAN -->
                     <!-- updated the TAN input field to automatically convert lowercase letters to uppercase as the user types -->
                    <div class="form-group">
                        <input
                            type="text"
                            id="TAN"
                            name="TAN"
                            placeholder=" "
                            maxlength="10"
                            pattern="[A-Z]{4}[0-9]{5}[A-Z]{1}"
                            title="Enter a valid TAN (e.g., ABCD12345E)"
                            oninput="this.value = this.value.toUpperCase()"
                            style="text-transform: uppercase"
                            required
                        >
                        <label for="TAN">TAN Number
                            <span style="color: red;">*</span>
                        </label>
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
                        <label for="expire_date">Expiry Date
                            <span style="color: red;">*</span>
                        </label>
                    </div>


                    <!-- certificate uploaded files -->
                    <div class="certificate-files">
                        <div class="form-group">
                            <label for="GST_registration_certificate" class="file-upload-label">GST Certificate <span style="color: red;">*</span></label>
                            <input type="file" id="GST_registration_certificate" name="GST_registration_certificate" class="file-upload-input">
                        </div>
                        <div class="form-group">
                            <label for="MSME_udyam_certificate" class="file-upload-label">MSME Certificate <span style="color: red;">*</span></label>
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
<!-- wrote a script to fetch the district and state based on the pincode -->
<script>
document.addEventListener('DOMContentLoaded', function () {

    // Get references to pincode, district, and state input fields
    const pincodeInput = document.getElementById('pincode');
    const districtInput = document.getElementById('district');
    const stateInput = document.getElementById('state');

    async function fetchAddressByPincode(pincode) {
        try {
             // Call the India Post API with the entered pincode
            const response = await fetch(`https://api.postalpincode.in/pincode/${pincode}`);

             // Convert API response to JSON format
            const data = await response.json();

            if (
                // Check if API response is successful and contains PostOffice data
                data[0].Status === "Success" &&
                data[0].PostOffice &&
                data[0].PostOffice.length > 0
            ) {
                 // Automatically fill district and state fields
                districtInput.value = data[0].PostOffice[0].District;
                stateInput.value = data[0].PostOffice[0].State;
            } else {
                 // Clear fields if pincode is invalid
                districtInput.value = "";
                stateInput.value = "";
                // added the sweetalert2 script to show the alert message
                Swal.fire({
                    title: 'Invalid Pincode',
                    text: 'Please enter a valid 6-digit pincode.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'Cancel'
                })
            }
        } catch (error) {
            console.error("Pincode API Error:", error);
            alert("Unable to fetch address. Please try again.");
        }
    }

    pincodeInput.addEventListener('input', function () {
        const pincode = this.value;

        // Fetch only when exactly 6 digits are entered
        if (pincode.length === 6) {
            fetchAddressByPincode(pincode);
        } else {
            districtInput.value = "";
            stateInput.value = "";
        }
    });

});
</script>

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

    // Set minimum date for expiry date field
    function setDefaultDates() {
        const today = new Date();
        const expireDateInput = document.getElementById('expire_date');
        if (expireDateInput) {
            // Set minimum date to today
            expireDateInput.min = today.toISOString().split('T')[0];
            // No default value set, field will be empty
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
