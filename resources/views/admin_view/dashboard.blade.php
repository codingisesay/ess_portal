<form id="addClientForm"
      class="compact-form"
      method="POST"
      action="{{ route('organisation.store') }}"
      enctype="multipart/form-data">

    @csrf

    <div class="form-grid">

        <!-- Basic Information -->
        <div class="form-group">
            <input type="text" name="client_name" placeholder="Client Name *"> 
        </div>

        <div class="form-group">
            <input type="text" name="name" placeholder="Company Name *" required>
        </div>

        <!-- Contact Information -->
        <div class="form-group">
            <input type="text" name="contact_person" placeholder="Contact Person *">
        </div>

        <div class="form-group">
            <input type="email" name="email" placeholder="Email *" required>
        </div>

        <div class="form-group">
            <input type="password" name="password" placeholder="Password *" required>
        </div>

        <div class="form-group">
            <input type="tel" name="mobile" placeholder="Phone *">
        </div>

        <!-- Address -->
        <div class="form-group">
            <input type="text" name="building_no" placeholder="Building/House No. *">
        </div>

        <div class="form-group">
            <input type="text" name="premises_name" placeholder="Premises Name">
        </div>

        <div class="form-group">
            <input type="text" name="landmark" placeholder="Landmark">
        </div>

        <div class="form-group">
            <input type="text" name="road_street" placeholder="Road/Street *">
        </div>

        <div class="form-group">
            <input type="text" name="pincode" placeholder="Pincode *">
        </div>

        <div class="form-group">
            <input type="text" name="district" placeholder="District *">
        </div>

        <div class="form-group">
            <input type="text" name="state" placeholder="State *">
        </div>

        <div class="form-group">
            <input type="text" name="country" value="India" readonly>
        </div>

        <!-- Business Details -->
        <div class="form-group">
            <select name="industry_type">
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
            <input type="number" name="number_of_emplooyees" min="1" placeholder="Number of Employees *">
        </div>

        <!-- Package -->
        <div class="form-group">
            <select name="software_package_plan">
                <option value="">Select Plan *</option>
                <option value="basic">Basic</option>
                <option value="standard">Standard</option>
                <option value="enterprise">Enterprise</option>
            </select>
        </div>

        <div class="form-group">
            <input type="number" name="storage_limit" min="1" placeholder="Storage (GB) *">
        </div>

        <div class="form-group">
            <input type="number" name="number_of_user_allowed" min="1" placeholder="Max Users *">
        </div>

        <div class="form-group">
            <select name="organisation_status">
                <option value="">Select Status *</option>
                <option value="Active">Active</option>
                <option value="Incative">Inactive</option>
            </select>
        </div>

        <!-- Legal -->
        <div class="form-group">
            <input type="text" name="GST_number" placeholder="GST Number">
        </div>

        <div class="form-group">
            <input type="text" name="PAN" placeholder="PAN *">
        </div>

        <div class="form-group">
            <input type="text" name="TAN" placeholder="TAN Number">
        </div>

        <div class="form-group">
            <input type="date" name="expire_date">
        </div>

        <!-- Certificates -->
        <div class="certificate-files">

            <div class="form-group">
                <label>Company Logo</label>
                <input type="file" name="companyLogo" accept="image/*">
            </div>

            <div class="form-group">
                <label>GST Certificate</label>
                <input type="file" name="GST_registration_certificate" accept=".pdf,.jpg,.jpeg,.png">
            </div>

            <div class="form-group">
                <label>MSME Certificate</label>
                <input type="file" name="MSME_udyam_certificate" accept=".pdf,.jpg,.jpeg,.png">
            </div>

        </div>
    </div>

    <div class="form-actions">
        <button type="button" class="btn btn-secondary">Cancel</button>
        <button type="submit" class="btn btn-primary">Create</button>
    </div>
</form>
