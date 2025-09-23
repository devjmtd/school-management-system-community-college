<?php

namespace App\Filament\Widgets;

use App\Enums\Role;
use App\Models\Enrollment;
use App\Models\SchoolYear;
use App\Models\Student;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $currentSchoolYear = SchoolYear::current()->first();

        $students = Student::count();

        $enrolledStudents = Enrollment::where('school_year_id', $currentSchoolYear->id)
            ->when(auth()->user()->department_id, function ($query) {
                $query->whereHas('program',function ($query) {
                    $query->where('department_id', auth()->user()->department_id);
                });
            })
            ->count();

        $department = false;

        if (auth()->user()->department_id) {
            $department = auth()->user()->department->name;
        }

        $teacherCount = User::where('role', Role::Teacher)->count();

        return [
            Stat::make('Students', $students)
                ->description('Total Students'),
            Stat::make('Enrolled Students', $enrolledStudents)
                ->description($department ? $department . ' Enrolled Students' . ' School Year: ' . $currentSchoolYear->name : 'Enrolled Students' . ' School Year: ' . $currentSchoolYear->name),
            Stat::make('Teachers', $teacherCount)
                ->description($department ? $department . ' Teachers' : 'Total Teachers')
                ->visible(fn () => auth()->user()->role === Role::Admin || auth()->user()->role === Role::ProgramHead),
        ];
    }
}
