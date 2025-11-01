<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Titik;
use Carbon\Carbon;

class TitikController extends Controller
{
    public function index()
    {
        $titik = Titik::all();
        $titikBaru = Titik::orderBy('created_at', 'desc')->take(5)->get();
        $titikUpdate = Titik::orderBy('updated_at', 'desc')->take(5)->get();

        return view('maps', compact('titik', 'titikBaru', 'titikUpdate'));
    }

    public function create()
    {
        return view('titik.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_titik' => 'required|string|max:255',
        ]);

        $latitude = $request->latitude;
        $longitude = $request->longitude;

        // Jika user memasukkan URL Google Maps
        if ($request->maps_url) {
            $url = $request->maps_url;

            // Format 1: @lat,long
            if (preg_match('/@(-?\d+\.\d+),(-?\d+\.\d+)/', $url, $matches)) {
                $latitude = $matches[1];
                $longitude = $matches[2];
            } 
            // Format 2: ?q=lat,long
            elseif (preg_match('/[?&]q=(-?\d+\.\d+),(-?\d+\.\d+)/', $url, $matches)) {
                $latitude = $matches[1];
                $longitude = $matches[2];
            } 
            // Format lain / short link → error
            else {
                return back()->withErrors([
                    'maps_url' => 'URL Google Maps tidak valid. Gunakan format: https://www.google.com/maps?q=lat,long atau https://www.google.com/maps/@lat,long'
                ]);
            }
        }

        if (!$latitude || !$longitude) {
            return back()->withErrors(['latitude' => 'Latitude dan longitude harus diisi atau URL valid.']);
        }

        Titik::create([
            'nama_titik' => $request->nama_titik,
            'latitude' => $latitude,
            'longitude' => $longitude,
        ]);

        return redirect('/maps')->with('success', 'Titik berhasil ditambahkan!');
    }


    public function update(Request $request, $id)
    {
        // Set timezone ke Asia/Jakarta (+7)
        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');

        // $titik->update([
        //     'updated_at' => now(), // otomatis Asia/Jakarta
        // ]);

        // date_default_timezone_set('Asia/Jakarta');

        $titik = Titik::findOrFail($id);

        $titik->update([
            'nama_titik' => $request->nama_titik,
            'hasil' => $request->hasil,
            'waktu_panen' => $request->waktu_panen,
            'estimasi_panen' => $request->estimasi_panen,
            'terakhir_pemupukan' => $request->terakhir_pemupukan,
            'jenis_pupuk' => $request->jenis_pupuk,
            'jumlah_pupuk' => $request->jumlah_pupuk,
            'edited_by' => $request->edited_by,
            'updated_at' => now(), // otomatis ikut timezone +7
        ]);

        return response()->json(['success' => true, 'titik' => $titik]);
    }
    
    public function show($id)
    {
        $titik = Titik::findOrFail($id);
        return view('maps.show', compact('titik'));
    }
    

}
