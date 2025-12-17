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
                <button class="btn btn-success" id="createUserBtn">Create User</button>
                <button class="btn btn-primary" id="editClientBtn">Edit</button>
            </div>
        </div>

        <!-- Edit Mode -->
        <form id="editMode" style="display: none;">
            <div class="client-popup-header">
                <h2>Edit Client</h2>
            </div>


        <!-- the fields which can be edited -->

            <div class="form-group">
                <input type="text" id="editName" class="form-control" placeholder=" " required>
                <label for="editName">Client Name</label>
            </div>

            <div class="form-group">
                <input type="text" id="editContact" class="form-control" placeholder=" " required>
                <label for="editContact">Contact Person</label>
            </div>

            <div class="form-group">
                <input type="email" id="editEmail" class="form-control" placeholder=" ">
                <label for="editEmail">Email</label>
            </div>

            <div class="form-group">
                <input type="tel" id="editPhone" class="form-control" placeholder=" ">
                <label for="editPhone">Phone</label>
            </div>

            <div class="form-group">
                <select id="editPackage" class="form-control">
                    <option value="basic">Basic</option>
                    <option value="standard">Standard</option>
                    <option value="premium">Premium</option>
                </select>
                <label for="editPackage">Package</label>
            </div>

            <div class="form-group">
                <div class="form-check">
                    <input type="checkbox" id="editStatus" class="form-check-input">
                    <label class="form-check-label" for="editStatus">Active</label>
                </div>
            </div>

            <!-- two action buttons-->
            <div class="client-popup-actions">
                <button type="button" id="cancelEditBtn" class="btn btn-secondary">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
    </div><!-- div client-popup-content closed -->
</div><!--clientPopup div end -->

<script>
document.addEventListener('DOMContentLoaded', function () {

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
            const clientStatus = this.querySelector('.client-status')?.textContent.trim().toLowerCase() || 'inactive';
            
            // Store client ID if available (for server-side updates)
            const clientId = this.getAttribute('data-client-id');
            if (clientId) {
                document.getElementById('clientPopup').setAttribute('data-client-id', clientId);
            }

            document.getElementById('clientName').textContent = clientName;
            document.getElementById('clientContact').textContent = clientContact;
            document.getElementById('clientEmail').textContent = clientEmail;
            document.getElementById('clientPhone').textContent = clientPhone;
            document.getElementById('clientPackage').textContent = clientPackage;

            const statusEl = document.getElementById('clientStatus');
            statusEl.textContent = clientStatus.charAt(0).toUpperCase() + clientStatus.slice(1);
            statusEl.className = `client-status ${clientStatus}`;

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

    // Create User button
    document.getElementById('createUserBtn')?.addEventListener('click', function (e) {
        e.stopPropagation();

        document.getElementById('clientPopup').style.display = 'none';

        const createUserPopup = document.getElementById('createUserPopup');
        if (createUserPopup) {
            createUserPopup.style.display = 'flex';
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
        const status = document.getElementById('clientStatus').classList.contains('active');
        
        // Set form values
        document.getElementById('editName').value = name;
        document.getElementById('editContact').value = contact;
        document.getElementById('editEmail').value = email === '—' ? '' : email;
        document.getElementById('editPhone').value = phone === '—' ? '' : phone;
        document.getElementById('editPackage').value = package.toLowerCase() || 'basic';
        document.getElementById('editStatus').checked = status;
        
        // Toggle view/edit modes
        document.getElementById('viewMode').style.display = 'none';
        document.getElementById('editMode').style.display = 'block';
    });
    
    // Cancel Edit button
    document.getElementById('cancelEditBtn')?.addEventListener('click', () => {
        document.getElementById('viewMode').style.display = 'block';
        document.getElementById('editMode').style.display = 'none';
    });
    
    // Save Edit form
    document.getElementById('editMode')?.addEventListener('submit', (e) => {
        e.preventDefault();
        
        // Get form values
        const name = document.getElementById('editName').value;
        const contact = document.getElementById('editContact').value;
        const email = document.getElementById('editEmail').value;
        const phone = document.getElementById('editPhone').value;
        const package = document.getElementById('editPackage').value;
        const isActive = document.getElementById('editStatus').checked;
        
        // Update view mode with new values
        document.getElementById('clientName').textContent = name;
        document.getElementById('clientContact').textContent = contact;
        document.getElementById('clientEmail').textContent = email || '—';
        document.getElementById('clientPhone').textContent = phone || '—';
        document.getElementById('clientPackage').textContent = package.charAt(0).toUpperCase() + package.slice(1);
        
        const statusEl = document.getElementById('clientStatus');
        statusEl.textContent = isActive ? 'Active' : 'Inactive';
        statusEl.className = `client-status ${isActive ? 'active' : 'inactive'}`;
        
        // Here you would typically make an AJAX call to save the changes to the server
        console.log('Saving changes:', { name, contact, email, phone, package, isActive });
        
        // Show success message (you can replace this with actual feedback from your server)
        alert('Client details updated successfully!');
        
        // Switch back to view mode
        document.getElementById('viewMode').style.display = 'block';
        document.getElementById('editMode').style.display = 'none';
    });

});
</script>
