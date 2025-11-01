<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Titik Panen</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <style>
        body { font-family: Arial, sans-serif; margin:0; background:#f4f4f4; }
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
        nav ul { list-style: none; display: flex; margin:0; padding:0; }
        nav ul li { margin-left:20px; }
        nav ul li a { color: white; text-decoration:none; font-weight:bold; }
        nav ul li a:hover { text-decoration: underline; }
        .container {
            max-width: 800px;
            margin: 30px auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            padding: 20px;
        }
        .detail label { font-weight: bold; display:block; margin-top:10px; }
        #map { height: 350px; border-radius:10px; margin-top:15px; }
        .btn-back {
            background:#1e88e5; color:white; border:none; padding:8px 15px;
            border-radius:5px; text-decoration:none; display:inline-block;
            margin-bottom:10px;
        }
        .btn-back:hover { background:#1565c0; }
    </style>
</head>
<body>

<nav>
    <h2>🌾 Sistem Titik Panen</h2>
    <ul>
        <li><a href="/maps">Kembali ke Peta</a></li>
    </ul>
</nav>

<div class="container">
    <a href="/maps" class="btn-back">← Kembali</a>
    <h3>Detail Titik: {{ $titik->nama_titik }}</h3>

    <div class="detail">
        <label>Hasil (kg):</label>
        <div>{{ $titik->hasil ?? '-' }}</div>

        <label>Waktu Panen:</label>
        <div>{{ $titik->waktu_panen ?? '-' }}</div>

        <label>Estimasi Panen:</label>
        <div>{{ $titik->estimasi_panen ?? '-' }}</div>

        <label>Terakhir Pemupukan:</label>
        <div>{{ $titik->terakhir_pemupukan ?? '-' }}</div>

        <label>Jenis Pupuk:</label>
        <div>{{ $titik->jenis_pupuk ?? '-' }}</div>

        <label>Jumlah Pupuk (kg):</label>
        <div>{{ $titik->jumlah_pupuk ?? '-' }}</div>
    </div>

    <div id="map"></div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    const map = L.map('map').setView([{{ $titik->latitude }}, {{ $titik->longitude }}], 15);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{maxZoom:19}).addTo(map);
    L.circleMarker([{{ $titik->latitude }}, {{ $titik->longitude }}], {
        radius:8,color:'blue',fillColor:'#3399ff',fillOpacity:0.7
    }).addTo(map).bindPopup("{{ $titik->nama_titik }}").openPopup();
</script>
</body>
</html>
