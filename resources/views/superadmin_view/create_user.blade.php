@extends('superadmin_view/superadmin_layout')  <!-- Extending the layout file -->
@section('content')  <!-- Defining the content section -->
<?php 
// dd(session()->all());
// dd(Auth::guard('superadmin')->user());
// dd(Auth::user());

$id = Auth::guard('superadmin')->user()->id;
// dd($id);

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
    <h3>Create User Of Your Organisation</h3>
    <form action="{{ route('register_save') }}" method="POST">
    @csrf
<div class="w3-row-padding">
  <div class="w3-third">
    <label>Name</label>
    <input type="hidden" name="organisation_id" value="{{$id}}">
    <input class="w3-input w3-border" placeholder="Enter Employee Name" name="username">
  </div>
  <div class="w3-third">
    <label>Company Emp ID</label>
    <input class="w3-input w3-border" placeholder="Enter Employee EmpID" name="empid">
  </div>

  <div class="w3-third">
    <label>Email</label>
    <input class="w3-input w3-border" placeholder="Enter Employee Email" name="usermailid">
  </div>
</div>
<br>
<div class="w3-row-padding">
  <div class="w3-third">
    <label>Password</label>
    <input class="w3-input w3-border" id="passwordField" placeholder="Generated Password" readonly name="userpassword" value="akash@1234">
  </div>
  <div class="w3-third">
  <a href="#" onclick="generateAndDisplayPassword()">Generate Password</a>
  </div>
  <div class="w3-third">
  <button class="w3-button w3-green" type="submit">Create User</button>
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

<div class="w3-twothird">
  <h5>Users</h5>
  <table class="w3-table w3-bordered">
<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Edit</th>

</tr>
@foreach($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
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
    <script>
        function generateSecurePassword(length = 12) {
            const chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()";
            const array = new Uint32Array(length);
            window.crypto.getRandomValues(array);
            return Array.from(array, (num) => chars[num % chars.length]).join('');
        }

        function generateAndDisplayPassword() {
            const password = generateSecurePassword(12);
            document.getElementById('passwordField').value = password;
        }
    </script>


