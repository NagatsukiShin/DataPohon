<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
</head>
<body>
<h2>Edit User</h2>

@if ($errors->any())
    <div style="color:red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('users.update', $user->id) }}" method="POST">
    @csrf
    <label>Nama:</label>
    <input type="text" name="name" value="{{ old('name', $user->name) }}" required><br><br>

    <label>Email:</label>
    <input type="email" name="email" value="{{ old('email', $user->email) }}" required><br><br>

    <label>Role:</label>
    {{-- <select name="role" required>
        <option value="user" {{ old('role', $user->role)=='user' ? 'selected' : '' }}>User</option>
        <option value="petugas" {{ old('role', $user->role)=='petugas' ? 'selected' : '' }}>Petugas</option>
    </select> --}}
    <input type="text" name="role" value="{{ old('email', $user->role) }}" disabled>
    <br><br>

    <button type="submit">Update</button>
</form>

<p><a href="{{ route('users.index') }}">Kembali ke daftar user</a></p>
</body>
</html>
