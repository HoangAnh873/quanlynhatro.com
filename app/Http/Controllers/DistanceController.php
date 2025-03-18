<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Distance;

class DistanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getNearbyApartments($school_id)
    {
        $apartments = Distance::where('school_id', $school_id)
            ->join('apartments', 'distances.apartment_id', '=', 'apartments.id')
            ->orderBy('distance', 'ASC')
            ->select('apartments.name', 'distances.distance')
            ->get();

        return response()->json($apartments);
    }
}