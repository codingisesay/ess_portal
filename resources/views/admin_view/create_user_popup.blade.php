<!-- Create user popup -->

<div id="createUserPopup" class="create-user-popup">

    <div class="create-user-popup-content">
        <!-- it will open a popup of create user  -->
        <div class="create-user-popup-header">
            <h3>Create New User</h3>
            <span class="close-create-user-popup" aria-label="Close">&times;</span>
        </div>

        <form class="create-user-form" id="userForm">
            <!-- Email Field -->
            <div class="form-group">
                <input type="email" id="userEmail" class="form-control" placeholder=" " required>
                <label for="userEmail">Email Address</label>
            </div>

            <!-- Password Field -->
            <div class="form-group password-group">
                <div class="password-input-container">
                    <input type="password" id="userPassword" class="form-control" placeholder=" " required minlength="8">
                    <label for="userPassword">Password</label>
                    <span class="toggle-password" data-target="userPassword" role="button" tabindex="0">
                        <i class="fas fa-eye"></i>
                    </span>
                </div>
                <small class="password-hint">Minimum 8 characters</small>
            </div>

            <!-- Role Selection -->
            <div class="form-group">
                <select id="userRole" class="form-control" required>
                    <option value="" disabled selected></option>
                    <option value="admin">Administrator</option>
                    <option value="manager">Manager</option>
                    <option value="user">Standard User</option>
                </select>
                <label for="userRole">User Role</label>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <button type="button" id="cancelCreateUser" class="btn btn-secondary">
                    Cancel
                </button>
                <button type="submit" id="submitCreateUser" class="btn btn-primary">
                    Create User
                </button>
            </div>
        </form>
    </div>
</div> <!-- div create user closed  -->


<script>
    document.addEventListener('DOMContentLoaded', () => {
    const popup = document.getElementById('createUserPopup');

     // Open the popup when "Create User" button is clicked
    document.getElementById('createUserBtn')?.addEventListener('click', () => {
        popup.style.display = 'flex';
    });
    // Close the popup when the close (X) icon is clicked
    document.querySelector('.close-create-user-popup')?.addEventListener('click', () => {
        popup.style.display = 'none';
    });
    // Close the popup when the Cancel button is clicked
    document.getElementById('cancelCreateUser')?.addEventListener('click', () => {
        popup.style.display = 'none';
    });
    // Close the popup when clicking outside the popup content
    window.addEventListener('click', (e) => {
        if (e.target === popup) {
            popup.style.display = 'none';
        }
    });
});
</script>