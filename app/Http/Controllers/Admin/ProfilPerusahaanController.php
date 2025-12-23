<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Profil;
use App\Models\Misi;
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
        // ================= VALIDASI =================
        $request->validate([
            'nama_profil'       => 'required|string|max:255',
            'deskripsi_profil'  => 'required|string',
            'visi'              => 'required|string',
            'logo'              => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
            'misi_list'         => 'array',
            'misi_list.*'       => 'nullable|string|max:255',
        ]);

        // ================= PROFIL =================
        $profil = Profil::findOrNew(1);
        $profil->id = 1;

        if ($request->hasFile('logo')) {

            if ($profil->logo && Storage::disk('public')->exists($profil->logo)) {
                Storage::disk('public')->delete($profil->logo);
            }

            $profil->logo = $request->file('logo')
                ->store('assets/foto/profilperusahaan', 'public');
        }

        $profil->nama_profil      = $request->nama_profil;
        $profil->deskripsi_profil = $request->deskripsi_profil;
        $profil->visi             = $request->visi;
        $profil->save();

        // ================= MISI =================
        $this->syncMisiFromAlpine($profil, $request);

        return redirect()
            ->route('profilperusahaan.index')
            ->with('success_type', 'simpan');
    }

    /**
     * Sinkron MISI SESUAI HTML + ALPINE
     */
    protected function syncMisiFromAlpine(Profil $profil, Request $request)
    {
        $misiList = $request->input('misi_list', []);
        $keepIds  = [];

        foreach ($misiList as $index => $text) {
            if (trim($text) === '') continue;

            $misiId = $request->input("misi_id_{$index}");

            // 🔁 UPDATE MISI LAMA
            if ($misiId) {
                Misi::where('id', $misiId)
                    ->where('profil_id', $profil->id)
                    ->update(['misi' => $text]);

                $keepIds[] = $misiId;
            }
            // ➕ TAMBAH MISI BARU
            else {
                $new = Misi::create([
                    'profil_id' => $profil->id,
                    'misi' => $text,
                ]);

                $keepIds[] = $new->id;
            }
        }

        // ❌ HAPUS MISI YANG DITARIK DARI UI
        $profil->misi()
            ->whereNotIn('id', $keepIds)
            ->delete();
    }
}