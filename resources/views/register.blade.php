<!DOCTYPE html>
<html>
<head>
    <title>Add New User</title>
</head>
<body>
    <h2>Tambah User Baru</h2>
    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ url('/register') }}">
        @csrf
        <label>Name:</label>
        <input type="text" name="name" value="" required><br><br>

        <label>Email:</label>
        <input type="email" name="email" value="" required><br><br>

        {{-- <label>Role</label> --}}
        <input type="hidden" name="role" value="user" required>
        {{-- <select name="role" required>
            <option value="">--Pilih Role--</option>
            <option value="{{ old('role')=='user' ? 'user' : '' }}">User</option>
            <option value="{{ old('role')=='petugas' ? 'petugas' : '' }}">Petugas</option>
            <option value="{{ old('role')=='admin' ? 'admin' : '' }}">Admin</option>
        </select> --}}
        {{-- <br><br> --}}

        <label>Password:</label>
        <input type="password" name="password" required><br><br>

        <label>Confirm Password:</label>
        <input type="password" name="password_confirmation" required><br><br>

        <button type="submit">Register</button>
    </form>
    <p>
        {{-- @if(isset($newUser))
            <h3>Data Baru:</h3>
            <p>Nama: {{ $newUser->name }}</p>
            <p>Email: {{ $newUser->email }}</p>
            <p>Role: {{ $newUser->role }}</p>
        @endif --}}
    </p>
    {{-- <p>Sudah punya akun? <a href="{{ url('/login') }}">Login</a></p> --}}
</body>
</html>
