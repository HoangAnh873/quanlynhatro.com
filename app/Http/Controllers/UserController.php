<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Host;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::whereIn('role', ['admin', 'host'])->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,host',
        ]);

        // Tạo user trước khi gán vào Host
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        // Nếu role là host, thì tạo Host liên kết với User vừa tạo
        if ($request->role === 'host') {
            Host::create([
                'user_id' => $user->id, // Lúc này $user đã tồn tại
                'phone' => $request->phone ?? '', // Kiểm tra nếu phone bị null
                'address' => $request->address ?? '',
            ]);
        }

        return redirect()->route('users.index')->with('success', 'Tạo tài khoản thành công.');
    }


    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|string|email|max:255|unique:users,email,{$user->id}",
            'password' => 'nullable|string|min:6',
            'role' => 'required|in:admin,host',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'role' => $request->role,
        ]);

        // Nếu user là host, cập nhật thông tin host
        if ($user->role === 'host' && $user->host) {
            $user->host->update([
                'phone' => $request->phone ?? $user->host->phone,
                'address' => $request->address ?? $user->host->address,
            ]);
        }

        return redirect()->route('users.index')->with('success', 'Cập nhật tài khoản thành công.');
    }

    public function destroy(User $user)
    {
        // Nếu user là host, xóa luôn host liên quan
        if ($user->role === 'host' && $user->host) {
            $user->host->delete();
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'Xóa tài khoản thành công.');
    }
}