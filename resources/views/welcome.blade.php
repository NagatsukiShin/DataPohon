<!DOCTYPE html>
<html>
<head>
    <title>Daftar User</title>
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 8px;
        }
        nav {
            background-color: #1e88e5;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 25px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        nav h2 {
            margin: 0;
            font-size: 20px;
        }
        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }
        nav ul li {
            margin-left: 20px;
        }
        nav ul li a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }
        nav ul li a:hover {
            text-decoration: underline;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    
    @php
        $regist = "<li><a href='register' class='text-blue-500 hover:underline'>Tambah User</a></li>";
        // $buat = "<li><a href='{{ route('titik.create') }}' class='text-blue-500 hover:underline'>Tambah Titik</a></li>"
    @endphp
    <nav>
        <h2>Data Pohon</h2>
        <ul>
            {{-- <li><a href="/">Beranda</a></li> --}}
            <li><a href="/maps">Peta</a></li>
            <li>
                @if (auth()->user()->role=='petugas'||auth()->user()->role=='admin')
                    <a href="{{ route('titik.create') }}" class='text-blue-500 hover:underline'>Tambah Pohon</a>
                @endif
            </li>
            @if (auth()->user()->role=='petugas'||auth()->user()->role=='admin')
                @php
                    // echo $buat;
                    echo $regist;
                @endphp
            @endif
            <li><a href="/users">Data User</a></li>
            <li>
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="text-red-500 hover:underline" style="background-color: #1e88e5; border: none; color: white; cursor: pointer;">
                        <i class="fa-solid fa-right-from-bracket"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
    </nav>
    {{-- @if (auth()->id() == False)
        @php
            return view('/login');
        @endphp
    @endif --}}
    @php
        $user_id = auth()->id(); // akan mengembalikan ID user yang login
        // echo "$user_id";
    @endphp
    <h1>
        <h1>Selamat datang {{ auth()->user()->name }}!</h1>
        @foreach ($users as $user)
            {{-- {{ $user->role }} --}}
        @endforeach
    </h1>
    {{-- @php
        if (auth()->user()->role == 'user') {
            echo "user";
        } elseif (auth()->user()->role == 'admin') {
            echo "admin";
        } elseif (auth()->user()->role == 'petugas') {
            echo "petugas";
        } else {
            echo "tidak ada role";
        }
    @endphp --}}
    {{-- <h2>Daftar User</h2> --}}
    {{-- <h3><a href="/maps">Denah Pohon</a></h3> --}}
            {{-- @if (auth()->user()->role=='petugas'||auth()->user()->role=='admin')
                @php
                    echo $regist;
                @endphp
                
                <br><br>    
            @endif --}}
        <table style="width: 100%">
        <thead>
            <tr>
                {{-- <th>ID</th> --}}
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Dibuat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        @if (auth()->user()->role=='petugas'||auth()->user()->role=='admin')
            @foreach ($users->sortBy('name') as $user)
            <tr>
                {{-- <td>{{ $user->id }}</td> --}}
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role }}</td>
                <td>{{ $user->created_at }}</td>
                <td>
                    @if (auth()->user()->role == 'admin')
                            <button style="display:inline-block"><a href="{{ route('users.edit', $user->id) }}">Edit</a></button>
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                            </form>
                           
                    @elseif (auth()->user()->role == 'petugas')
                        @if ($user->role == 'petugas')
                            <button style="display:inline-block"><a href="{{ route('users.edit', $user->id) }}">Edit</a></button>
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                            </form>
                        @endif
                    @endif
                </td>
            </tr>
            @endforeach
            @elseif (auth()->user()->role=='user')
                <tr>
                    <td>{{ auth()->user()->name }}</td>
                    <td>{{ auth()->user()->email }}</td>
                    <td>{{ auth()->user()->role }}</td>
                    <td>{{ auth()->user()->created_at }}</td>
                    <td>
                        <button style="display:inline-block"><a href="{{ route('users.edit', $user->id) }}">Edit</a></button>
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                            </form>
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
    <br><br>
    <br><br>
    {{-- <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form> --}}
</body>
</html>
