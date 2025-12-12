<a href="{{ route('admin.logout') }}">Logout</a>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="{{ asset('Offical_admin/css/official_admin.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <!-- Add Client Modal -->
    <div id="addClientModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Add New Client</h2>
                <span class="close-btn">&times;</span>
            </div>
            <form id="addClientForm" class="compact-form">
                <div class="form-grid">
                    <!-- Basic Information -->
                    <div class="form-group">
                        <input type="text" id="clientName" name="clientName" placeholder="Client Name *" required>
                    </div>
                    <div class="form-group">
                        <input type="text" id="companyName" name="companyName" placeholder="Company Name *" required>
                    </div>

                    <!-- Contact Information -->
                    <div class="form-group">
                        <input type="text" id="contactPerson" name="contactPerson" placeholder="Contact Person *" required>
                    </div>
                    <div class="form-group">
                        <input type="email" id="clientEmail" name="clientEmail" placeholder="Email *" required>
                    </div>
                    <div class="form-group">
                        <input type="tel" id="clientPhone" name="clientPhone" placeholder="Phone *" required>
                    </div>
                    
                    <!-- Address Fields -->
                    <div class="form-group">
                        <input type="text" id="buildingNo" name="buildingNo" placeholder="Building/House No. *" required>
                    </div>
                    <div class="form-group">
                        <input type="text" id="premisesName" name="premisesName" placeholder="Premises Name">
                    </div>
                    <div class="form-group">
                        <input type="text" id="landmark" name="landmark" placeholder="Landmark">
                    </div>
                    <div class="form-group">
                        <input type="text" id="roadStreet" name="roadStreet" placeholder="Road/Street *" required>
                    </div>
                    <div class="form-group">
                        <input type="text" id="pincode" name="pincode" placeholder="Pincode *" required>
                    </div>
                    <div class="form-group">
                        <input type="text" id="district" name="district" placeholder="District *" required>
                    </div>
                    <div class="form-group">
                        <input type="text" id="state" name="state" placeholder="State *" required>
                    </div>
                    <div class="form-group">
                        <input type="text" id="country" name="country" value="India" readonly>
                    </div>

                    <!-- Business Details -->
                    <div class="form-group">
                        <select id="industryType" name="industryType" required>
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
                        <input type="number" id="employeeCount" name="employeeCount" min="1" placeholder="Number of Employees *" required>
                    </div>

                    <!-- Package Information -->
                    <div class="form-group">
                        <select id="packagePlan" name="packagePlan" required>
                            <option value="">Select Plan *</option>
                            <option value="basic">Basic</option>
                            <option value="standard">Standard</option>
                            <option value="enterprise">Enterprise</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="number" id="storageLimit" name="storageLimit" min="1" placeholder="Storage (GB) *" required>
                    </div>
                    <div class="form-group">
                        <input type="number" id="maxUsers" name="maxUsers" min="1" placeholder="Max Users *" required>
                    </div>
                    <div class="form-group">
                        <select id="status" name="status" required>
                            <option value="">Select Status *</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="suspended">Suspended</option>
                        </select>
                    </div>

                    <!-- Legal Information -->
                    <div class="form-group">
                        <input type="text" id="gstNumber" name="gstNumber" placeholder="GST Number">
                    </div>
                    <div class="form-group">
                        <input type="text" id="panCard" name="panCard" placeholder="PAN *" required>
                    </div>
                    <div class="form-group">
                        <input type="text" id="tanNumber" name="tanNumber" placeholder="TAN Number">
                    </div>
                    <div class="form-group">
                    
                        <input type="date" id="expiryDate" name="expiryDate" required>
                    </div>

                    <div class="certificate-files">
                        <div class="form-group">
                            <label for="companyLogo" class="file-upload-label">Company Logo</label>
                            <input type="file" id="companyLogo" name="companyLogo" accept="image/*" class="file-upload-input">
                        </div>
                        <div class="form-group">
                            <label for="gstCertificate" class="file-upload-label">GST Certificate</label>
                            <input type="file" id="gstCertificate" name="gstCertificate" accept=".pdf,.jpg,.jpeg,.png" class="file-upload-input">
                        </div>
                        <div class="form-group">
                            <label for="msmeCertificate" class="file-upload-label">MSME Certificate</label>
                            <input type="file" id="msmeCertificate" name="msmeCertificate" accept=".pdf,.jpg,.jpeg,.png" class="file-upload-input">
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="button" id="cancelBtn" class="btn btn-secondary">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Send Notification Modal -->
    <div id="notificationModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Send Notification</h2>
                <span class="close-btn" id="closeNotification">&times;</span>
            </div>
            <form id="notificationForm">
                <div class="form-group">
                    <label for="broadcastTo">Broadcast All</label>
                    <select id="broadcastTo" name="broadcastTo">
                        <option value="all">All Users</option>
                        <option value="active">Active Users</option>
                        <option value="inactive">Inactive Users</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="notificationMessage">Message *</label>
                    <textarea id="notificationMessage" name="notificationMessage" rows="4" required></textarea>
                </div>
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
                <div class="form-actions">
                    <button type="button" id="cancelNotification" class="btn btn-cancel">Cancel</button>
                    <button type="submit" class="btn btn-send">Send</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add Subscription Plan Modal -->
    <div id="subscriptionModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Add Subscription Plan</h2>
                <span class="close-btn" id="closeSubscription">&times;</span>
            </div>
            <form id="subscriptionForm">
                <div class="form-group">
                    <label for="planName">Plan Name *</label>
                    <input type="text" id="planName" name="planName" required>
                </div>
                <div class="form-group">
                    <label for="planDescription">Description</label>
                    <textarea id="planDescription" name="planDescription" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="planPrice">Price (₹) *</label>
                    <input type="number" id="planPrice" name="planPrice" min="0" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="billingCycle">Billing Cycle</label>
                    <select id="billingCycle" name="billingCycle">
                        <option value="monthly">Monthly</option>
                        <option value="quarterly">Quarterly</option>
                        <option value="yearly">Yearly</option>
                    </select>
                </div>
                <div class="form-group">
                    <div class="checkbox-group">
                        <label class="checkbox-container">
                            <input type="checkbox" id="isActive" name="isActive" checked>
                            <span class="checkmark"></span>
                            Active
                        </label>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="button" id="cancelSubscription" class="btn btn-cancel">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Plan</button>
                </div>
            </form>
        </div>
    </div>

    <div class="container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="logo">
                <i class="fas fa-chart-pie"></i>
            </div>
            <nav>
                <ul>
                    <li class="active" title="Dashboard"><i class="fas fa-home"></i></li>
                    <li title="Analytics"><i class="fas fa-chart-line"></i></li>
                    <li title="Users"><i class="fas fa-users"></i></li>
                    <li title="Products"><i class="fas fa-box"></i></li>
                    <li title="Orders"><i class="fas fa-shopping-cart"></i></li>
                    <li title="Settings"><i class="fas fa-cog"></i></li>
                </ul>
            </nav>
            <div class="logout" title="Logout">
                <i class="fas fa-sign-out-alt"></i>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header class="header">
                <div>
                    <h1 class="header-title">Dashboard</h1>
                    <p class="header-subtitle">Welcome back, Admin</p>
                </div>
            </header>

            <div class="stats-grid">
                <div class="stat-card stat-card-blue">
                    <div class="stat-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div class="stat-details">
                        <h3>5</h3>
                        <p>Total Clients</p>
                    </div>
                </div>
                <div class="stat-card stat-card-green">
                    <div class="stat-icon">
                        <i class="fas fa-check"></i>
                    </div>
                    <div class="stat-details">
                        <h3>4</h3>
                        <p>Active</p>
                    </div>
                </div>
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

            <div class="dashboard-content">
                <div class="main-content-2">
                    <div class="section-header">
                        <h2>Clients Overview</h2>
                        <a href="#" class="view-all">View All</a>
                    </div>
                    
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

                <div class="sidebar-content">
                    <div class="quick-actions">
                        <h3>Quick Actions</h3>
                        <button id="addClientBtn" class="action-btn primary">
                            <i class="fas fa-plus"></i> Add New Client
                        </button>
                        <button id="sendNotificationBtn" class="action-btn secondary">
                            <i class="fas fa-paper-plane"></i> Send Notification
                        </button>
                    </div>

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
                  <div class="quick-actions">
                        <div class="section-header">
                            <h3>Subscription Plans</h3>
                            <a href="#" class="view-all-2">View All</a>
                        </div>
                        
                        <button id="addSubscriptionBtn" class="action-btn secondary">
                            <i class="fas fa-plus-circle"></i> Add Subscription Plan
                        </button>
                    </div>  
                </div>
            </div>
        </main>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get the modal and buttons
            const modal = document.getElementById('addClientModal');
            const btn = document.getElementById('addClientBtn');
            const closeBtn = document.querySelector('.close-btn');
            const form = document.getElementById('addClientForm');
            const cancelBtn = document.getElementById('cancelBtn');

            // Function to show modal
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
                    
                    // Here you would typically send the data to your server
                    console.log('Notification data:', formData);
                    
                    // Show success message
                    alert('Notification sent successfully!');
                    
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
                
                document.getElementById('validityFrom').value = formatDate(today);
                document.getElementById('validityTo').value = formatDate(nextYear);
            }

            // Event Listeners
            if (btn) {
                btn.addEventListener('click', function() {
                    showModal();
                    setDefaultDates();
                });
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

            // Handle form submission
            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    // Here you would typically send the form data to your server
                    console.log('Form submitted', {
                        companyName: document.getElementById('companyName').value,
                        contactPerson: document.getElementById('contactPerson').value,
                        clientEmail: document.getElementById('clientEmail').value,
                        clientPhone: document.getElementById('clientPhone').value,
                        alternateContact: document.getElementById('alternateContact').value,
                        gstNumber: document.getElementById('gstNumber').value,
                        panCard: document.getElementById('panCard').value,
                        packagePlan: document.getElementById('packagePlan').value,
                        validityFrom: document.getElementById('validityFrom').value,
                        validityTo: document.getElementById('validityTo').value
                    });
                    
                    alert('Client created successfully!');
                    hideModal();
                    form.reset();
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
            
            if (cancelSubscriptionBtn) {
                cancelSubscriptionBtn.addEventListener('click', closeSubscriptionModal);
            }
            
            // Close subscription modal when clicking outside
            window.addEventListener('click', function(event) {
                if (event.target === subscriptionModal) {
                    closeSubscriptionModal();
                }
            });
            
            // Handle subscription form submission
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
</body>
</html>
