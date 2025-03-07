@extends('superadmin_view/superadmin_layout')  <!-- Extending the layout file -->
@section('content')  <!-- Defining the content section -->

<?php 
$id = Auth::guard('superadmin')->user()->id;
// dd($results);
// dd($features);
$permis = [];
// dd($permissions);
foreach($permissions as $per){

array_push($permis, $per->feature_id);

}
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

@if($errors->any())
<div class="alert custom-alert-warning">
<ul>
@foreach($errors->all() as $error)
<li style="color: red;">{{ $error }}</li>

@endforeach
</ul>
</div>
@endif

<!DOCTYPE html>
<html>
<head>
<title>Template</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ asset('admin_end/css/admin_form.css') }}">

<div class="w3-container">
    <div class="create-btn">
        <br><br>
        <button class="create-btn" onclick="openPopup()">Create Permission</button>
    </div>
</div>

<!-- Popup Overlay -->
<div class="popup-overlay" id="popup-overlay">
    <div class="popup-content">
        <div class="popup-header">
            <h3>Create Permission</h3>
            <button class="popup-close" onclick="closePopup()">&times;</button>
        </div>
        <div class="popup-body">
            <form action="{{ route('insert_permission',['org_id' => $org_id, 'desig_id' => $desig_id, 'b_id' => $b_id]) }}" method="POST">
                @csrf

                <?php
                foreach($results as $result){
                    echo '<h3>'.$result->module_name.'</h3>'."<br>";
                    foreach($features as $feature){
                        if($result->module_name == $feature->module_name){?>
                            <div class="checkbox-group">
                                <input type="checkbox" name="features[]" value="<?php echo $feature->feature_id ?>" <?php echo in_array($feature->feature_id, $permis) ? 'checked' : '';?> >
                                <label><?php echo $feature->name; ?></label>
                            </div>
                        <?php
                        }
                    }
                    echo "<br>";
                }
                ?>
                <div class="popup-footer">
                    <button type="submit">Create Permission</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openPopup() {
        document.getElementById('popup-overlay').classList.add('active');
    }

    function closePopup() {
        document.getElementById('popup-overlay').classList.remove('active');
    }
</script>
@endsection