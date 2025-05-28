<?php

namespace App\Http\Controllers;

use App\Models\AdmissionRequirement;
use Illuminate\Http\Request;

class AdmissionRequirementController extends Controller
{
    public function index()
    {
        return AdmissionRequirement::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required'],
        ]);

        return AdmissionRequirement::create($data);
    }

    public function show(AdmissionRequirement $admissionRequirement)
    {
        return $admissionRequirement;
    }

    public function update(Request $request, AdmissionRequirement $admissionRequirement)
    {
        $data = $request->validate([
            'name' => ['required'],
        ]);

        $admissionRequirement->update($data);

        return $admissionRequirement;
    }

    public function destroy(AdmissionRequirement $admissionRequirement)
    {
        $admissionRequirement->delete();

        return response()->json();
    }
}
