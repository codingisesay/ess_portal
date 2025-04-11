@extends('superadmin_view/superadmin_layout')  <!-- Extending the layout file -->
@section('content')  <!-- Defining the content section -->
<link rel="stylesheet" href="{{ asset('errors/error.css') }}">

<?php 
$id = Auth::guard('superadmin')->user()->id;
?>

 
<link rel="stylesheet" href="{{ asset('admin_end/css/admin_form.css') }}">  
<div class="container">
  <h3>Dashboard</h2>
  <div class="text-center">
  <img id="sidebar-icon"  src="{{ asset('admin_end/images/dummy_dash.png') }}" />
</div>
</div>
 
@endsection


