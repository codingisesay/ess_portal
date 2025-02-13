<h1>User Login</h1>
<form method="POST" action="{{ route('user.login') }}">
    @csrf
    <input type="email" name="email" placeholder="Email" value="akash.tech.0394@gmail.com" required>
    <input type="password" name="password" placeholder="Password" value="akash@1234" required>
        <!-- Display error message for 'email' -->
    @error('email')
            <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <button type="submit">Login as User</button>
</form>

