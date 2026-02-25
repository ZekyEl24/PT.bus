<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ActivityLog; // Import ActivityLog
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->has('status') && $request->status != 'semua') {
            $query->where('status_pengguna', $request->status);
        }

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('username', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        $query->orderBy('created_at', 'desc');
        $users = $query->paginate(5);

        return view('admin.user.index', [
            'title' => 'Pengguna',
            'active' => 'user',
            'users' => $users
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users,username|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|min:6',
            'role' => ['required', Rule::in(['admin', 'editor ub'])],
            'status_pengguna' => ['required', Rule::in(['aktif', 'tidak aktif'])]
        ]);

        $data = $request->except('password');
        $data['password'] = Hash::make($request->password);

        User::create($data);

        // LOG TAMBAH
        ActivityLog::simpanLog('Tambah', 'Pengguna', 'Menambahkan pengguna baru: ' . $request->username . ' dengan role ' . $request->role);

        return redirect()->route('user.index')->with('success_type', 'buat');
    }

    public function update(Request $request, User $user)
    {
        $usernameAsli = $user->username;

        $rules = [
            'username' => ['required', 'max:255', Rule::unique('users', 'username')->ignore($user->id)],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'role' => ['required', Rule::in(['admin', 'editor ub'])],
            'status_pengguna' => ['required', Rule::in(['aktif', 'tidak aktif'])]
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'min:6';
        }

        $request->validate($rules);

        try {
            // 1. Deteksi perubahan field sebelum disave
            $user->fill($request->except('password'));

            $changes = [];
            foreach ($user->getDirty() as $column => $newValue) {
                $oldValue = $user->getOriginal($column);

                if ($column == 'status_pengguna') {
                    $changes[] = "Status $oldValue -> $newValue";
                } elseif ($column == 'role') {
                    $changes[] = "Role $oldValue -> $newValue";
                } elseif ($column == 'username') {
                    $changes[] = "Username $oldValue -> $newValue";
                } else {
                    $changes[] = ucfirst($column);
                }
            }

            // 2. Cek jika password diganti
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
                $changes[] = "Kata Sandi (diperbarui)";
            }

            // 3. Simpan jika ada perubahan
            if (!empty($changes)) {
                $user->save();

                // Format: "Mengubah Role admin -> editor ub, Kata Sandi (diperbarui) di user 'admin_tegal'"
                $deskripsiDetail = "Mengubah " . implode(', ', $changes) . " di user '$usernameAsli'";
                ActivityLog::simpanLog('Edit', 'Pengguna', $deskripsiDetail);
            }

            return redirect()->route('user.index')->with('success_type', 'simpan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error_type', 'gagal')->withInput();
        }
    }

    public function destroy(User $user)
    {
        try {
            $usernameLama = $user->username;

            // Proteksi agar tidak menghapus diri sendiri
            if ($user->id === Auth::id()) {
                return redirect()->back()->with('error_type', 'gagal');
            }

            $user->delete();

            ActivityLog::simpanLog('Hapus', 'Pengguna', 'Menghapus pengguna: ' . $usernameLama);

            return redirect()->route('user.index')->with('success_type', 'hapus');
        } catch (\Exception $e) {
            return redirect()->route('user.index')->with('error_type', 'hapus');
        }
    }
}
