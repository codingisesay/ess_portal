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
        <h3>Create Branches For Your Organisation</h3>
        <form method="POST" action="{{ route('insert_designation') }}">
        @csrf
    <div class="w3-row-padding">
      <div class="w3-third">
        <label>Name</label>
        <input class="w3-input w3-border" placeholder="Enter Branch Name" name="username">
      </div>
      <div class="w3-third">
        <label>Mobile</label>
        <input class="w3-input w3-border" placeholder="Enter Branch Mobile" name="empid">
      </div>
    
      <div class="w3-third">
        <label>Branch Email</label>
        <input class="w3-input w3-border" placeholder="Enter Branch Email" name="usermailid">
      </div>
    </div>
    <br>
    <div class="w3-row-padding">
      <div class="w3-third">
        <label>Building No</label>
        <input class="w3-input w3-border" id="passwordField" placeholder="Building No" readonly name="userpassword" value="akash@1234">
      </div>
      <div class="w3-third">
        <label>Premises Name</label>
        <input class="w3-input w3-border" type="text" name="name" placeholder="Branch Premises Name">
      </div>
      <div class="w3-third">
        <label>Landmark</label>
        <input class="w3-input w3-border" type="text" name="name" placeholder="Branch Landmark">
      </div>
    </div>
    <br>
      <div class="w3-row-padding">
        <div class="w3-third">
            <label>Road Street</label>
            <input class="w3-input w3-border" type="text" name="name" placeholder="Branch Road Street">
        </div>
        <div class="w3-third">
            <label>pincode</label>
            <input class="w3-input w3-border" type="text" name="name" placeholder="Branch Pincode">
        </div>
        <div class="w3-third">
            <label>district</label>
            <input  class="w3-input w3-border" type="text" name="name" placeholder="Branch District">
        </div>
    </div>
    <br>
        <div class="w3-row-padding">
            <div class="w3-third">
             <label>State</label>
             <input class="w3-input w3-border" type="text" name="name" placeholder="Branch State">
            </div>
            <div class="w3-third">
                <label>Country</label>
                <input class="w3-input w3-border" type="text" name="name" placeholder="Branch Country">
            </div>
            <div class="w3-third">
               <br>
                <button class="w3-button w3-green" type="submit">Create Branch</button>
            </div>
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
      <h5>Branch</h5>
      <table class="w3-table w3-bordered">
    <tr>
        <th> Name</th>
        <th> Mobile</th>
        <th> E-mail</th>
        <th>Edit</th>
    
    </tr>

    @foreach($branchs as $branch)
    <tr>
        <td>{{ $branch->name }}</td>
        <td>{{ $branch->mobile }}</td>
        <td>{{ $branch->branch_email }}</td>
        <td><button class="w3-button w3-green">Edit</button></td>
    
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
