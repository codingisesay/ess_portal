<!-- Client Details Popup -->
<div id="clientPopup" class="client-popup" style="display: none;">

<!-- div client-popup-content open  -->
    <div class="client-popup-content">
        <span class="close-popup">&times;</span>

        <!-- View Mode -->
        <div id="viewMode">
            <div class="client-popup-header">
                <h2 id="clientName">Client Name</h2>
                <span id="clientStatus" class="client-status active">Active</span>
            </div>


        <!-- fileds which are present insidde the popup -->
            
            <div class="client-popup-details">
                <p><strong>Contact:</strong> <span id="clientContact">—</span></p>
                <p><strong>Email:</strong> <span id="clientEmail">—</span></p>
                <p><strong>Package:</strong> <span id="clientPackage">—</span></p>
                <p><strong>Phone:</strong> <span id="clientPhone">—</span></p>
            </div>

        <!-- two action buttons-->

            <div class="client-popup-actions">
                <button type="button" class="btn btn-secondary" id="cancelViewBtn" style="margin-right: 8px;">
                    Cancel
                </button>
                <button class="btn btn-primary" id="editClientBtn">Edit</button>
            </div>
        </div>

        <!-- Edit Mode -->
    <form id="editMode"
      method="POST"
      action="{{ route('organisation.update', $organisation->id ?? '') }}"
      enctype="multipart/form-data"
      style="display:none;">
    @csrf

    <div class="client-popup-header">
        <h2>Edit Client</h2>
    </div>

      <!-- Hidden organisation ID -->
    <input type="hidden" name="id" id="editId">

    <div class="form-group">
        <input type="text" id="editName" name="name" class="form-control" required>
        <label>Client Name</label>
    </div>

    <div class="form-group">
        <input type="text" id="editContact" name="contact_person" class="form-control" required>
        <label>Contact Person</label>
    </div>

    <div class="form-group">
        <input type="email" id="editEmail" name="email" class="form-control">
        <label>Email</label>
    </div>

    <!-- changed the phone to mobile to edit is visible -->
    <div class="form-group">
        <input type="number " 
               id="editPhone" 
               name="mobile" 
               class="form-control"
               title="Please enter a valid phone number (10 digits)"
               min="10"
               maxlength="10"
               pattern="[0-9]{10}"
               inputmode="numeric"
               required
               oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);">
        <label>Phone</label>
    </div>

    <!-- Subscription Plans get from the subscription plan module where we cretae a subscritption plan -->
    <div class="form-group">
        <select id="editPackage" name="software_package_plan" class="form-control">
            <option value="" disabled selected></option>

                            @foreach($subscriptionPlans as $plan)
                                <option value="{{ $plan->id }}">
                                    {{ $plan->plan_name }}
                                </option>
                            @endforeach
                        </select>
        <label>Package</label>
    </div>

    <div class="form-group form-check">
        <label class="form-check-label">Status</label>
        <div class="form-check form-switch">
            <!-- Hidden input for organisation_status (submitted) -->
            <input type="hidden" name="organisation_status" id="editStatusHidden" value="Incative">
            <!-- Checkbox only toggles the hidden input; it does not submit directly -->
            <input type="checkbox" id="editStatus" class="form-check-input">
            <label class="form-check-label" for="editStatus">Active</label>
        </div>
    </div>

    <div class="client-popup-actions">
        <button type="button" id="cancelEditBtn" class="btn btn-secondary">Cancel</button>
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </div>
</form>
    
    
    </div><!-- div client-popup-content closed -->
</div><!--clientPopup div end -->

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Handle status toggle
    const statusToggle = document.getElementById('editStatus');
    const statusLabel = document.querySelector('label[for="editStatus"]');
    
    if (statusToggle) {
        // Update label on toggle
        statusToggle.addEventListener('change', function() {
            statusLabel.textContent = this.checked ? 'Active' : 'Inactive';
        });
        
        // Initialize label text
        statusLabel.textContent = statusToggle.checked ? 'Active' : 'Inactive';
    }

    // Open popup when clicking client card
    document.querySelectorAll('.client-card').forEach(card => {
        card.addEventListener('click', function (e) {

            if (e.target.closest('button, a')) return;


            //iif  there is no data at that time it show "-"
            const clientName = this.querySelector('h3')?.textContent || '—';
            const clientContact = this.querySelector('p')?.textContent.trim() || '—';
            const clientEmail = this.getAttribute('data-email') || '—';
            const clientPhone = this.getAttribute('data-phone') || '—';
            const clientPackage = this.getAttribute('data-package') || '—';
            const clientPackageId = this.getAttribute('data-package-id') || '';
            // Prefer explicit organisation_status attribute if available, fallback to displayed .client-status text
            let clientStatus = this.getAttribute('data-organisation-status') ||
                this.querySelector('.client-status')?.getAttribute('data-organisation-status') ||
                this.querySelector('.client-status')?.textContent.trim().toLowerCase() || 'inactive';
            clientStatus = (clientStatus || 'inactive').toString().toLowerCase();
            
            // Store client ID if available (for server-side updates)
            const clientId = this.getAttribute('data-client-id');
            if (clientId) {
                document.getElementById('clientPopup').setAttribute('data-client-id', clientId);
            }
            //getting package id from the data when we insert the client newly
            document.getElementById('clientPopup').setAttribute('data-package-id', clientPackageId);

            document.getElementById('clientName').textContent = clientName;
            
            // Show the popup
            document.getElementById('clientPopup').style.display = 'block';
            
            // Close popup when clicking the cancel button in view mode
            document.getElementById('cancelViewBtn').addEventListener('click', function(e) {
                e.stopPropagation();
                document.getElementById('clientPopup').style.display = 'none';
            });
            document.getElementById('clientContact').textContent = clientContact;
            document.getElementById('clientEmail').textContent = clientEmail;
            document.getElementById('clientPhone').textContent = clientPhone;
            document.getElementById('clientPackage').textContent = clientPackage;

            const statusEl = document.getElementById('clientStatus');
            // Normalize display text and CSS class based on organisation_status
            const displayText = clientStatus === 'active' ? 'Active' : 'Inactive';
            statusEl.textContent = displayText;
            statusEl.className = `client-status ${clientStatus === 'active' ? 'active' : 'inactive'}`;

            // Store the canonical organisation_status on the popup for later use when editing
            document.getElementById('clientPopup').setAttribute('data-organisation-status', clientStatus);

            document.getElementById('clientPopup').style.display = 'flex';
        });
    });

    // Close popup (X)
    document.querySelector('.close-popup')?.addEventListener('click', () => {
        document.getElementById('clientPopup').style.display = 'none';
    });

    // Close popup (outside click)
    window.addEventListener('click', (e) => {
        const popup = document.getElementById('clientPopup');
        if (e.target === popup) {
            popup.style.display = 'none';
        }
    });



    // Edit Client button
    document.getElementById('editClientBtn')?.addEventListener('click', () => {
        // Get current values
        const name = document.getElementById('clientName').textContent;
        const contact = document.getElementById('clientContact').textContent;
        const email = document.getElementById('clientEmail').textContent;
        const phone = document.getElementById('clientPhone').textContent;
        const package = document.getElementById('clientPackage').textContent;

        //getting the cuurent value of software package id
        const popupPkgId = document.getElementById('clientPopup').getAttribute('data-package-id') || '';
        // Read canonical organisation_status stored on the popup (prefer that over DOM classes)
        const popupStatus = document.getElementById('clientPopup').getAttribute('data-organisation-status') ||
            document.getElementById('clientStatus').textContent.trim().toLowerCase();
        const status = (popupStatus || 'inactive').toLowerCase() === 'active';
        
        // Set form values
        document.getElementById('editName').value = name;
        document.getElementById('editContact').value = contact;
        document.getElementById('editEmail').value = email === '—' ? '' : email;
        document.getElementById('editPhone').value = phone === '—' ? '' : phone;
        
        //setting the current value of software package id
        document.getElementById('editPackage').value = popupPkgId;
        document.getElementById('editStatus').checked = status;
        // Sync label text with current status when entering edit mode
        const editStatusLabel1 = document.querySelector('label[for="editStatus"]');
        if (editStatusLabel1) {
            editStatusLabel1.textContent = status ? 'Active' : 'Inactive';
        }
        
        // Toggle view/edit modes
        document.getElementById('viewMode').style.display = 'none';
        document.getElementById('editMode').style.display = 'block';
    });
    
    // Cancel Edit button
    document.getElementById('cancelEditBtn')?.addEventListener('click', () => {
        document.getElementById('viewMode').style.display = 'block';
        document.getElementById('editMode').style.display = 'none';
    });
    
    

});
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const editForm = document.getElementById('editMode');

    // Open edit mode
    document.getElementById('editClientBtn')?.addEventListener('click', () => {

        const popup = document.getElementById('clientPopup');
        const clientId = popup.getAttribute('data-client-id');

        // Set form action
        editForm.action = `/admin/organisation/update/${clientId}`;

        document.getElementById('editName').value =
            document.getElementById('clientName').textContent;

        document.getElementById('editContact').value =
            document.getElementById('clientContact').textContent;

        document.getElementById('editEmail').value =
            document.getElementById('clientEmail').textContent === '—'
                ? ''
                : document.getElementById('clientEmail').textContent;

        document.getElementById('editPhone').value =
            document.getElementById('clientPhone').textContent === '—'
                ? ''
                : document.getElementById('clientPhone').textContent;

        document.getElementById('editPackage').value =
            (document.getElementById('clientPopup').getAttribute('data-package-id') || '');

        document.getElementById('editStatus').checked =
            document.getElementById('clientStatus').classList.contains('active');
        // Sync label text with current status when entering edit mode (like on a container)
        const editStatusLabel2 = document.querySelector('label[for="editStatus"]');
        if (editStatusLabel2) {
            editStatusLabel2.textContent = document.getElementById('editStatus').checked ? 'Active' : 'Inactive';
        }

        document.getElementById('viewMode').style.display = 'none';
        editForm.style.display = 'block';
    });

    // Cancel edit
    document.getElementById('cancelEditBtn')?.addEventListener('click', () => {
        editForm.style.display = 'none';
        document.getElementById('viewMode').style.display = 'block';
    });

    // Set organisation_status before submit (IMPORTANT)
    editForm?.addEventListener('submit', function () {
        // Controller expects 'Active' or 'Incative' (legacy typo), so send those values
        document.getElementById('editStatusHidden').value =
            document.getElementById('editStatus').checked
                ? 'Active'
                : 'Incative';
    });

});
</script>
