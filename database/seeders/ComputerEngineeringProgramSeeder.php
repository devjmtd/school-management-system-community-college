<?php

namespace Database\Seeders;

use App\Actions\Curriculums\CreateNewSubjectAction;
use App\Data\Curriculums\CreateNewSubjectData;
use App\Models\Department;
use App\Models\Program;
use App\Models\SchoolYear;
use Illuminate\Database\Seeder;

class ComputerEngineeringProgramSeeder extends Seeder
{
    public function run(): void
    {
        if (Program::where('code', 'BSCpE')->count() === 0) {
            $department = Department::createOrFirst([
                'name' => 'Engineering',
            ]);

            $program = Program::create([
                'name' => 'Bachelor of Science in Computer Engineering',
                'major' => null,
                'code' => 'BSCpE',
                'department_id' => $department->id,
            ]);

            $currentSchoolYear = SchoolYear::current()->first();

            if (! $currentSchoolYear) {
                $currentSchoolYear = SchoolYear::create([
                    'name' => now()->year,
                    'start_date' => now()->startOfYear(),
                    'end_date' => now()->endOfYear(),
                ]);
            }

            $curriculum = $program->curriculums()->create([
                'name' => 'BSCpE Curriculum '. now()->year,
                'school_year_id' => $currentSchoolYear->id
            ]);

            $curricula = [
                // First Year - First Semester
                [
                    'year_level' => 1,
                    'sem' => 1,
                    'subjects' => [
                        ['code' => 'CpE 101', 'name' => 'Introduction to Computer Engineering', 'units' => 2],
                        ['code' => 'GE 1', 'name' => 'Understanding the Self', 'units' => 3],
                        ['code' => 'GE 2', 'name' => 'Purposive Communication', 'units' => 3],
                        ['code' => 'GE 3', 'name' => 'Mathematics in the Modern World', 'units' => 3],
                        ['code' => 'Math 101', 'name' => 'Calculus 1', 'units' => 5],
                        ['code' => 'Chem 101', 'name' => 'General Chemistry (Lec)', 'units' => 3],
                        ['code' => 'Chem 101L', 'name' => 'General Chemistry (Lab)', 'units' => 1],
                        ['code' => 'PATHFIT 1', 'name' => 'Movement Competency Training', 'units' => 2],
                        ['code' => 'NSTP 1', 'name' => 'National Service Training Program 1', 'units' => 3],
                    ]
                ],

                // First Year - Second Semester
                [
                    'year_level' => 1,
                    'sem' => 2,
                    'subjects' => [
                        ['code' => 'Math 102', 'name' => 'Calculus 2', 'units' => 5],
                        ['code' => 'Phys 101', 'name' => 'Physics for Engineers 1 (Lec)', 'units' => 3],
                        ['code' => 'Phys 101L', 'name' => 'Physics for Engineers 1 (Lab)', 'units' => 1],
                        ['code' => 'CpE 102', 'name' => 'Computer Programming 1', 'units' => 3],
                        ['code' => 'GE 4', 'name' => 'The Contemporary World', 'units' => 3],
                        ['code' => 'GE 5', 'name' => 'Science, Technology, and Society', 'units' => 3],
                        ['code' => 'PATHFIT 2', 'name' => 'Exercise-based Fitness Activities', 'units' => 2],
                        ['code' => 'NSTP 2', 'name' => 'National Service Training Program 2', 'units' => 3],
                    ]
                ],

                // Second Year - First Semester
                [
                    'year_level' => 2,
                    'sem' => 1,
                    'subjects' => [
                        ['code' => 'Math 201', 'name' => 'Differential Equations', 'units' => 3],
                        ['code' => 'Phys 201', 'name' => 'Physics for Engineers 2 (Lec)', 'units' => 3],
                        ['code' => 'Phys 201L', 'name' => 'Physics for Engineers 2 (Lab)', 'units' => 1],
                        ['code' => 'CpE 201', 'name' => 'Computer Programming 2', 'units' => 3],
                        ['code' => 'EE 201', 'name' => 'Basic Electrical Engineering', 'units' => 3],
                        ['code' => 'EE 201L', 'name' => 'Basic Electrical Engineering Lab', 'units' => 1],
                        ['code' => 'GE 6', 'name' => 'Ethics', 'units' => 3],
                        ['code' => 'PATHFIT 3', 'name' => 'Dance', 'units' => 2],
                    ]
                ],

                // Second Year - Second Semester
                [
                    'year_level' => 2,
                    'sem' => 2,
                    'subjects' => [
                        ['code' => 'CpE 202', 'name' => 'Data Structures and Algorithms', 'units' => 3],
                        ['code' => 'ECE 202', 'name' => 'Logic Circuits and Design', 'units' => 3],
                        ['code' => 'ECE 202L', 'name' => 'Logic Circuits and Design Lab', 'units' => 1],
                        ['code' => 'Math 202', 'name' => 'Probability and Statistics for Engineers', 'units' => 3],
                        ['code' => 'GE 7', 'name' => 'Art Appreciation', 'units' => 3],
                        ['code' => 'GE 8', 'name' => 'Life and Works of Rizal', 'units' => 3],
                        ['code' => 'PATHFIT 4', 'name' => 'Sports', 'units' => 2],
                    ]
                ],

                // Third Year - First Semester
                [
                    'year_level' => 3,
                    'sem' => 1,
                    'subjects' => [
                        ['code' => 'CpE 301', 'name' => 'Microprocessors and Microcontrollers', 'units' => 3],
                        ['code' => 'CpE 301L', 'name' => 'Microprocessors and Microcontrollers Lab', 'units' => 1],
                        ['code' => 'CpE 302', 'name' => 'Computer Architecture and Organization', 'units' => 3],
                        ['code' => 'CpE 303', 'name' => 'Software Engineering', 'units' => 3],
                        ['code' => 'CpE 304', 'name' => 'Numerical Methods', 'units' => 3],
                        ['code' => 'GE 9', 'name' => 'Philippine Indigenous Communities', 'units' => 3],
                    ]
                ],

                // Third Year - Second Semester
                [
                    'year_level' => 3,
                    'sem' => 2,
                    'subjects' => [
                        ['code' => 'CpE 305', 'name' => 'Operating Systems', 'units' => 3],
                        ['code' => 'CpE 306', 'name' => 'Data Communications and Networking', 'units' => 3],
                        ['code' => 'CpE 307', 'name' => 'Feedback and Control Systems', 'units' => 3],
                        ['code' => 'CpE 308', 'name' => 'CpE Elective 1', 'units' => 3],
                        ['code' => 'CpE 309', 'name' => 'Methods of Research', 'units' => 3],
                    ]
                ],

                // Fourth Year - First Semester
                [
                    'year_level' => 4,
                    'sem' => 1,
                    'subjects' => [
                        ['code' => 'CpE 401', 'name' => 'CpE Practice / Internship', 'units' => 3],
                        ['code' => 'CpE 402', 'name' => 'CpE Elective 2', 'units' => 3],
                        ['code' => 'CpE 403', 'name' => 'CpE Elective 3', 'units' => 3],
                        ['code' => 'CpE 404', 'name' => 'Design Project 1 (Thesis 1)', 'units' => 3],
                    ]
                ],

                // Fourth Year - Second Semester
                [
                    'year_level' => 4,
                    'sem' => 2,
                    'subjects' => [
                        ['code' => 'CpE 405', 'name' => 'Design Project 2 (Thesis 2)', 'units' => 3],
                        ['code' => 'CpE 406', 'name' => 'Seminars and Field Trips', 'units' => 1],
                        ['code' => 'CpE 407', 'name' => 'CpE Elective 4', 'units' => 3],
                    ]
                ],
            ];

            foreach ($curricula as $yearSem) {
                foreach ($yearSem['subjects'] as $subject) {
                    CreateNewSubjectAction::execute(new CreateNewSubjectData(
                        name: $subject['name'],
                        code: $subject['code'],
                        units: $subject['units'],
                        labUnits: 0,
                        computerLabUnits: 0,
                        nstpUnits: 0,
                        description: $subject['name'],
                        semester: $yearSem['sem'],
                        yearLevel: $yearSem['year_level'],
                        curriculumId: $curriculum->id
                    ));
                }
            }
        }
    }
}
