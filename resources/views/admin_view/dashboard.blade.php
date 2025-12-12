@extends('layouts.app')

@section('content')

<div class="container">

    <h3>{{ isset($organisation) ? 'Edit Organisation' : 'Create Organisation' }}</h3>

    <form method="POST" action="{{ isset($organisation) ? route('organisation.update', $organisation->id) : route('organisation.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="row">

            <div class="col-md-6 mb-3">
                <label>Company Name</label>
                <input type="text" name="name" class="form-control"
                       value="{{ $organisation->name ?? '' }}" required>
            </div>

            <div class="col-md-6 mb-3">
                <label>Client Name</label>
                <input type="text" name="client_name" class="form-control"
                       value="{{ $organisation->client_name ?? '' }}">
            </div>

            <div class="col-md-6 mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control"
                       value="{{ $organisation->email ?? '' }}" required>
            </div>

            <div class="col-md-6 mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
                @if(isset($organisation))
                    <small class="text-muted">Leave empty to keep existing password</small>
                @endif
            </div>

            <div class="col-md-6 mb-3">
                <label>Contact Person</label>
                <input type="text" name="contact_person" class="form-control"
                       value="{{ $organisation->contact_person ?? '' }}">
            </div>

            <div class="col-md-6 mb-3">
                <label>Mobile</label>
                <input type="text" name="mobile" class="form-control"
                       value="{{ $organisation->mobile ?? '' }}">
            </div>

            <div class="col-md-3 mb-3">
                <label>Building No</label>
                <input type="text" name="building_no" class="form-control"
                       value="{{ $organisation->building_no ?? '' }}">
            </div>

            <div class="col-md-3 mb-3">
                <label>Premises Name</label>
                <input type="text" name="premises_name" class="form-control"
                       value="{{ $organisation->premises_name ?? '' }}">
            </div>

            <div class="col-md-3 mb-3">
                <label>Landmark</label>
                <input type="text" name="landmark" class="form-control"
                       value="{{ $organisation->landmark ?? '' }}">
            </div>

            <div class="col-md-3 mb-3">
                <label>Road / Street</label>
                <input type="text" name="road_street" class="form-control"
                       value="{{ $organisation->road_street ?? '' }}">
            </div>

            <div class="col-md-3 mb-3">
                <label>Pincode</label>
                <input type="text" name="pincode" class="form-control"
                       value="{{ $organisation->pincode ?? '' }}">
            </div>

            <div class="col-md-3 mb-3">
                <label>District</label>
                <input type="text" name="district" class="form-control"
                       value="{{ $organisation->district ?? '' }}">
            </div>

            <div class="col-md-3 mb-3">
                <label>State</label>
                <input type="text" name="state" class="form-control"
                       value="{{ $organisation->state ?? '' }}">
            </div>

            <div class="col-md-3 mb-3">
                <label>Country</label>
                <input type="text" name="country" class="form-control"
                       value="{{ $organisation->country ?? 'India' }}">
            </div>

            <div class="col-md-6 mb-3">
                <label>GST Number</label>
                <input type="text" name="GST_number" class="form-control"
                       value="{{ $organisation->GST_number ?? '' }}">
            </div>

            <div class="col-md-6 mb-3">
                <label>Industry Type</label>
                <input type="text" name="industry_type" class="form-control"
                       value="{{ $organisation->industry_type ?? '' }}">
            </div>

            <div class="col-md-4 mb-3">
                <label>No. of Employees</label>
                <input type="number" name="number_of_emplooyees" class="form-control"
                       value="{{ $organisation->number_of_emplooyees ?? '' }}">
            </div>

            <div class="col-md-4 mb-3">
                <label>Software Package Plan</label>
                <input type="text" name="software_package_plan" class="form-control"
                       value="{{ $organisation->software_package_plan ?? '' }}">
            </div>

            <div class="col-md-4 mb-3">
                <label>Storage Limit</label>
                <input type="text" name="storage_limit" class="form-control"
                       value="{{ $organisation->storage_limit ?? '' }}">
            </div>

            <div class="col-md-6 mb-3">
                <label>Users Allowed</label>
                <input type="number" name="number_of_user_allowed" class="form-control"
                       value="{{ $organisation->number_of_user_allowed ?? '' }}">
            </div>

            <div class="col-md-3 mb-3">
                <label>TAN</label>
                <input type="text" name="TAN" class="form-control"
                       value="{{ $organisation->TAN ?? '' }}">
            </div>

            <div class="col-md-3 mb-3">
                <label>PAN</label>
                <input type="text" name="PAN" class="form-control"
                       value="{{ $organisation->PAN ?? '' }}">
            </div>

            <div class="col-md-4 mb-3">
                <label>Expire Date</label>
                <input type="date" name="expire_date" class="form-control"
                       value="{{ $organisation->expire_date ?? '' }}">
            </div>

            <div class="col-md-4 mb-3">
                <label>Status</label>
                <select name="organisation_status" class="form-control">
                    <option value="Active" {{ isset($organisation) && $organisation->organisation_status == 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="Inactive" {{ isset($organisation) && $organisation->organisation_status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label>MSME Certificate</label>
                <input type="file" name="MSME_udyam_certificate" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label>GST Registration Certificate</label>
                <input type="file" name="GST_registration_certificate" class="form-control">
            </div>

        </div>

        <button class="btn btn-primary">{{ isset($organisation) ? 'Update' : 'Save' }}</button>

    </form>

</div>

@endsection
