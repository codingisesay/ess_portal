@extends('superadmin_view/superadmin_layout')  <!-- Extending the layout file -->
@section('content')  <!-- Defining the content section -->

<?php 

$id = Auth::guard('superadmin')->user()->id;


?>
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<div class="w3-container">


    <div class="w3-main" style="margin-left:300px;margin-top:43px;">
        <br><br>
        <h3>Create Designation For Your Organisation</h3>
        <form method="POST" action="{{ route('insert_designation') }}">
            @csrf
    <div class="w3-row-padding">
      <div class="w3-third">
        <label>Department Name</label>
        <input type="hidden" name="organisation_id" value="{{$id}}">
        <label>Department</label>
                <select id="country" name="department_id" class="w3-input w3-border">
                    <option value="">Select Department</option>
                    @foreach ($departments as $department)
                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                    @endforeach
                </select>
        {{-- <input class="w3-input w3-border" placeholder="Enter Branch Name" name="username"> --}}
      </div>
      <div class="w3-third">
        <label>Branch Name</label>
                <select id="country" name="branch_id" class="w3-input w3-border">
                    <option value="">Select Branch</option>
                    @foreach ($branches as $branche)
                        <option value="{{ $branche->id }}">{{ $branche->name }}</option>
                    @endforeach
                </select>
        {{-- <input class="w3-input w3-border" placeholder="Enter Branch Mobile" name="empid"> --}}
      </div>
    
      <div class="w3-third">
        <label>Designation Name</label>
        <input class="w3-input w3-border" type="text" name="name" placeholder="Select Department first">
        {{-- <input class="w3-input w3-border" placeholder="Enter Branch Email" name="usermailid"> --}}
      </div>
    </div>
    <br>
    <div class="w3-row-padding">
      <div class="w3-third">
        <button class="w3-button w3-green" type="submit">Create Designation</button>
    </div>
    
    </form>
      
    
                    @if($errors->any())
                    <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    </ul>
                    @endif
    
    {{-- <div class="w3-twothird"> --}}
        <br> <br>  <br>
      <h5>Branch</h5>
      <table class="w3-table w3-bordered">
    <tr>
        <th>Department Name</th>
        <th>Branch Name</th>
        <th>Designation Name</th>
        <th>Edit Permissons</th>
    
    </tr>

    @foreach($results as $result)
    <tr>
        <td>{{ $result->department_name }}</td>
        <td>{{ $result->branch_name }}</td>
        <td>{{ $result->designation_name }}</td>
        <!-- <td><button>Permission</button></td> -->
        <td>
            <!-- Create a form for each row to submit data -->
            <form action="{{ route('create_permission_form', ['org_id' => $id, 'desig_id' => $result->designation_id, 'b_id' => $result->branch_id]) }}">
                @csrf
                <button class="w3-button w3-green" type="submit">Permission</button>
            </form>
        </td>
    </tr>
@endforeach
     
    
    </table>
    </div>
    </div>
    </div>
    </div>
    <hr>
    
    </div>

@endsection



