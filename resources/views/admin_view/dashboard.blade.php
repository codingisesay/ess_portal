
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <!-- Page title -->
    <title>Admin Dashboard</title>
    <!-- Custom admin styles -->
    <link rel="stylesheet" href="{{ asset('Offical_admin/css/official_admin.css') }}">
    <!-- Font Awesome icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
                            pattern="^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$"
                            title="Enter a valid 15-digit GSTIN (e.g., 22AAAAA0000A1Z5)"
                            oninput="this.value = this.value.replace(/[^A-Z0-9]/g, '').toUpperCase()"
                            onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90)"
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
                        pattern="[A-Z]{5}[0-9]{4}[A-Z]{1}"
                        title="Enter a valid 10-digit PAN (e.g., AAAAA9999A)"
                        oninput="this.value = this.value.replace(/[^A-Z0-9]/g, '').toUpperCase()"
                        onkeypress="return (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 48 && event.charCode <= 57)"
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
                            pattern="[A-Z]{5}[0-9]{4}[A-Z]{1}"
                            title="Enter a valid 10-digit PAN (e.g., bbbbb9999A)"
                            oninput="this.value = this.value.replace(/[^A-Z0-9]/g, '').toUpperCase()"
                            onkeypress="return (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 48 && event.charCode <= 57)"
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

     
    <!-- =========================
     SEND NOTIFICATION MODAL
     ========================= -->

    <!-- div notification modal start -->
    <div id="notificationModal" class="modal">

    <!-- div Modal content  -->
        <div class="modal-content">

          <!-- div Modal header  -->
            <div class="modal-header">
                <h2>Send Notification</h2>
                <!-- Modal close button -->
                <span class="close-btn" id="closeNotification">&times;</span>
            </div>
            <!-- div /modal-header -->

            <!-- Notification form -->
            <form id="notificationForm">
                <div class="form-group">

                <!-- broadcast to all means send to all-->
                    <label for="broadcastTo">Broadcast All</label>
                    <select id="broadcastTo" name="broadcastTo">
                        <option value="all">All Users</option>
                        <option value="active">Active Users</option>
                        <option value="inactive">Inactive Users</option>
                    </select>
                </div>

                 <!-- Notification message input -->
                <div class="form-group">
                    <label for="notificationMessage">Message *</label>
                    <textarea id="notificationMessage" name="notificationMessage" rows="4" required></textarea>
                </div>

                <!-- Delivery channel selection sms or email -->
                <div class="form-group">
                    <div class="checkbox-group">
                        <label class="checkbox-container">
                            <input type="checkbox" id="sendEmail" name="sendEmail" checked>
                            <span class="checkmark"></span>
                            Email
                        </label>
                        <label class="checkbox-container">
                            <input type="checkbox" id="sendSMS" name="sendSMS" checked>
                            <span class="checkmark"></span>
                            SMS
                        </label>
                    </div>
                </div>
                <!-- sms or email div close -->

                <!-- form actions -->
                <div class="form-actions">
                    <button type="button" id="cancelNotification" class="btn btn-cancel">Cancel</button>
                    <button type="submit" class="btn btn-send">Send</button>
                </div>
                <!-- form actions close -->
            </form> <!-- notificationForm close -->
        </div>  <!-- div modal-content close -->
    </div> <!-- divnotificationModal close -->



    <!-- =========================
     ADD SUBSCRIPTION PLAN MODAL
     ========================= -->
<div id="subscriptionModal" class="modal">
    <!-- Modal content wrapper -->
    <div class="modal-content">

        <!-- Modal header -->
        <div class="modal-header">
            <h2>Add Subscription Plan</h2>

            <!-- Close button -->
            <span class="close-btn" id="closeSubscription">&times;</span>
        </div>
        <!-- div modal-header close -->

        <!-- Subscription plan creation form -->
        <form id="subscriptionForm">

            <!-- Plan name input -->
            <div class="form-group">
                <label for="planName">Plan Name *</label>
                <input type="text" id="planName" name="planName" required>
            </div>

            <!-- Plan description input -->
            <div class="form-group">
                <label for="planDescription">Description</label>
                <textarea id="planDescription" name="planDescription" rows="3"></textarea>
            </div>

            <!-- Plan pricing input -->
            <div class="form-group">
                <label for="planPrice">Price (₹) *</label>
                <input type="number"
                       id="planPrice"
                       name="planPrice"
                       min="0"
                       step="0.01"
                       required>
            </div>

            <!-- Billing cycle selection -->
            <div class="form-group">
                <label for="billingCycle">Billing Cycle</label>
                <select id="billingCycle" name="billingCycle">
                    <option value="monthly">Monthly</option>
                    <option value="quarterly">Quarterly</option>
                    <option value="yearly">Yearly</option>
                </select>
            </div>

            <!-- Plan active status toggle -->
            <div class="form-group">
                <div class="checkbox-group">
                    <label class="checkbox-container">
                        <input type="checkbox" id="isActive" name="isActive" checked>
                        <span class="checkmark"></span>
                        Active
                    </label>
                </div>
            </div>

            <!-- Form action buttons -->
            <div class="form-actions">
                <button type="button"
                        id="cancelSubscription"
                        class="btn btn-cancel">
                    Cancel
                </button>

                <button type="submit"
                        class="btn btn-primary">
                    Create Plan
                </button>
            </div>

        </form>
        <!-- form subscriptionForm close -->

    </div>
    <!-- div modal-content close -->
</div>
<!-- div subscriptionModal close -->



<!-- =========================
     DASHBOARD CONTAINER
     ========================= -->

    <div class="container">
        <!-- Sidebar -->
         <!-- <aside> because it stays on the side and helps navigate the page -->
        <aside class="sidebar">

        <!-- Application logo -->
            <div class="logo">
                <i class="fas fa-chart-pie"></i>
            </div>

            <!-- Sidebar navigation -->
            <nav>
                <ul>
                    <li class="active" title="Dashboard"><i class="fas fa-home"></i></li>
                    <li title="Analytics"><i class="fas fa-chart-line"></i></li>
                    <li title="Users"><i class="fas fa-users"></i></li>
                    <li title="Products"><i class="fas fa-box"></i></li>
                    <li title="Orders"><i class="fas fa-shopping-cart"></i></li>
                    <li title="Settings"><i class="fas fa-cog"></i></li>
                </ul>
            </nav> <!-- closed sidebar-navigation -->

            <!-- Logout button -->
            <div class="logout" title="Logout">
                <i class="fas fa-sign-out-alt"></i>
            </div>
        </aside>

         <!-- =========================
         MAIN CONTENT AREA
         ========================= -->
        <main class="main-content">

        <!-- Dashboard header -->
            <header class="header">
                <div>
                    <h1 class="header-title">Dashboard</h1>
                    <p class="header-subtitle">Welcome back, Admin</p>
                </div>
            </header>

             <!-- =========================
             STATS SUMMARY CARDS
             ========================= -->
            <div class="stats-grid">
                <!-- Total clients -->
                <div class="stat-card stat-card-blue">
                    <div class="stat-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div class="stat-details">
                        <h3>5</h3>
                        <p>Total Clients</p>
                    </div>
                </div>

                <!-- Active clients -->
                <div class="stat-card stat-card-green">
                    <div class="stat-icon">
                        <i class="fas fa-check"></i>
                    </div>
                    <div class="stat-details">
                        <h3>4</h3>
                        <p>Active</p>
                    </div>
                </div>

                <!-- Expiring soon clients -->
                <div class="stat-card stat-card-orange">
                    <div class="stat-icon">
                        <i class="fas fa-exclamation"></i>
                    </div>
                    <div class="stat-details">
                        <h3>1</h3>
                        <p>Expiring Soon</p>
                    </div>
                </div>
            </div>

            <!-- =========================
            dashboard Body
            ========================= -->
            <div class="dashboard-content">
                <!-- =========================
                main-content-2
                ========================= -->
                <div class="main-content-2">
                    <!-- Clients overview header -->
                    <div class="section-header">
                        <h2>Clients Overview</h2>
                        <a href="#" class="view-all">View All</a>
                    </div>
                    
                    <!-- Clients grid where all clients are displayed -->
                    <div class="clients-grid">
                        <!-- Client Card 1 -->
                        <div class="client-card">
                            <div class="client-avatar client-avatar-blue">AC</div>
                            <div class="client-info">
                                <h3>Acme Corp</h3>
                                <p>John Smith • Enterprise</p>
                                <div class="storage-bar">
                                    <div class="storage-fill" style="width: 85%;"></div>
                                </div>
                                <div class="storage-info">
                                    <span>85% Storage Used</span>
                                </div>
                            </div>
                            <div class="client-status active">Active</div>
                        </div>

                        <!-- Client Card 2 -->
                        <div class="client-card">
                            <div class="client-avatar" style="background-color: #e8f5e9; color: #388e3c;">TI</div>
                            <div class="client-info">
                                <h3>TechStart</h3>
                                <p>Sarah Johnson • Startup</p>
                                <div class="storage-bar">
                                    <div class="storage-fill" style="width: 45%;"></div>
                                </div>
                                <div class="storage-info">
                                    <span>45% Storage Used</span>
                                </div>
                            </div>
                            <div class="client-status active">Active</div>
                        </div>

                        <!-- Client Card 3 -->
                        <div class="client-card">
                            <div class="client-avatar" style="background-color: #fff3e0; color: #f57c00;">GR</div>
                            <div class="client-info">
                                <h3>Global Retail</h3>
                                <p>Michael Brown • Business</p>
                                <div class="storage-bar">
                                    <div class="storage-fill" style="width: 72%;"></div>
                                </div>
                                <div class="storage-info">
                                    <span>72% Storage Used</span>
                                </div>
                            </div>
                            <div class="client-status active">Active</div>
                        </div>

                        <!-- Client Card 4 -->
                        <div class="client-card">
                            <div class="client-avatar" style="background-color: #e0f7fa; color: #00acc1;">DS</div>
                            <div class="client-info">
                                <h3>DataSystems</h3>
                                <p>Emily Davis • Enterprise</p>
                                <div class="storage-bar">
                                    <div class="storage-fill" style="width: 38%;"></div>
                                </div>
                                <div class="storage-info">
                                    <span>38% Storage Used</span>
                                </div>
                            </div>
                            <div class="client-status active">Active</div>
                        </div>

                        <!-- Client Card 5 -->
                        <div class="client-card">
                            <div class="client-avatar" style="background-color: #f3e5f5; color: #8e24aa;">MS</div>
                            <div class="client-info">
                                <h3>MediaSoft</h3>
                                <p>David Wilson • Professional</p>
                                <div class="storage-bar">
                                    <div class="storage-fill" style="width: 62%;"></div>
                                </div>
                                <div class="storage-info">
                                    <span>62% Storage Used</span>
                                </div>
                            </div>
                            <div class="client-status expiring">Expiring</div>
                        </div>
                    </div>
                </div>
                <!-- end of main-content-2 -->


                <!-- =========================
                 RIGHT SIDEBAR PANEL
                 ========================= -->
                <div class="sidebar-content">

                <!-- Quick actions -->
                    <div class="quick-actions">
                        <h3>Quick Actions</h3>
                        <button id="addClientBtn" class="action-btn primary">
                             <!-- new client is getting add from here -->
                            <i class="fas fa-plus"></i> Add New Client
                        </button>
                        <button id="sendNotificationBtn" class="action-btn secondary">
                            <!-- notification is getting send from here -->
                            <i class="fas fa-paper-plane"></i> Send Notification
                        </button>
                    </div>
                     <!-- div quick-actions close -->


                     <!-- Expiring clients section -->
                    <div class="expiring-soon">
                        <div class="section-header">
                            <h3>Expiring Soon</h3>
                        </div>
                        <div class="expiring-card">
                            <div class="expiring-avatar" style="background-color: #e8f5e9; color: #388e3c;">TI</div>
                            <div class="expiring-info">
                                <h4>TechStart</h4>
                                <p>2024-12-25</p>
                            </div>
                            <a href="#" class="view-details">View Details</a>
                        </div>
                    </div>
                  <!-- div expiring-soon close -->

                  <!-- Subscription Plans section -->
                  <div class="quick-actions">
                        <div class="section-header">
                            <h3>Subscription Plans</h3>
                            <a href="#" class="view-all-2">View All</a>
                        </div>
                        <!-- Subscription plan add from here -->
                        <button id="addSubscriptionBtn" class="action-btn secondary">
                            <i class="fas fa-plus-circle"></i> Add Subscription Plan
                        </button>
                    </div>  <!-- div quick-actions close -->
                </div> <!-- sidebar-content close -->
            </div> <!-- main-content-2 close -->
        </main> <!-- main-content close -->
    </div> <!-- dashboard-content close -->



    <script>
        document.addEventListener('DOMContentLoaded', function() {

            /* -----------------------------------------
            BASIC ELEMENT REFERENCES
            -----------------------------------------
            */
            // Get the modal and buttons
            const modal = document.getElementById('addClientModal');
            const btn = document.getElementById('addClientBtn');
            const closeBtn = document.querySelector('.close-btn');
            const form = document.getElementById('addClientForm');
            const cancelBtn = document.getElementById('cancelBtn');

            
             /* -----------------------------------------
            ADD CLIENT MODAL – OPEN / CLOSE
            -----------------------------------------
            These functions simply show or hide
            the "Add Client" popup.
            */
            function showModal() {
                modal.style.display = 'flex';
                modal.classList.add('show');
                document.body.style.overflow = 'hidden'; // Prevent scrolling when modal is open
            }

            // Function to hide modal
            function hideModal() {
                modal.style.display = 'none';
                modal.classList.remove('show');
                document.body.style.overflow = ''; // Re-enable scrolling
            }

            // Modal Elements
            const notificationModal = document.getElementById('notificationModal');
            const notificationBtn = document.getElementById('sendNotificationBtn');
            const closeNotificationBtn = document.getElementById('closeNotification');
            const cancelNotificationBtn = document.getElementById('cancelNotification');
            
            // Subscription Modal Elements
            const subscriptionModal = document.getElementById('subscriptionModal');
            const subscriptionBtn = document.getElementById('addSubscriptionBtn');
            const closeSubscriptionBtn = document.getElementById('closeSubscription');
            const cancelSubscriptionBtn = document.getElementById('cancelSubscription');

            // Open notification modal
            if (notificationBtn) {
                notificationBtn.addEventListener('click', function() {
                    notificationModal.style.display = 'flex';
                    notificationModal.classList.add('show');
                    document.body.style.overflow = 'hidden';
                });
            }
            
            // Close notification modal
            function closeNotificationModal() {
                notificationModal.style.display = 'none';
                notificationModal.classList.remove('show');
                document.body.style.overflow = '';
            }
            
            if (closeNotificationBtn) {
                closeNotificationBtn.addEventListener('click', closeNotificationModal);
            }
            
            if (cancelNotificationBtn) {
                cancelNotificationBtn.addEventListener('click', closeNotificationModal);
            }
            
            // Close modal when clicking outside the content
            window.addEventListener('click', function(event) {
                if (event.target === notificationModal) {
                    closeNotificationModal();
                }
            });
            
            // Handle form submission
            const notificationForm = document.getElementById('notificationForm');
            if (notificationForm) {
                notificationForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    // Get form data
                    const formData = {
                        broadcastTo: document.getElementById('broadcastTo').value,
                        message: document.getElementById('notificationMessage').value,
                        sendEmail: document.getElementById('sendEmail').checked,
                        sendSMS: document.getElementById('sendSMS').checked
                    };
                    
                    // Close the modal and reset the form
                    closeNotificationModal();
                    notificationForm.reset();
                });
            }

            // Set default dates for validity 
            function setDefaultDates() {
                const today = new Date();
                const nextYear = new Date();
                nextYear.setFullYear(today.getFullYear() + 1);
                
                const formatDate = (date) => {
                    return date.toISOString().split('T')[0];
                };
            }

            // add client modal open
            if (btn) {
                btn.addEventListener('click', function() {
                    showModal();
                    setDefaultDates();
                });
            }

            // add client modal close
            if (closeBtn) {
                closeBtn.addEventListener('click', hideModal);
            }

            // add client modal cancel
            if (cancelBtn) {
                cancelBtn.addEventListener('click', hideModal);
            }

            // Close when clicking outside the modal content
            window.addEventListener('click', function(event) {
                if (event.target === modal) {
                    hideModal();
                }
            });

            // Handle form submission
            if (form) {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                
                // Show success modal
                const successModal = document.getElementById('successModal');
                successModal.style.display = 'flex';
                successModal.classList.add('show');
                
                // Submit form after delay
                setTimeout(() => {
                    form.submit();
                }, 4000);
                
                console.log('Form submitted', {
                client_name: document.getElementById('client_name').value,
                company_name: document.getElementById('name').value,
                contact_person: document.getElementById('contact_person').value,
                email: document.getElementById('email').value,
                password: document.getElementById('password').value,
                mobile: document.getElementById('mobile').value,

                building_no: document.getElementById('building_no').value,
                premises_name: document.getElementById('premises_name').value,
                landmark: document.getElementById('landmark').value,
                road_street: document.getElementById('road_street').value,
                pincode: document.getElementById('pincode').value,
                district: document.getElementById('district').value,
                state: document.getElementById('state').value,
                country: document.getElementById('country').value,

                industry_type: document.getElementById('industry_type').value,
                number_of_emplooyees: document.getElementById('number_of_emplooyees').value,

                software_package_plan: document.getElementById('software_package_plan').value,
                storage_limit: document.getElementById('storage_limit').value,
                number_of_user_allowed: document.getElementById('number_of_user_allowed').value,
                organisation_status: document.getElementById('organisation_status').value,

                GST_number: document.getElementById('GST_number').value,
                PAN: document.getElementById('PAN').value,
                TAN: document.getElementById('TAN').value,
                expire_date: document.getElementById('expire_date').value
    });
  });
}

            // Close with Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    if (modal.classList.contains('show')) {
                        hideModal();
                    } else if (notificationModal.style.display === 'flex') {
                        closeNotificationModal();
                    } else if (subscriptionModal.style.display === 'flex') {
                        closeSubscriptionModal();
                    }
                }
            });

            // Subscription Plan Modal Functions
            function showSubscriptionModal() {
                subscriptionModal.style.display = 'flex';
                subscriptionModal.classList.add('show');
                document.body.style.overflow = 'hidden';
            }
            //close subscription modalfunction
            function closeSubscriptionModal() {
                subscriptionModal.style.display = 'none';
                subscriptionModal.classList.remove('show');
                document.body.style.overflow = '';
            }

            // Open subscription modal
            if (subscriptionBtn) {
                subscriptionBtn.addEventListener('click', showSubscriptionModal);
            }
            
            // Close subscription modal
            if (closeSubscriptionBtn) {
                closeSubscriptionBtn.addEventListener('click', closeSubscriptionModal);
            }
            
            //cancel subscription modal
            if (cancelSubscriptionBtn) {
                cancelSubscriptionBtn.addEventListener('click', closeSubscriptionModal);
            }
            
            // Close subscription modal when clicking outside
            window.addEventListener('click', function(event) {
                if (event.target === subscriptionModal) {
                    closeSubscriptionModal();
                }
            });
            
            // Handle subscription form submission of subscription modal
            const subscriptionForm = document.getElementById('subscriptionForm');
            if (subscriptionForm) {
                subscriptionForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    // Get form data
                    const formData = {
                        planName: document.getElementById('planName').value,
                        planDescription: document.getElementById('planDescription').value,
                        planPrice: document.getElementById('planPrice').value,
                        billingCycle: document.getElementById('billingCycle').value,
                        isActive: document.getElementById('isActive').checked
                    };
                    
                    // Here you would typically send the data to your server
                    console.log('Subscription plan data:', formData);
                    
                    // Show success message
                    alert('Subscription plan created successfully!');
                    
                    // Close the modal and reset the form
                    closeSubscriptionModal();
                    subscriptionForm.reset();
                });
            }
        });
    </script>

    <!-- SUCCESS MODAL -->
<div id="successModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Success</h2>
            <span class="close-btn" id="closeSuccess">&times;</span>
        </div>
        <p>Client added successfully</p>
        <button id="successOkBtn" class="btn btn-primary">OK</button>
    </div>
</div> 

<script>
    // Close success modal
    document.getElementById('closeSuccess').addEventListener('click', function() {
        const successModal = document.getElementById('successModal');
        successModal.style.display = 'none';
        successModal.classList.remove('show');
    });

    document.getElementById('successOkBtn').addEventListener('click', function() {
        const successModal = document.getElementById('successModal');
        successModal.style.display = 'none';
        successModal.classList.remove('show');
    });

    // Close modal when clicking outside
    window.addEventListener('click', function(event) {
        const successModal = document.getElementById('successModal');
        if (event.target === successModal) {
            successModal.style.display = 'none';
            successModal.classList.remove('show');
        }
    });
</script>
</body>
</html>

