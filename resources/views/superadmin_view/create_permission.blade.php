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

<form action="{{ route('insert_permission',['org_id' => $org_id, 'desig_id' => $desig_id, 'b_id' => $b_id]) }}" method="POST">
    @csrf
<?php
foreach($results as $result){
    echo '<h3>'.$result->module_name.'</h3>'."<br>";
    foreach($features as $feature){

            if($result->module_name == $feature->module_name){?>
            
            <input class="w3-check" type="checkbox" name="features[]" value="<?php echo $feature->feature_id ?>"><?php echo $feature->name; ?>
            
            <?php

            }
            
        }
        echo "<br><br>";

}

?>
    <button class="w3-button w3-green" type="submit">Create Permission</button>
</form>
    </div>
</div>
@endsection