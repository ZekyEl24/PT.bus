<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Profil;
use App\Models\Misi;
use App\Models\ActivityLog; // Tambahkan ActivityLog
use Illuminate\Support\Facades\Storage;

class ProfilPerusahaanController extends Controller
{
    public function index()
    {
        $profil = Profil::with('misi')->find(1);

        if (!$profil) {
            $profil = new Profil();
            $profil->setRelation('misi', collect());
        }

        if ($profil && $profil->logo) {
            $profil->logo = str_replace('public/', '', $profil->logo);
        }

        return view('admin.profilperusahaan.index', [
            'title' => 'Profil Perusahaan',
            'active' => 'profilperusahaan',
            'profil' => $profil
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_profil'      => 'required|string|max:255',
            'deskripsi_profil' => 'required|string',
            'visi'             => 'required|string',
            'logo'             => 'nullable|image|mimes:jpg,jpeg,png,svg', // Limit dihapus
            'misi_list'        => 'array',
            'misi_list.*'      => 'nullable|string|max:255',
        ]);

        try {
            $profil = Profil::findOrNew(1);
            $profil->id = 1;

            // 1. Deteksi perubahan kolom profil
            $profil->fill($request->only(['nama_profil', 'deskripsi_profil', 'visi']));
            $changes = [];

            foreach ($profil->getDirty() as $column => $newValue) {
                $oldValue = $profil->getOriginal($column);
                if ($column == 'nama_profil') {
                    $changes[] = "Nama Profil $oldValue -> $newValue";
                } elseif ($column == 'visi') {
                    $changes[] = "Visi Perusahaan";
                } elseif ($column == 'deskripsi_profil') {
                    $changes[] = "Deskripsi Profil";
                }
            }

            // 2. Tangani Logo
            if ($request->hasFile('logo')) {
                if ($profil->logo && Storage::disk('public')->exists($profil->logo)) {
                    Storage::disk('public')->delete($profil->logo);
                }
                $profil->logo = $request->file('logo')->store('assets/foto/profilperusahaan', 'public');
                $changes[] = "Logo Perusahaan";
            }

            // Simpan Profil
            $profil->save();

            // 3. Sinkron Misi dan dapatkan info apakah ada misi yang berubah
            $misiChanged = $this->syncMisiFromAlpine($profil, $request);
            if ($misiChanged) {
                $changes[] = "Daftar Misi";
            }

            // 4. Catat Log jika ada perubahan apapun
            if (!empty($changes)) {
                $deskripsiDetail = "Mengubah " . implode(', ', $changes) . " di Profil Perusahaan";
                ActivityLog::simpanLog('Edit', 'Profil Perusahaan', $deskripsiDetail);
            }

            return redirect()
                ->route('profilperusahaan.index')
                ->with('success_type', 'simpan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error_type', 'gagal')->withInput();
        }
    }

    /**
     * Sinkron MISI SESUAI HTML + ALPINE
     * Return boolean (true jika ada perubahan)
     */
    protected function syncMisiFromAlpine(Profil $profil, Request $request)
    {
        $misiList = $request->input('misi_list', []);
        $keepIds  = [];
        $hasChange = false;

        // Ambil ID misi yang ada sekarang sebelum proses
        $currentMisiIds = $profil->misi()->pluck('id')->toArray();

        foreach ($misiList as $index => $text) {
            if (trim($text) === '') continue;

            $misiId = $request->input("misi_id_{$index}");

            if ($misiId) {
                $misiOld = Misi::find($misiId);
                if ($misiOld && $misiOld->misi !== $text) {
                    $misiOld->update(['misi' => $text]);
                    $hasChange = true;
                }
                $keepIds[] = $misiId;
            } else {
                $new = Misi::create([
                    'profil_id' => $profil->id,
                    'misi' => $text,
                ]);
                $keepIds[] = $new->id;
                $hasChange = true;
            }
        }

        // Cek apakah ada yang dihapus
        $toDeleteCount = $profil->misi()->whereNotIn('id', $keepIds)->count();
        if ($toDeleteCount > 0) {
            $profil->misi()->whereNotIn('id', $keepIds)->delete();
            $hasChange = true;
        }

        return $hasChange;
    }
}