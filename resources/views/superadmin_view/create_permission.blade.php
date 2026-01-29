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

{{-- @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif --}}

@if($errors->any())
<div class="alert custom-alert-warning">
<ul>
@foreach($errors->all() as $error)
<li class="text-danger">{{ $error }}</li>

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
<style>
    /* ===== Create Permission Header (Override popup-header) ===== */
.popup-header.permission-header {
    background-color: #d9a3ad;
    color: #ffffff;
    padding: 14px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
    margin-bottom: 0; /* override popup-header margin */
}

/* Title inside permission header */
.popup-header.permission-header h4,
.popup-header.permission-header h3 {
    margin: 0;
    font-size: 16px;
    font-weight: 600;
    color: #ffffff;
}

/* Close button */
.popup-header.permission-header .popup-close {
    background: transparent;
    border: none;
    color: #ffffff;
    font-size: 22px;
    font-weight: 600;
    cursor: pointer;
}

.popup-header.permission-header .popup-close:hover {
    color: #702851;
}

/* =========================
   PERMISSION CHECKBOX STYLING
   ========================= */

/* Module heading */
.popup-body h5 {
    font-size: 15px;
    font-weight: 600;
    color: #702851;
    margin: 18px 0 10px;
    border-bottom: 1px solid #eee;
    padding-bottom: 6px;
}

/* Checkbox row */
.checkbox-group {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 8px 10px;
    border-radius: 6px;
    cursor: pointer;
    transition: background 0.2s ease;
}

/* Hover effect */
.checkbox-group:hover {
    background-color: #f8eef3;
}

/* Checkbox itself */
.checkbox-group input[type="checkbox"] {
    width: 16px;
    height: 16px;
    accent-color: #8A3366; /* modern browsers */
    cursor: pointer;
}

/* Label text */
.checkbox-group label {
    font-size: 14px;
    color: #333;
    cursor: pointer;
    margin: 0;
    user-select: none;
}

/* Checked state highlight */
.checkbox-group input[type="checkbox"]:checked + label {
    font-weight: 600;
    color: #702851;
}

/* Space between permission blocks */
.popup-body br {
    display: none;

}

.popup-body {
    background: #ffffff;
    padding: 20px;
    box-shadow: inset 0 0 0 rgba(0,0,0,0), 
                0 6px 18px rgba(0, 0, 0, 0.12);
    border-bottom-left-radius: 10px;
    border-bottom-right-radius: 10px;
}

</style>
<!-- <div class="w3-container">
    <div class="create-btn">
        <br><br>
        <button class="create-btn" onclick="openPopup()">Create Permission</button>
    </div>
</div> -->

<!-- Popup Overlay -->
<div class="popup-overlay" id="popup-overlay">
    <div class="popup-content" style="z-index:auto">
        <div class="popup-header permission-header">
            <h4 class="fw-bold">Create Permission</h4>
            <button class="popup-close" onclick="closePopup()">&times;</button>
        </div>
        <div class="popup-body">
            <form action="{{ route('insert_permission',['org_id' => $org_id, 'desig_id' => $desig_id, 'b_id' => $b_id]) }}" method="POST">
                @csrf

                <?php
                foreach($results as $result){
                    echo '<h5>'.$result->module_name.'</h5>'."<br>";
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
        // Redirect to the designation page after closing the popup
        window.location.href = "{{ route('create_designation_form') }}";
    }

    // Automatically open the popup if the flag is set
    document.addEventListener('DOMContentLoaded', function() {
        @if(isset($openPopup) && $openPopup)
            openPopup();
        @endif
    });
</script>
@endsection