<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        return Schedule::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'subject_id' => ['required', 'exists:subjects'],
            'teacher_id' => ['nullable', 'exists:users'],
            'room_id' => ['nullable', 'exists:rooms'],
            'day_of_week' => ['nullable', 'integer'],
            'start_time' => ['nullable', 'date'],
            'end_time' => ['nullable', 'date'],
        ]);

        return Schedule::create($data);
    }

    public function show(Schedule $schedule)
    {
        return $schedule;
    }

    public function update(Request $request, Schedule $schedule)
    {
        $data = $request->validate([
            'subject_id' => ['required', 'exists:subjects'],
            'teacher_id' => ['nullable', 'exists:users'],
            'room_id' => ['nullable', 'exists:rooms'],
            'day_of_week' => ['nullable', 'integer'],
            'start_time' => ['nullable', 'date'],
            'end_time' => ['nullable', 'date'],
        ]);

        $schedule->update($data);

        return $schedule;
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        return response()->json();
    }
}
