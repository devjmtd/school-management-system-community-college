<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        return Student::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => ['required'],
            'last_name' => ['required'],
            'date_of_birth' => ['required', 'date'],
            'father_name' => ['nullable'],
            'mother_name' => ['nullable'],
            'elementary_school' => ['nullable'],
            'elementary_year' => ['nullable'],
            'highschool_school' => ['nullable'],
            'highschool_year' => ['nullable'],
            'father_occupation' => ['nullable'],
            'mother_occupation' => ['nullable'],
            'place_of_birth' => ['nullable'],
            'address' => ['nullable'],
            'provincial_address' => ['nullable'],
            'citizenship' => ['nullable'],
            'others' => ['nullable'],
            'admission_checklist' => ['nullable'],
        ]);

        return Student::create($data);
    }

    public function show(Student $student)
    {
        return $student;
    }

    public function update(Request $request, Student $student)
    {
        $data = $request->validate([
            'first_name' => ['required'],
            'last_name' => ['required'],
            'date_of_birth' => ['required', 'date'],
            'father_name' => ['nullable'],
            'mother_name' => ['nullable'],
            'elementary_school' => ['nullable'],
            'elementary_year' => ['nullable'],
            'highschool_school' => ['nullable'],
            'highschool_year' => ['nullable'],
            'father_occupation' => ['nullable'],
            'mother_occupation' => ['nullable'],
            'place_of_birth' => ['nullable'],
            'address' => ['nullable'],
            'provincial_address' => ['nullable'],
            'citizenship' => ['nullable'],
            'others' => ['nullable'],
            'admission_checklist' => ['nullable'],
        ]);

        $student->update($data);

        return $student;
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return response()->json();
    }
}
