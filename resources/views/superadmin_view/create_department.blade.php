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
        <h3>Create Department For Your Organisation</h3>
        <form method="POST" action="{{ route('insert_department') }}">
        @csrf
    <div class="w3-row-padding">
      <div class="w3-third">
        <label>Department Name</label>
        <input type="hidden" name="organisation_id" value="{{$id}}">
        <input class="w3-input w3-border" type="text" name="department_name" placeholder="Enter the Department Name">
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
<br>
<br>
<h5>Organisation Departments</h5>
<table class="w3-table w3-bordered">

    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Edit</th>
    </tr>

    @foreach($departments as $department)
    <tr>
        <td>{{ $department->id }}</td>
        <td>{{ $department->name }}</td>
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

