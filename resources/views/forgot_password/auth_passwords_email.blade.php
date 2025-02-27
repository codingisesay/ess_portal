<form action="{{ route('password.email') }}" method="POST">
    @csrf
    <input type="email" name="email">
    <button type="submit">Submit</button>
</form>