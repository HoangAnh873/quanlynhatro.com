<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Host;
use App\Models\Apartment;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function index()
    {
        $hosts = Host::with('user')->get();
        return view('admin.dashboard', compact('hosts'));
    }

    public function destroy($id)
    {
        Host::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Chủ trọ đã bị xóa.');
    }
}
