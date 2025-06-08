<?php

namespace App\Http\Controllers;

use App\Models\CurriculumSubject;
use Illuminate\Http\Request;

class CurriculumSubjectController extends Controller
{
    public function index()
    {
        return CurriculumSubject::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => ['required'],
            'semester' => ['required', 'integer'],
            'year_level' => ['required', 'integer'],
            'order_column' => ['nullable', 'integer'],
            'curriculum_id' => ['required', 'exists:curriculums'],
            'subject_id' => ['required', 'exists:curriculums'],
        ]);

        return CurriculumSubject::create($data);
    }

    public function show(CurriculumSubject $curriculumSubject)
    {
        return $curriculumSubject;
    }

    public function update(Request $request, CurriculumSubject $curriculumSubject)
    {
        $data = $request->validate([
            'code' => ['required'],
            'semester' => ['required', 'integer'],
            'year_level' => ['required', 'integer'],
            'order_column' => ['nullable', 'integer'],
            'curriculum_id' => ['required', 'exists:curriculums'],
            'subject_id' => ['required', 'exists:curriculums'],
        ]);

        $curriculumSubject->update($data);

        return $curriculumSubject;
    }

    public function destroy(CurriculumSubject $curriculumSubject)
    {
        $curriculumSubject->delete();

        return response()->json();
    }
}
