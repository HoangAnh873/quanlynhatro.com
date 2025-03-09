<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoomType;

class RoomTypeController extends Controller
{
    public function index()
    {
        $roomTypes = RoomType::all();
        return view('hosts.RoomType.index', compact('roomTypes'));
    }

    public function create()
    {
        return view('hosts.RoomType.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'max_occupants' => 'required|integer|min:1',
            'area' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
        ]);

        RoomType::create($request->all());

        return redirect()->route('host.types.index')->with('success', 'Room type added successfully!');
    }

    public function edit($id)
    {
        $roomType = RoomType::findOrFail($id);
        return view('hosts.RoomType.edit', compact('roomType'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'max_occupants' => 'required|integer|min:1',
            'area' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
        ]);

        $roomType = RoomType::findOrFail($id);
        $roomType->update($request->all());

        return redirect()->route('host.types.index')->with('success', 'Room type updated successfully!');
    }

    public function destroy($id)
    {
        RoomType::destroy($id);
        return redirect()->route('host.types.index')->with('success', 'Room type deleted successfully!');
    }
}
