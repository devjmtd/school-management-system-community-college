<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index()
    {
        return Program::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required'],
            'code' => ['required'],
            'department_id' => ['nullable', 'exists:departments'],
        ]);

        return Program::create($data);
    }

    public function show(Program $program)
    {
        return $program;
    }

    public function update(Request $request, Program $program)
    {
        $data = $request->validate([
            'name' => ['required'],
            'code' => ['required'],
            'department_id' => ['nullable', 'exists:departments'],
        ]);

        $program->update($data);

        return $program;
    }

    public function destroy(Program $program)
    {
        $program->delete();

        return response()->json();
    }
}
