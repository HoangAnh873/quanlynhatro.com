<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\School;

class SchoolController extends Controller
{
    public function index()
    {
        $schools = School::all();
        return view('schools.index', compact('schools'));
    }

    public function create()
    {
        return view('schools.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'GPS_Latitude' => 'nullable|numeric',
            'GPS_Longitude' => 'nullable|numeric',
            'icon' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
        ]);

        // Xử lý upload icon nếu có
        if ($request->hasFile('icon')) {
            $iconName = time() . '.' . $request->file('icon')->getClientOriginalExtension();
            $request->file('icon')->move(public_path('img/icons'), $iconName);
            $data['icon'] = $iconName;
        }

        // Tạo mới trường học
        School::create($data);

        return redirect()->route('schools.index')->with('success', 'Thêm trường học thành công!');
    }

    public function edit(School $school)
    {
        return view('schools.edit', compact('school'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'GPS_Latitude' => 'nullable|numeric',
            'GPS_Longitude' => 'nullable|numeric',
            'icon' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
        ]);
    
        $school = School::findOrFail($id);
    
        // Nếu có icon mới thì cập nhật
        if ($request->hasFile('icon')) {
            $iconName = time() . '.' . $request->icon->extension();
            $request->icon->move(public_path('img/icons'), $iconName);
            $data['icon'] = $iconName;
        } else {
            // Giữ nguyên icon cũ
            $data['icon'] = $school->icon;
        }
    
        $school->update($data);
    
        return redirect()->route('schools.index')->with('success', 'Cập nhật trường học thành công!');
    }
    
    

    public function destroy(School $school)
    {
        $school->delete();

        return redirect()->route('schools.index')->with('success', 'Xóa trường học thành công!');
    }
}
