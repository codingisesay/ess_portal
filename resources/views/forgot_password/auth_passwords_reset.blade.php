<form method="POST" action="{{ route('password.update') }}">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <input type="hidden" name="email" value="{{ $email }}">

    <div>
        <label for="password">New Password</label>
        <input type="password" name="password" required>
    </div>

    <div>
        <label for="password_confirmation">Confirm Password</label>
        <input type="password" name="password_confirmation" required>
    </div>

    @if ($errors->any())
        <div>
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <button type="submit">Reset Password</button>
</form>
