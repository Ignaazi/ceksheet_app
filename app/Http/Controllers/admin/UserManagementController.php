<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->latest()->paginate(10)->withQueryString();

        // Menghitung statistik total per role untuk Snapshot Cards
        $adminCount  = User::whereIn('role', ['admin', 'administrator'])->count();
        $leaderCount = User::where('role', 'leader')->count();
        $staffCount  = User::where('role', 'staff')->count();

        return view('admin.userManagement', compact('users', 'adminCount', 'leaderCount', 'staffCount'));
    }

    /**
     * Menampilkan halaman full-page form tambah user
     */
    public function create()
    {
        return view('admin.addUser'); // atau 'admin.users.create' sesuai nama file view Blade kamu
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik'      => ['required', 'string', 'max:255', 'unique:users,nik'],
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['nullable', 'email', 'max:255'],
            'role'     => ['required', Rule::in(['admin', 'leader', 'staff'])],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('users.index')->with('status', 'user-created');
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'nik'      => ['required', 'string', 'max:255', Rule::unique('users', 'nik')->ignore($user->id)],
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['nullable', 'email', 'max:255'],
            'role'     => ['required', Rule::in(['admin', 'leader', 'staff'])],
            'password' => ['nullable', 'string', 'min:8'],
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('users.index')->with('status', 'user-updated');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('status', 'user-deleted');
    }
}