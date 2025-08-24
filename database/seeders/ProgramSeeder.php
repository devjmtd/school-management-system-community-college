<?php

namespace Database\Seeders;

use App\Actions\Curriculums\CreateNewSubjectAction;
use App\Data\Curriculums\CreateNewSubjectData;
use App\Models\Department;
use App\Models\Program;
use App\Models\SchoolYear;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    public function run(): void
    {
        if (Program::where('code', 'BSE')->where('major', 'English')->count() === 0) {
            $department = Department::createOrFirst([
                'name' => 'Education',
            ]);

            $program = Program::create([
                'name' => 'Bachelor of Secondary Education',
                'major' => 'English',
                'code' => 'BSE',
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
                'name' => 'BSE Curriculum '. now()->year,
                'school_year_id' => $currentSchoolYear->id
            ]);

            $curricula = [
                // First Year - First Semester
                [
                    'year_level' => 1,
                    'sem' => 1,
                    'subjects' => [
                        ['code' => 'MC ELT 101', 'name' => 'Introduction to Linguistic', 'units' => 3],
                        ['code' => 'GE 1', 'name' => 'Understanding the Self', 'units' => 3],
                        ['code' => 'GE 2', 'name' => 'Reading in the Philippine History', 'units' => 3],
                        ['code' => 'GE 3', 'name' => 'The Contemporary World', 'units' => 3],
                        ['code' => 'Prof. Ed 1', 'name' => 'The Child and Adolescent Learners and Learning Principle', 'units' => 3],
                        ['code' => 'Cognate Elec1', 'name' => 'Stylistics and Discourse Analysis', 'units' => 3],
                        ['code' => 'PATHFIT 1', 'name' => 'Movement Competency Training', 'units' => 2],
                        ['code' => 'NSTP 1', 'name' => 'Literacy Training Services', 'units' => 3],
                    ]
                ],

                // First Year - Second Semester
                [
                    'year_level' => 1,
                    'sem' => 2,
                    'subjects' => [
                        ['code' => 'MC ELT 102', 'name' => 'Language, Culture and Society', 'units' => 3],
                        ['code' => 'MC ELT 103', 'name' => 'Structure of English', 'units' => 3],
                        ['code' => 'GE 4', 'name' => 'Mathematics in the Modern World', 'units' => 3],
                        ['code' => 'G.E. 5', 'name' => 'Purposive Communication', 'units' => 3],
                        ['code' => 'Prof. Ed 2', 'name' => 'Foundation of Special and Inclusive Education', 'units' => 3],
                        ['code' => 'Cognate Elec2', 'name' => 'Translation and Editing of Text', 'units' => 3],
                        ['code' => 'PATHFIT 2', 'name' => 'Exercise-based Fitness Activities', 'units' => 2],
                        ['code' => 'NSTP 2', 'name' => 'Literacy Training Services', 'units' => 3],
                    ]
                ],

                // Second Year - First Semester
                [
                    'year_level' => 2,
                    'sem' => 1,
                    'subjects' => [
                        ['code' => 'MC ELT 104', 'name' => 'Mythology and Folklore', 'units' => 3],
                        ['code' => 'MC ELT 105', 'name' => 'Language programs and policies in Multilingual Societies', 'units' => 3],
                        ['code' => 'MC ELT 106', 'name' => 'Technical Writing', 'units' => 3],
                        ['code' => 'Prof. Ed 3', 'name' => 'The Teaching Profession', 'units' => 3],
                        ['code' => 'GE 6', 'name' => 'Art Appreciation', 'units' => 3],
                        ['code' => 'GE 7', 'name' => 'Science, Technology and Society', 'units' => 3],
                        ['code' => 'GE 8', 'name' => 'Ethics', 'units' => 3],
                        ['code' => 'PATHFIT 3', 'name' => 'Dance', 'units' => 2],
                    ]
                ],

                // Second Year - Second Semester
                [
                    'year_level' => 2,
                    'sem' => 2,
                    'subjects' => [
                        ['code' => 'MC ELT 107', 'name' => 'Principles and Theories of Language Acquisition and Learning', 'units' => 3],
                        ['code' => 'MC ELT 108', 'name' => 'Speech and Theater Arts', 'units' => 3],
                        ['code' => 'MC ELT 109', 'name' => 'Children and Adolescent Literature', 'units' => 3],
                        ['code' => 'Prof. Ed 4', 'name' => 'The Teacher and the Community, School Culture and Organizational Leadership', 'units' => 3],
                        ['code' => 'GE 9', 'name' => 'Life and Works of Rizal', 'units' => 3],
                        ['code' => 'GE 10', 'name' => 'Living in the IT Era', 'units' => 3],
                        ['code' => 'PATHFIT 4', 'name' => 'Sports', 'units' => 2],
                    ]
                ],

                // Third Year - First Semester
                [
                    'year_level' => 3,
                    'sem' => 1,
                    'subjects' => [
                        ['code' => 'MC ELT 110', 'name' => 'Teaching and Assessment of Macroskills', 'units' => 3],
                        ['code' => 'MC ELT 111', 'name' => 'Teaching and Assessment of Grammar', 'units' => 3],
                        ['code' => 'MC ELT 112', 'name' => 'Language Education Research', 'units' => 3],
                        ['code' => 'MC ELT 113', 'name' => 'Literary Criticism', 'units' => 3],
                        ['code' => 'MC ELT 114', 'name' => 'Survey of Philippine Literature in English', 'units' => 3],
                        ['code' => 'MC ELT 115', 'name' => 'Teaching and Assessment of Literature Studies', 'units' => 3],
                        ['code' => 'Prof. Ed 6', 'name' => 'Facilitating Learner-centered Teaching', 'units' => 3],
                        ['code' => 'Prof. Ed 7', 'name' => 'Assessment in Learning 1', 'units' => 3],
                        ['code' => 'Prof. Ed 8', 'name' => 'Technology for Teaching and Learning 1', 'units' => 3],
                    ]
                ],

                // Third Year - Second Semester
                [
                    'year_level' => 3,
                    'sem' => 2,
                    'subjects' => [
                        ['code' => 'MC ELT 116', 'name' => 'Campus Journalism', 'units' => 3],
                        ['code' => 'MC ELT 117', 'name' => 'Survey of English and American Literature', 'units' => 3],
                        ['code' => 'MC ELT 118', 'name' => 'Contemporary, Popular and Emergent Literature', 'units' => 3],
                        ['code' => 'MC ELT 119', 'name' => 'Technology for Teaching and Learning 2', 'units' => 3],
                        ['code' => 'MC ELT 120', 'name' => 'Survey of Afro-Asian Literature', 'units' => 3],
                        ['code' => 'MC ELT 121', 'name' => 'Preparation of Language Learning Materials', 'units' => 3],
                        ['code' => 'Prof. Ed 9', 'name' => 'Assessment in Learning 2', 'units' => 3],
                        ['code' => 'Prof. Ed 10', 'name' => 'Building and Enhancing New Literacies Across the Curriculum', 'units' => 3],
                        ['code' => 'GE 12', 'name' => 'Philippine Indigenous Communities', 'units' => 3],
                    ]
                ],

                // Fourth Year - First Semester
                [
                    'year_level' => 4,
                    'sem' => 1,
                    'subjects' => [
                        ['code' => 'Prof. Ed 11', 'name' => 'Observation of Teaching Learning in Actual School Environment (FS 1)', 'units' => 3],
                        ['code' => 'Prof. Ed 12', 'name' => 'Participation and Teaching Assistantship (FS 2)', 'units' => 3],
                        ['code' => 'CLASS REVIEW', 'name' => 'Enrichment Classes', 'units' => 6],
                    ]
                ],

                // Fourth Year - Second Semester
                [
                    'year_level' => 4,
                    'sem' => 2,
                    'subjects' => [
                        ['code' => 'Prof. Ed 13', 'name' => 'Teaching Internship (Off Campus)', 'units' => 6],
                        ['code' => 'CLASS REVIEW', 'name' => 'Enrichment Classes', 'units' => 6],
                    ]
                ],
            ];

            foreach($curricula as $yearSem) {
                $yearLevel = data_get($yearSem, 'year_level');
                $sem = data_get($yearSem, 'sem');

                $subjects = data_get($yearSem, 'subjects');

                foreach($subjects as $subject) {
                    CreateNewSubjectAction::execute(new CreateNewSubjectData(
                        name: data_get($subject, 'name'),
                        code: data_get($subject, 'code'),
                        units: data_get($subject, 'units'),
                        labUnits: 0,
                        computerLabUnits: 0,
                        nstpUnits: 0,
                        description: data_get($subject,'name'),
                        semester: $sem,
                        yearLevel: $yearLevel,
                        curriculumId: $curriculum->id
                    ));
                }
            }
        }
    }
}
