<?php
// UsersController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    // Read Users (Index) dengan filter dan search
    public function index(Request $request)
    {
        $query = User::query();

        // Filter berdasarkan status
        if ($request->has('status') && $request->status != 'semua') {
            $query->where('status_pengguna', $request->status);
        }

        // Search berdasarkan username atau email
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('username', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        // Sorting default (optional)
        $query->orderBy('created_at', 'desc');

        $users = $query->paginate(5);

        return view('admin.user.index', [
            'title' => 'Pengguna',
            'active' => 'user',
            'users' => $users
        ]);
    }

    // SHOW (Menampilkan satu user)
    public function show(User $user)
    {
        // return view('admin.user.show', compact('user'));
    }

    // 1. EDIT (Menampilkan form edit dengan data terisi)
    public function edit(User $user)
    {
        // Laravel secara otomatis menemukan User berdasarkan ID di URL ($user)
        return view('admin.user.edit', [
            'user' => $user, // Mengirim objek user ke view
            'title' => 'Edit Pengguna',
            'active' => 'user',
        ]);
    }

    // 2. UPDATE (Menyimpan perubahan)
    public function update(Request $request, User $user)
    {
        // Validasi, kecuali untuk username/email user saat ini
        $rules = [
            'username' => ['required', 'max:255', Rule::unique('users', 'username')->ignore($user->id)],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'role' => ['required', Rule::in(['admin', 'editor ub'])],
            'status_pengguna' => ['required', Rule::in(['aktif', 'tidak aktif'])]
        ];

        // Jika user memasukkan password baru, tambahkan validasi password
        if ($request->filled('password')) {
            $rules['password'] = 'min:6';
        }

        $request->validate($rules);

        $data = $request->except('password');

        // Jika ada password baru, hash sebelum disimpan
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('user.index')
            ->with('success_type', 'simpan');
    }

    // Store User (Menyimpan data baru)
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

        return redirect()->route('user.index')->with('success_type', 'buat');
    }

    // Delete User
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('user.index')->with('success_type', 'hapus');
    }
}
