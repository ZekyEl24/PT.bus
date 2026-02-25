<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InfoKontak;
use App\Models\ActivityLog; // Tambahkan ActivityLog
use Illuminate\Http\Request;

class InfoKontakController extends Controller
{
    public function index()
    {
        // Mengambil satu data pertama dari tabel info_kontak
        $kontak = InfoKontak::first();

        return view('admin.infokontak.index', [
            'title' => 'Info Kontak',
            'active' => 'infokontak',
            'kontak' => $kontak,
        ]);
    }

    public function update(Request $request, $id)
    {
        // 1. Validasi input
        $request->validate([
            'nomer_telepon' => 'required|string|max:20',
            'email'         => 'required|email|max:255',
            'alamat'        => 'required|string',
        ], [
            'nomer_telepon.required' => 'Nomor WhatsApp harus diisi.',
            'email.required' => 'Email harus diisi.',
            'alamat.required' => 'Alamat harus diisi.',
        ]);

        try {
            $kontak = InfoKontak::findOrFail($id);

            // 2. Isi data baru untuk mendeteksi perubahan
            $kontak->fill([
                'nomer_telepon' => $request->nomer_telepon,
                'email'         => $request->email,
                'alamat'        => $request->alamat,
            ]);

            // 3. Deteksi perubahan kolom teks menggunakan getDirty()
            $changes = [];
            foreach ($kontak->getDirty() as $column => $newValue) {
                if ($column == 'updated_at') continue;

                $oldValue = $kontak->getOriginal($column);

                if ($column == 'nomer_telepon') {
                    $changes[] = "No. WhatsApp $oldValue -> $newValue";
                } elseif ($column == 'email') {
                    $changes[] = "Email $oldValue -> $newValue";
                } elseif ($column == 'alamat') {
                    $changes[] = "Alamat";
                }
            }

            // 4. Jika ada perubahan, simpan dan catat log
            if (!empty($changes)) {
                $kontak->save();

                $deskripsiDetail = "Mengubah " . implode(', ', $changes) ;
                ActivityLog::simpanLog('Edit', 'Info Kontak', $deskripsiDetail);
            }

            return redirect()->route('infokontak.index')
                ->with('success_type', 'simpan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error_type', 'gagal')->withInput();
        }
    }
}
