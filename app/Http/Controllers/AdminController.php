<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use App\Models\Aset;
use App\Models\Timpp2;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use App\Models\Monitoring;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function login()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }


    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $check = $request->all();
        $credentials = [
            'email' => $check['email'],
            'password' => $check['password']
        ];

        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('admin.dashboard')->with('success', 'You are successfully logged in');
        }
        return back()->withErrors([
            'errors' => 'The provided credentials do not match our records.',
        ]);
    }

    public function dashboard()
    {
        $id = Auth::guard('admin')->user()->id;
        $profileData = Admin::find($id);
        $aktifCount = Monitoring::where('aktif', 'aktif')->count();
        $selesaiCount = Monitoring::where('aktif', 'selesai')->count();
        $monitorings = Monitoring::dueWithinDays(7)->get();
        $idleAsetCount = Aset::where('status_aset', 'Idle')->count();
        $optimizedAsetCount = Aset::where('status_aset', 'Optimized')->count();

        return view('admin/dashboard', compact('profileData', 'aktifCount', 'selesaiCount', 'monitorings', 'idleAsetCount', 'optimizedAsetCount'));
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('login')->with('success', 'You are successfully logged out');
    }

    public function profile()
    {
        $id = Auth::guard('admin')->user()->id;
        $profileData = Admin::find($id);
        return view('admin.profile', compact('profileData'));
    }

    public function updateProfile(Request $request)
    {
        $id = Auth::guard('admin')->user()->id;
        $profileData = Admin::find($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:admins,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $profileData->name = $request->name;
        $profileData->email = $request->email;

        if ($request->filled('password')) {
            $profileData->password = bcrypt($request->password);
        }

        $profileData->save();

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    public function addUser()
    {
        $id = Auth::guard('admin')->user()->id;
        $profileData = Admin::find($id);
        return view('admin.user-add', compact('profileData'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        // Cek email sudah ada
        $emailExists = $request->kind === 'timpp2'
            ? Timpp2::where('email', $request->email)->exists()
            : User::where('email', $request->email)->exists();

        if ($emailExists) {
            return redirect()->back()->with([
                'message' => 'Email sudah terdaftar',
                'alert-type' => 'error',
            ]);
        }

        // Simpan user
        if ($request->kind === 'timpp2') {
            $user = new Timpp2();
            $user->role = 'timpp2';
        } else {
            $user = new User();
            $user->role = 'staff';
        }

        $user->uuid = Str::uuid();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('admin.view.users')->with([
            'message' => 'User Added Successfully',
            'alert-type' => 'success',
        ]);
    }

    public function viewUsers()
    {
        $id = Auth::guard('admin')->user()->id;
        $profileData = Admin::find($id);
        $users = array_merge(User::all()->toArray(), Timpp2::all()->toArray());
        return view('admin.user-all', compact('users', 'profileData'));
    }

    public function deleteUser(Request $request)
    {
        if ($request->role == 'timpp2') {
            $id = $request->id;
            $user = Timpp2::find($id);
            $user->delete();
            $notification = array(
                'message' => 'User Deleted Successfully',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        } else {
            $id = $request->id;
            $user = User::find($id);
            $user->delete();
            $notification = array(
                'message' => 'User Deleted Successfully',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        }

        return redirect()->back()->with('error', 'User not found.');
    }

    public function editUser($uuid, $role)
    {
        $id = Auth::guard('admin')->user()->id;
        $profileData = Admin::findOrFail($id);

        if ($role === 'staff') {
            $user = User::where('uuid', $uuid)->first();
        } elseif ($role === 'timpp2') {
            $user = Timpp2::where('uuid', $uuid)->first();
        } else {
            return redirect()->back()->with([
                'message' => 'Role tidak valid.',
                'alert-type' => 'error'
            ]);
        }

        if (!$user) {
            return redirect()->back()->with([
                'message' => 'User not found.',
                'alert-type' => 'error'
            ]);
        }

        return view('admin.user-edit', compact('user', 'profileData', 'role'));
    }

    public function updateUser(Request $request, $uuid, $role)
    {
        // Validasi dasar
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'nullable|min:6',
        ]);

        // Tentukan model berdasarkan role
        if ($role === 'staff') {
            $user = User::where('uuid', $uuid)->first();
        } elseif ($role === 'timpp2') {
            $user = Timpp2::where('uuid', $uuid)->first();
        } else {
            return redirect()->back()->with([
                'message' => 'Role tidak valid.',
                'alert-type' => 'error'
            ]);
        }

        if (!$user) {
            return redirect()->back()->with([
                'message' => 'User not found.',
                'alert-type' => 'error'
            ]);
        }

        // Cek email unik (kecuali milik user ini sendiri)
        $emailExists = ($role === 'staff')
            ? User::where('email', $request->email)
            ->where('uuid', '!=', $uuid)
            ->exists()
            : Timpp2::where('email', $request->email)
            ->where('uuid', '!=', $uuid)
            ->exists();

        if ($emailExists) {
            return redirect()->back()->with([
                'message' => 'Email sudah digunakan.',
                'alert-type' => 'error'
            ]);
        }

        // Update data
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.view.users')->with([
            'message' => 'User updated successfully.',
            'alert-type' => 'success'
        ]);
    }
}
