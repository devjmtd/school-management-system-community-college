<?php

namespace App\Http\Controllers;

use App\Models\SchoolYear;
use Illuminate\Http\Request;

class SchoolYearController extends Controller
{
    public function index()
    {
        return SchoolYear::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
        ]);

        return SchoolYear::create($data);
    }

    public function show(SchoolYear $schoolYear)
    {
        return $schoolYear;
    }

    public function update(Request $request, SchoolYear $schoolYear)
    {
        $data = $request->validate([
            'name' => ['required'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
        ]);

        $schoolYear->update($data);

        return $schoolYear;
    }

    public function destroy(SchoolYear $schoolYear)
    {
        $schoolYear->delete();

        return response()->json();
    }
}
