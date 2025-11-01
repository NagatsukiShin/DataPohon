<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Peta Titik Panen</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body { margin:0; font-family: Arial, sans-serif; background:#f4f4f4; }
        nav {
            background-color: #1e88e5;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 25px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        nav h2 { margin: 0; font-size: 20px; }
        nav ul { list-style: none; margin: 0; padding: 0; display: flex; }
        nav ul li { margin-left: 20px; }
        nav ul li a { color: white; text-decoration: none; font-weight: bold; }
        nav ul li a:hover { text-decoration: underline; }

        #map { height: 500px; width: 100%; margin-top:10px; }

        #detail {
            display: none;
            width: 90%;
            margin: 20px auto;
            background: white;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            position: relative;
        }
        #detail h3 { margin-top:0; }
        #detail label { font-weight: bold; display:block; margin-top:5px; }
        #closeDetail {
            position:absolute; top:10px; right:10px;
            background:red; color:white; border:none; border-radius:5px;
            padding:4px 8px; cursor:pointer;
        }
        #editBtn, #saveBtn, #cancelBtn {
            margin-top:10px; margin-right:10px;
            padding:6px 10px; border:none; border-radius:5px;
            cursor:pointer;
        }
        #editBtn { background:#1e88e5; color:white; }
        #saveBtn { background:green; color:white; }
        #cancelBtn { background:gray; color:white; }

        table {
            border-collapse: collapse; width: 90%; margin: 20px auto; background:white;
            border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        th, td { padding:10px; border-bottom:1px solid #ddd; text-align:left; }
        th { background:#1e88e5; color:white; }
        h3 { margin-left: 5%; }
        input, select {
            width: 100%;
            padding:5px;
            border-radius:5px;
            border:1px solid #ccc;
        }
        
    </style>
</head>
<body>
    @php
        $name = auth()->user()->name;
        // echo $name;
    @endphp
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

    {{-- Peta --}}
    <div id="map"></div>

    {{-- Detail Titik --}}
    <div id="detail">
        <button id="closeDetail">X</button>
        <h3>Detail Titik</h3>
        <div id="detailContent"></div>
    </div>

    {{-- Daftar Titik Terbaru --}}
    <h3>Titik yang Baru Ditambahkan</h3>
    <table>
        <thead>
            <tr>
                <th>Nama Titik</th>
                <th>Hasil</th>
                <th>Pemupukan</th>
                <th>Waktu Panen</th>
                <th>Dibuat Pada</th>
            </tr>
        </thead>
        <tbody>
            @foreach($titikBaru as $t)
                <tr>
                    <td>{{ $t->nama_titik }}</td>
                    <td>{{ $t->hasil ?? '-' }} Kg</td>
                    <td>{{ $t->terakhir_pemupukan }}</td>
                    <td>{{ $t->waktu_panen ?? '-' }}</td>
                    <td>{{ $t->created_at->format('d M Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Daftar Titik yang Baru Diperbarui --}}
    <h3>Titik yang Baru Diperbarui</h3>
    <table>
        <thead>
            <tr>
                <th>Nama Titik</th>
                <th>Hasil</th>
                <th>Pemupukan</th>
                <th>Waktu Panen</th>
                <th>Terakhir Diupdate</th>
                <th>edited by</th>
            </tr>
        </thead>
        <tbody>
            @foreach($titikUpdate as $t)
                <tr>
                    <td>{{ $t->nama_titik }}</td>
                    <td>{{ $t->hasil ?? '-' }} Kg</td>
                    <td>{{ $t->terakhir_pemupukan ?? '-' }}</td>
                    <td>{{ $t->waktu_panen ?? '-' }}</td>
                    <td>{{ $t->updated_at->format('d M Y H:i') }}</td>
                    <td>{{ $t->edited_by }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    const map = L.map('map').setView([-6.914744, 107.609810], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{maxZoom:19}).addTo(map);

    const csrf = document.querySelector('meta[name="csrf-token"]').content;
    const titikData = @json($titik);

    const detailDiv = document.getElementById('detail');
    const detailContent = document.getElementById('detailContent');
    const closeDetail = document.getElementById('closeDetail');

    closeDetail.addEventListener('click', () => {
        detailDiv.style.display = 'none';
        detailContent.innerHTML = '';
    });

    // ✅ fungsi format waktu ke WIB (+7)
    function formatWIB(dateString) {
        if (!dateString) return '-';
        const date = new Date(dateString);
        const options = { timeZone: 'Asia/Jakarta', hour12: false };
        return date.toLocaleString('id-ID', options) + ' WIB';
    }

    // ✅ fungsi render detail (tanpa jam di tanggal)
    function renderDetail(t) {
        detailDiv.style.display = 'block';
        detailContent.innerHTML = `
            <label>Nama Titik:</label> ${t.nama_titik}<br>
            <label>Hasil (kg):</label> ${t.hasil ?? '-'}<br>
            <label>Waktu Panen:</label> ${t.waktu_panen ? t.waktu_panen.substring(0,10) : '-'}<br>
            <label>Estimasi Panen:</label> ${t.estimasi_panen ?? '-'}<br>
            <label>Terakhir Pemupukan:</label> ${t.terakhir_pemupukan ? t.terakhir_pemupukan.substring(0,10) : '-'}<br>
            <label>Jenis Pupuk:</label> ${t.jenis_pupuk ?? '-'}<br>
            <label>Jumlah Pupuk (kg):</label> ${t.jumlah_pupuk ?? '-'}<br>
            <label><i>Terakhir Diperbarui:</i></label> ${formatWIB(t.updated_at)}<br>
            <button id="editBtn">Edit</button>`;
        document.getElementById('editBtn').addEventListener('click', () => renderEditForm(t));
    }

    function renderEditForm(t) {
        detailContent.innerHTML = `
            <label>Nama Titik:</label><input id="nama_titik" value="${t.nama_titik}">
            <label>Hasil (kg):</label><input id="hasil" type="number" value="${t.hasil ?? ''}">
            <label>Waktu Panen:</label><input id="waktu_panen" type="date" value="${t.waktu_panen ? t.waktu_panen.substring(0,10) : ''}">
            <label>Estimasi Panen:</label><input id="estimasi_panen" type="month" value="${t.estimasi_panen ?? ''}">
            <label>Terakhir Pemupukan:</label><input id="terakhir_pemupukan" type="date" value="${t.terakhir_pemupukan ? t.terakhir_pemupukan.substring(0,10) : ''}">
            <label>Jenis Pupuk:</label><input id="jenis_pupuk" value="${t.jenis_pupuk ?? ''}">
            <label>Jumlah Pupuk (kg):</label><input id="jumlah_pupuk" type="number" value="${t.jumlah_pupuk ?? ''}">
            <label>Yang Update:</label><input id="edited_by" type="text" value="{{ $name }}" readonly>
            <button id="saveBtn">Simpan</button>
            <button id="cancelBtn">Batal</button>
        `;
        document.getElementById('cancelBtn').addEventListener('click', () => renderDetail(t));

        document.getElementById('saveBtn').addEventListener('click', async () => {
            const updated = {
                nama_titik: document.getElementById('nama_titik').value,
                hasil: document.getElementById('hasil').value,
                waktu_panen: document.getElementById('waktu_panen').value,
                estimasi_panen: document.getElementById('estimasi_panen').value,
                terakhir_pemupukan: document.getElementById('terakhir_pemupukan').value,
                jenis_pupuk: document.getElementById('jenis_pupuk').value,
                jumlah_pupuk: document.getElementById('jumlah_pupuk').value,
                edited_by: document.getElementById('edited_by').value,
            };

            const res = await fetch(`/titik/${t.id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf
                },
                body: JSON.stringify(updated)
            });

            if (res.ok) {
                const newData = await res.json();
                Object.assign(t, newData);
                renderDetail(t); // tampilkan hasil update
            } else {
                alert('Gagal memperbarui data titik!');
            }
        });
    }

    titikData.forEach(t => {
        const marker = L.circleMarker([t.latitude, t.longitude], {
            radius:8, color:'blue', fillColor:'#3399ff', fillOpacity:0.7
        }).addTo(map);

        marker.on('click', () => {
            renderDetail(t);
            window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' });
        });
    });
</script>
</body>
</html>
