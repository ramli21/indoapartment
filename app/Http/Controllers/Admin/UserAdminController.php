<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query()->where('is_admin', true)->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->paginate(15)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'is_admin' => true,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Admin berhasil dibuat!');
    }

    public function edit(User $user)
    {
        $this->authorizeAdminUser($user);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $this->authorizeAdminUser($user);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'is_admin' => true,
        ];

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);

        return redirect()->route('admin.users.edit', $user->id)->with('success', 'Admin berhasil diperbarui!');
    }

    public function destroy(User $user)
    {
        $this->authorizeAdminUser($user);

        $adminCount = User::where('is_admin', true)->count();
        if ($adminCount <= 1) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Tidak bisa menghapus admin terakhir.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Admin berhasil dihapus!');
    }

    private function authorizeAdminUser(User $user): void
    {
        abort_unless((bool) $user->is_admin, 403, 'Akses ditolak.');
    }
}

