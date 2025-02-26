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
        $request->validate([
            'name' => 'required|string|max:255',
            'house_number' => 'nullable|string|max:50',
            'street' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        School::create($request->all());
        return redirect()->route('schools.index')->with('success', 'Thêm trường thành công!');
    }

    public function edit($id)
    {
        $school = School::findOrFail($id);
        return view('schools.edit', compact('school'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'house_number' => 'nullable|string|max:50',
            'street' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $school = School::findOrFail($id);
        $school->update($request->all());
        return redirect()->route('schools.index')->with('success', 'Cập nhật trường thành công!');
    }

    public function destroy($id)
    {
        $school = School::findOrFail($id);
        $school->delete();
        return redirect()->route('schools.index')->with('success', 'Xóa trường thành công!');
    }
}
