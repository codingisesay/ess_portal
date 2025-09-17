<?php 
echo $id = Auth::guard('web')->user()->id;

?>

<h1>Welcome User</h1>
<form method="POST" action="{{ route('user.logout') }}">
    @csrf
    <button type="submit">Logout</button>
</form>