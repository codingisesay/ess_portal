@extends('superadmin_view/superadmin_layout')  
@section('content')
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<style>
    body {font-family: Arial, Helvetica, sans-serif;}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
}

/* The Close Button */
.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
</style>


</head>

<?php 
$id = Auth::guard('superadmin')->user()->id;
// dd($datas);
// dd($leaveCycleDatas);
// echo $leaveCycleDatas->id;
// exit();
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('admin_end/css/admin_form.css') }}">
    <title>Create Policy Category</title>
    
</head>
<body>
    <div class="container">
        <h3>Process Leave Cycle</h3>

    @if($errors->any())
    <div class="alert custom-alert-warning">
<ul>
@foreach($errors->all() as $error)
    <li style="color: red;">{{ $error }}</li>
    
@endforeach
</ul>
    </div>
@endif

        <form action="" method="POST" enctype="multipart/form-data" class="form-container">
            @csrf
            <div class="form-group">
                <select id="category_id" name="cycle_slot_id" class="form-control">
                    <option value="" disabled selected></option>
                     
                    <option value="{{$leaveCycleDatas->id}}">{{ $leaveCycleDatas->name }}</option>
                   
                  
                    
                </select>
                <label for="category_id">Select Cycle</label>
            </div>
            <button type="button" id="myBtn" class="create-btn" style="position: relative; bottom:8px;">Process Cycle</button>
        </form>

      

    </div>

    <!-- The Modal -->
<div id="myModal" class="modal">

    <!-- Modal content -->
    <div class="modal-content">
      <span class="close">&times;</span>
      <p>Some text in the Modal..</p>
    </div>
  
  </div>

   

<script>
$(document).ready(function(){

    $('#myBtn').on('click',function(){

        var modal = document.getElementById("myModal");
        var btn = document.getElementById("myBtn");
        var span = document.getElementsByClassName("close")[0];

        var cycle_id = $('#category_id').val();

        if(cycle_id != null){

            modal.style.display = "block";
   
  
   span.onclick = function() {
     modal.style.display = "none";
   }
   
   window.onclick = function(event) {
     if (event.target == modal) {
       modal.style.display = "none";
     }
   }
   $.ajax({
    url: '/superadmin/load_leaves_active/' + cycle_id,  
    type: 'GET',               
    data: {cycle_id:cycle_id},          
    success: function(response) {
        
        console.log(response);
      
    },
    error: function(xhr, status, error) {
        
        console.log('Error: ' + error);
    }
});     
        }else{

            alert('Please Select Leave Cycle First');

        }


     

    })




});
</script>

@endsection

