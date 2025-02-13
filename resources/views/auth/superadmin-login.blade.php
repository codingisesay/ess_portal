


<!DOCTYPE html>
<html>
<title>Organisation Login</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<body>
<br><br><br><br>
<div class="w3-card-4" style="width:40%; margin:auto; padding:auto;">
  <div class="w3-container w3-brown">
    <h2>Organisation Login</h2>
  </div>
  <form class="w3-container" method="POST" action="{{ route('superadmin.login') }}">
    @csrf
    <p>      
    <label class="w3-text-brown"><b>Username</b></label>
    <input class="w3-input w3-border w3-sand" name="email" placeholder="Email" value="info@siltech.co.in" required></p>
    <p>      
    <label class="w3-text-brown"><b>Password</b></label>
    <input class="w3-input w3-border w3-sand" type="password" name="password" placeholder="Password" value="akash@1234" required></p>
    <p>
    @if($errors->any())
                <ul>
                 @foreach ($errors->all() as $error)
                     <li>{{$error}}</li>
                 @endforeach
                </ul>
                @endif
    <button type="submit" class="w3-btn w3-brown">Login</button></p>
  </form>
</div>

</body>
</html> 
