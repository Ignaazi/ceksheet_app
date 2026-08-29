<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    /**
     * Memeriksa apakah user berhak mengakses fitur tertentu
     */
    private function authorizeAction(Request $request, string $permission): void
    {
        /** @var User $user */
        $user = $request->user();

        // Admin selalu di-bypass. Role selain admin wajib punya permission Spatie.
        if ($user->role !== 'admin' && !$user->hasPermissionTo($permission, 'web')) {
            abort(403, 'Anda tidak memiliki hak akses untuk tindakan ini.');
        }
    }

    public function index(Request $request)
    {
        // Kunci Halaman Index jika Staff tidak punya permission 'view-users'
        $this->authorizeAction($request, 'view-users');

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

        $adminCount  = User::whereIn('role', ['admin', 'administrator'])->count();
        $leaderCount = User::where('role', 'leader')->count();
        $staffCount  = User::where('role', 'staff')->count();

        return view('admin.userManagement', compact('users', 'adminCount', 'leaderCount', 'staffCount'));
    }

    public function create(Request $request)
    {
        $this->authorizeAction($request, 'create-users');

        return view('admin.addUser');
    }

    public function store(Request $request)
    {
        $this->authorizeAction($request, 'create-users');

        $validated = $request->validate([
            'nik'      => ['required', 'string', 'max:255', 'unique:users,nik'],
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['nullable', 'email', 'max:255'],
            'role'     => ['required', Rule::in(['admin', 'leader', 'staff'])],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        /** @var User $user */
        $user = User::create($validated);
        $user->syncRoles([$validated['role']]);

        return redirect()->route('users.index')->with('status', 'user-created');
    }

    public function update(Request $request, User $user)
    {
        $this->authorizeAction($request, 'edit-users');

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
        $user->syncRoles([$validated['role']]);

        return redirect()->route('users.index')->with('status', 'user-updated');
    }

    public function destroy(Request $request, User $user)
    {
        $this->authorizeAction($request, 'delete-users');

        $user->delete();

        return redirect()->route('users.index')->with('status', 'user-deleted');
    }
}