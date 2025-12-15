    <!-- Custom admin styles -->
    <link rel="stylesheet" href="{{ asset('Offical_admin/css/official_admin.css') }}">

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
    </div> <!-- div notificationModal close -->

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get the modal and buttons
    const modal = document.getElementById('notificationModal');
    const btn = document.getElementById('sendNotificationBtn');
    const closeBtn = modal ? modal.querySelector('#closeNotification') : null;
    const cancelBtn = document.getElementById('cancelNotification');
    const form = document.getElementById('notificationForm');

    // Function to show modal
    function showModal() {
        if (modal) {
            modal.style.display = 'flex';
            modal.classList.add('show');
            document.body.style.overflow = 'hidden';
        }
    }

    // Function to hide modal
    function hideModal() {
        if (modal) {
            modal.style.display = 'none';
            modal.classList.remove('show');
            document.body.style.overflow = '';
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
            
            // Get form data
            const formData = {
                broadcastTo: document.getElementById('broadcastTo').value,
                message: document.getElementById('notificationMessage').value,
                sendEmail: document.getElementById('sendEmail').checked,
                sendSMS: document.getElementById('sendSMS').checked
            };
           
            
            hideModal();
            form.reset();
        });
    }
});
</script>
@endpush
