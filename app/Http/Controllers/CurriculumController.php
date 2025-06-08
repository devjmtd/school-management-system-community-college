<?php

namespace App\Http\Controllers;

use App\Models\Curriculum;
use Illuminate\Http\Request;

class CurriculumController extends Controller
{
    public function index()
    {
        return Curriculum::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required'],
            'program_id' => ['required', 'exists:programs'],
            'school_year_id' => ['nullable', 'exists:school_years'],
        ]);

        return Curriculum::create($data);
    }

    public function show(Curriculum $curriculum)
    {
        return $curriculum;
    }

    public function update(Request $request, Curriculum $curriculum)
    {
        $data = $request->validate([
            'name' => ['required'],
            'program_id' => ['required', 'exists:programs'],
            'school_year_id' => ['nullable', 'exists:school_years'],
        ]);

        $curriculum->update($data);

        return $curriculum;
    }

    public function destroy(Curriculum $curriculum)
    {
        $curriculum->delete();

        return response()->json();
    }
}
