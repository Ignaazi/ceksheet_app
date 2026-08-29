<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserPermissionController extends Controller
{
    /**
     * Tampilkan halaman Matrix Access Control.
     */
    public function index(Request $request)
    {
        // Ambil semua daftar permission dan role untuk dikirim ke view
        $permissions = Permission::all();
        $roles = Role::with('permissions')->get();

        return view('UserPermission', compact('permissions', 'roles'));
    }

    /**
     * Simpan / Sync perubahan Matrix Checkbox Permissions per Role.
     */
    public function update(Request $request, $id = null)
    {
        // Hanya Admin yang berhak memperbarui matriks akses
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $matrix = $request->input('permissions', []);

        // Daftar role yang didukung
        $availableRoles = ['admin', 'leader', 'staff'];

        foreach ($availableRoles as $roleName) {
            // Pastikan Role ada di database, jika belum ada buatkan otomatis
            $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
            
            $permissionNamesToSync = [];

            // Jika ada data centangan untuk role ini
            if (isset($matrix[$roleName]) && is_array($matrix[$roleName])) {
                foreach ($matrix[$roleName] as $module => $actions) {
                    foreach ($actions as $action => $value) {
                        if ($value == '1') {
                            // Format nama permission: "action-module" (contoh: "view-users", "edit-ip_config")
                            $permName = strtolower("{$action}-{$module}");

                            // Buat permission ke DB jika belum terdaftar
                            Permission::firstOrCreate([
                                'name' => $permName,
                                'guard_name' => 'web'
                            ]);

                            $permissionNamesToSync[] = $permName;
                        }
                    }
                }
            }

            // Sync permission ke Role (yang tidak dicentang otomatis dicabut)
            $role->syncPermissions($permissionNamesToSync);
        }

        return redirect()->route('permissions.index')->with('status', 'permissions-updated');
    }

    /**
     * Tambah Single Permission baru (opsional).
     */
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
            'guard_name' => 'required|string|max:255',
        ]);

        Permission::create([
            'name' => strtolower($request->name),
            'guard_name' => $request->guard_name ?? 'web',
        ]);

        return redirect()->route('permissions.index')->with('status', 'permission-created');
    }

    /**
     * Hapus Permission spesifik (opsional).
     */
    public function destroy($id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $permission = Permission::findOrFail($id);
        $permission->delete();

        return redirect()->route('permissions.index')->with('status', 'permission-deleted');
    }
}