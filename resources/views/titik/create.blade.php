@extends('layouts.app')

@section('title', 'Data Pohon')

@section('content')
<div class="titik-container">
    <!-- Nama aplikasi & tombol back -->
    <div class="header">
        <h1 class="app-name">Data Tanaman</h1>
        <a href="/maps" class="back-btn">&larr; Kembali</a>
    </div>

    <h2 class="titik-title">Tambah Titik Baru</h2>

    @if ($errors->any())
    <div class="error-box">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('titik.store') }}" method="POST" class="titik-form">
        @csrf

        <div class="form-group">
            <label>Nama Tanaman</label>
            <input type="text" name="nama_titik" placeholder="Contoh: Tanaman Jagung" required>
        </div>

        <div class="form-group">
            <label>Pilih Cara Input Koordinat:</label>
            <div class="btn-group">
                <button type="button" id="btnCoord" class="option-btn">Isi Koordinat</button>
                <button type="button" id="btnURL" class="option-btn">Gunakan URL Google Maps</button>
            </div>
        </div>

        <div id="coordInput" class="input-group hidden">
            <div class="form-group">
                <label>Latitude</label>
                <input type="text" name="latitude" placeholder="-6.914744">
            </div>
            <div class="form-group">
                <label>Longitude</label>
                <input type="text" name="longitude" placeholder="107.609810">
            </div>
        </div>

        <div id="urlInput" class="input-group hidden">
            <div class="form-group">
                <label>URL Google Maps</label>
                <input type="text" name="maps_url" placeholder="https://www.google.com/maps?q=-6.914744,107.609810">
                <small>Isi salah satu: latitude/longitude atau URL</small>
            </div>
        </div>

        <button type="submit" class="submit-btn">Simpan Data</button>
    </form>
</div>

<style>
/* Container */
.titik-container {
    max-width: 500px;
    margin: 50px auto;
    background: #f8f9fa;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* Header */
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.app-name {
    font-size: 24px;
    font-weight: bold;
    color: #333;
}

.back-btn {
    text-decoration: none;
    background: #6c757d;
    color: #fff;
    padding: 6px 12px;
    border-radius: 6px;
    transition: 0.2s;
}

.back-btn:hover {
    background: #5a6268;
}

/* Title */
.titik-title {
    text-align: center;
    margin-bottom: 25px;
    font-size: 22px;
    color: #333;
}

/* Error box */
.error-box {
    background: #ffe5e5;
    color: #b00000;
    padding: 10px 15px;
    margin-bottom: 20px;
    border-radius: 8px;
}

.error-box ul {
    margin: 0;
    padding-left: 20px;
}

/* Form */
.titik-form .form-group {
    margin-bottom: 15px;
}

.titik-form label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: #555;
}

.titik-form input[type="text"] {
    width: 100%;
    padding: 8px 12px;
    border-radius: 6px;
    border: 1px solid #ccc;
    font-size: 14px;
}

/* Button group */
.btn-group {
    display: flex;
    gap: 10px;
}

.option-btn {
    flex: 1;
    padding: 8px 12px;
    background: #007bff;
    color: #fff;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: 0.2s;
    font-weight: bold;
}

.option-btn:hover {
    background: #0056b3;
}

/* Hidden input */
.hidden {
    display: none;
}

/* Submit button */
.submit-btn {
    width: 100%;
    padding: 10px;
    background: #28a745;
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 16px;
    cursor: pointer;
    transition: 0.2s;
}

.submit-btn:hover {
    background: #218838;
}

/* Small text */
small {
    display: block;
    margin-top: 3px;
    color: #666;
    font-size: 12px;
}
</style>

<script>
const btnCoord = document.getElementById('btnCoord');
const btnURL = document.getElementById('btnURL');
const coordInput = document.getElementById('coordInput');
const urlInput = document.getElementById('urlInput');

btnCoord.addEventListener('click', () => {
    coordInput.classList.remove('hidden');
    urlInput.classList.add('hidden');
});

btnURL.addEventListener('click', () => {
    urlInput.classList.remove('hidden');
    coordInput.classList.add('hidden');
});
</script>
@endsection
