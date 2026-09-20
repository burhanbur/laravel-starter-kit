<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

use App\Models\User;
use App\Models\Role;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Requests\User\UpdateUserPasswordRequest;

use Yajra\DataTables\DataTables;

use Exception;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $selectedRoles = array_values(array_filter((array) $request->input('roles', [])));
        $roles = Role::orderBy('name', 'asc')->get();
        $user = User::with(['roles'])
            ->when($selectedRoles, function ($query, $selectedRoles) {
                $query->whereHas('roles', function ($q) use ($selectedRoles) {
                    $q->whereIn('roles.id', $selectedRoles);
                });
            })
            ->orderBy('name', 'asc')
            ->get();

        return view('pages.user.index', get_defined_vars());
    }

    public function create(Request $request)
    {
        $roles = Role::all();

        return view('pages.user.create', get_defined_vars())->renderSections()['content'];
    }

    public function edit($id)
    {
        $roles = Role::all();
        $data = User::findOrFail($id);

        return view('pages.user.edit', get_defined_vars())->renderSections()['content'];
    }

    public function changePassword($id)
    {
        $data = User::findOrFail($id);

        return view('pages.user.change-password', get_defined_vars())->renderSections()['content'];
    }

    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();

        DB::beginTransaction();

        try {
            $roles = $data['roles'] ?? [];
            unset($data['roles']);

            $data['is_active'] = $request->boolean('is_active');
            $data['created_by'] = auth()->user()->id;
            $data['updated_by'] = auth()->user()->id;
            $user = User::create($data);
            $user->syncRoles($roles);

            DB::commit();
            Session::flash('notification', ['level' => 'success', 'message' => 'Data pengguna berhasil dibuat.']);
            return redirect()->route('user.index');
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());
            Session::flash('notification', ['level' => 'error', 'message' => 'Gagal membuat data pengguna.']);
            return redirect()->back()->withInput();
        }
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $data = $request->validated();

        DB::beginTransaction();

        try {
            $roles = $data['roles'] ?? [];
            unset($data['roles']);

            $user = User::findOrFail($id);
            $data['is_active'] = $request->boolean('is_active');
            
            // Prevent self-deactivation
            if ($user->id === auth()->id() && !$data['is_active']) {
                $data['is_active'] = true;
            }

            $data['updated_by'] = auth()->user()->id;
            $user->update($data);
            $user->syncRoles($roles);

            DB::commit();
            Session::flash('notification', ['level' => 'success', 'message' => 'Data pengguna berhasil diperbarui.']);
            return redirect()->route('user.index');
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());
            Session::flash('notification', ['level' => 'error', 'message' => 'Gagal memperbarui data pengguna.']);
            return redirect()->back()->withInput();
        }
    }

    public function updatePassword(UpdateUserPasswordRequest $request, $id)
    {
        $data = $request->validated();

        DB::beginTransaction();

        try {
            $user = User::findOrFail($id);
            $user->password = Hash::make($data['password']);
            $user->updated_by = auth()->user()->id;
            $user->save();

            DB::commit();
            Session::flash('notification', ['level' => 'success', 'message' => 'Password berhasil diperbarui.']);
            return redirect()->route('user.index');
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());
            Session::flash('notification', ['level' => 'error', 'message' => 'Gagal memperbarui password.']);
            return redirect()->back()->withInput();
        }
    }

    public function toggleStatus(Request $request, $id)
    {
        $currentUser = auth()->user();

        if ($currentUser && $currentUser->id === $id) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak dapat mengubah status aktif akun Anda sendiri.'
            ], 422);
        }

        DB::beginTransaction();

        try {
            $user = User::findOrFail($id);
            $user->is_active = !$user->is_active;
            $user->updated_by = $currentUser ? $currentUser->id : null;
            $user->save();

            DB::commit();

            $statusLabel = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';

            return response()->json([
                'success' => true,
                'is_active' => $user->is_active,
                'message' => "Akun {$user->name} berhasil {$statusLabel}."
            ]);
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui status pengguna.'
            ], 500);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $user = User::findOrFail($id);
            $user->deleted_by = auth()->user()->id;
            $user->updated_by = auth()->user()->id;
            $user->save();
            $user->roles()->detach();
            $user->delete();

            DB::commit();
            Session::flash('notification', ['level' => 'success', 'message' => 'Data pengguna berhasil dihapus.']);
            return redirect()->route('user.index');
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());
            Session::flash('notification', ['level' => 'error', 'message' => 'Gagal menghapus data pengguna.']);
            return redirect()->back()->withInput();
        }
    }

    public function impersonate(User $user)
    {
        $currentUser = auth()->user();

        if (!$currentUser) {
            return redirect()->back();
        }

        if ($currentUser->is($user)) {
            Session::flash('notification', ['level' => 'warning', 'message' => 'Anda tidak dapat melakukan impersonasi terhadap akun sendiri.']);
            return redirect()->back();
        }

        $currentUser->impersonate($user);

        return redirect()->route('dashboard');
    }

    public function leaveImpersonate()
    {
        if (!auth()->user()) {
            return redirect()->back();
        }

        auth()->user()->leaveImpersonation();

        return redirect()->route('dashboard');
    }
}
