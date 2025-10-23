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
        $englishCurricula = [
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

        $this->createBSEProgram('English', $englishCurricula);

        $mathCurricula = [
            // First Year - First Semester
            [
                'year_level' => 1,
                'sem' => 1,
                'subjects' => [
                    ['code' => 'MC MATH 101', 'name' => 'College Algebra', 'units' => 3],
                    ['code' => 'MC MATH 102', 'name' => 'Plane Trigonometry', 'units' => 3],
                    ['code' => 'GE 1', 'name' => 'Understanding the Self', 'units' => 3],
                    ['code' => 'GE 2', 'name' => 'Reading in the Philippine History', 'units' => 3],
                    ['code' => 'GE 3', 'name' => 'The Contemporary World', 'units' => 3],
                    ['code' => 'Prof. Ed 1', 'name' => 'The Child and Adolescent Learners and Learning Principle', 'units' => 3],
                    ['code' => 'PATHFIT 1', 'name' => 'Movement Competency Training', 'units' => 2],
                    ['code' => 'NSTP 1', 'name' => 'Civic Welfare Training Service 1', 'units' => 3],
                ]
            ],

            // First Year - Second Semester
            [
                'year_level' => 1,
                'sem' => 2,
                'subjects' => [
                    ['code' => 'MC MATH 103', 'name' => 'Solid Mensuration', 'units' => 3],
                    ['code' => 'MC MATH 104', 'name' => 'Analytic Geometry', 'units' => 3],
                    ['code' => 'GE 4', 'name' => 'Mathematics in the Modern World', 'units' => 3],
                    ['code' => 'GE 5', 'name' => 'Purposive Communication', 'units' => 3],
                    ['code' => 'Prof. Ed 2', 'name' => 'Foundation of Special and Inclusive Education', 'units' => 3],
                    ['code' => 'PATHFIT 2', 'name' => 'Exercise-based Fitness Activities', 'units' => 2],
                    ['code' => 'NSTP 2', 'name' => 'Civic Welfare Training Service 2', 'units' => 3],
                ]
            ],

            // Second Year - First Semester
            [
                'year_level' => 2,
                'sem' => 1,
                'subjects' => [
                    ['code' => 'MC MATH 105', 'name' => 'Calculus 1 (Differential Calculus)', 'units' => 4],
                    ['code' => 'MC MATH 106', 'name' => 'Logic and Set Theory', 'units' => 3],
                    ['code' => 'MC MATH 107', 'name' => 'Number Theory', 'units' => 3],
                    ['code' => 'Prof. Ed 3', 'name' => 'The Teaching Profession', 'units' => 3],
                    ['code' => 'GE 6', 'name' => 'Art Appreciation', 'units' => 3],
                    ['code' => 'GE 7', 'name' => 'Science, Technology and Society', 'units' => 3],
                    ['code' => 'PATHFIT 3', 'name' => 'Dance', 'units' => 2],
                ]
            ],

            // Second Year - Second Semester
            [
                'year_level' => 2,
                'sem' => 2,
                'subjects' => [
                    ['code' => 'MC MATH 108', 'name' => 'Calculus 2 (Integral Calculus)', 'units' => 4],
                    ['code' => 'MC MATH 109', 'name' => 'Modern Geometry', 'units' => 3],
                    ['code' => 'MC MATH 110', 'name' => 'Probability and Statistics', 'units' => 3],
                    ['code' => 'Prof. Ed 4', 'name' => 'The Teacher and the Community, School Culture and Organizational Leadership', 'units' => 3],
                    ['code' => 'GE 8', 'name' => 'Ethics', 'units' => 3],
                    ['code' => 'PATHFIT 4', 'name' => 'Sports', 'units' => 2],
                ]
            ],

            // Third Year - First Semester
            [
                'year_level' => 3,
                'sem' => 1,
                'subjects' => [
                    ['code' => 'MC MATH 111', 'name' => 'Calculus 3 (Multivariable Calculus)', 'units' => 4],
                    ['code' => 'MC MATH 112', 'name' => 'Linear Algebra', 'units' => 3],
                    ['code' => 'MC MATH 113', 'name' => 'Abstract Algebra', 'units' => 3],
                    ['code' => 'MC MATH 114', 'name' => 'Technology for Teaching and Learning in Mathematics 1', 'units' => 3],
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
                    ['code' => 'MC MATH 115', 'name' => 'History of Mathematics', 'units' => 3],
                    ['code' => 'MC MATH 116', 'name' => 'Research in Mathematics Education', 'units' => 3],
                    ['code' => 'MC MATH 117', 'name' => 'Problem Solving, Mathematical Investigation and Modeling', 'units' => 3],
                    ['code' => 'MC MATH 118', 'name' => 'Technology for Teaching and Learning in Mathematics 2', 'units' => 3],
                    ['code' => 'Prof. Ed 9', 'name' => 'Assessment in Learning 2', 'units' => 3],
                    ['code' => 'Prof. Ed 10', 'name' => 'Building and Enhancing New Literacies Across the Curriculum', 'units' => 3],
                    ['code' => 'GE 9', 'name' => 'Life and Works of Rizal', 'units' => 3],
                ]
            ],

            // Fourth Year - First Semester
            [
                'year_level' => 4,
                'sem' => 1,
                'subjects' => [
                    ['code' => 'Prof. Ed 11', 'name' => 'Observation of Teaching-Learning in Actual School Environment (FS 1)', 'units' => 3],
                    ['code' => 'Prof. Ed 12', 'name' => 'Participation and Teaching Assistantship (FS 2)', 'units' => 3],
                    ['code' => 'CLASS REVIEW', 'name' => 'Enrichment Classes / Comprehensive Exam Review', 'units' => 6],
                ]
            ],

            // Fourth Year - Second Semester
            [
                'year_level' => 4,
                'sem' => 2,
                'subjects' => [
                    ['code' => 'Prof. Ed 13', 'name' => 'Teaching Internship (Off Campus)', 'units' => 6],
                    ['code' => 'CLASS REVIEW', 'name' => 'Enrichment Classes / Board Exam Review', 'units' => 6],
                ]
            ],
        ];

        $this->createBSEProgram('Math', $mathCurricula);

        $scienceCurricula = [
            // First Year - First Semester
            [
                'year_level' => 1,
                'sem' => 1,
                'subjects' => [
                    ['code' => 'MC SCI 101', 'name' => 'Biological Science 1 (Diversity of Life)', 'units' => 3],
                    ['code' => 'MC SCI 102', 'name' => 'Inorganic Chemistry', 'units' => 3],
                    ['code' => 'GE 1', 'name' => 'Understanding the Self', 'units' => 3],
                    ['code' => 'GE 2', 'name' => 'Reading in the Philippine History', 'units' => 3],
                    ['code' => 'GE 3', 'name' => 'The Contemporary World', 'units' => 3],
                    ['code' => 'Prof. Ed 1', 'name' => 'The Child and Adolescent Learners and Learning Principles', 'units' => 3],
                    ['code' => 'PATHFIT 1', 'name' => 'Movement Competency Training', 'units' => 2],
                    ['code' => 'NSTP 1', 'name' => 'Civic Welfare Training Service 1', 'units' => 3],
                ]
            ],

            // First Year - Second Semester
            [
                'year_level' => 1,
                'sem' => 2,
                'subjects' => [
                    ['code' => 'MC SCI 103', 'name' => 'Biological Science 2 (Cell and Molecular Biology)', 'units' => 3],
                    ['code' => 'MC SCI 104', 'name' => 'Organic Chemistry', 'units' => 3],
                    ['code' => 'MC SCI 105', 'name' => 'Earth Science', 'units' => 3],
                    ['code' => 'GE 4', 'name' => 'Mathematics in the Modern World', 'units' => 3],
                    ['code' => 'GE 5', 'name' => 'Purposive Communication', 'units' => 3],
                    ['code' => 'Prof. Ed 2', 'name' => 'Foundation of Special and Inclusive Education', 'units' => 3],
                    ['code' => 'PATHFIT 2', 'name' => 'Exercise-based Fitness Activities', 'units' => 2],
                    ['code' => 'NSTP 2', 'name' => 'Civic Welfare Training Service 2', 'units' => 3],
                ]
            ],

            // Second Year - First Semester
            [
                'year_level' => 2,
                'sem' => 1,
                'subjects' => [
                    ['code' => 'MC SCI 106', 'name' => 'Physics 1 (Mechanics, Heat, and Sound)', 'units' => 4],
                    ['code' => 'MC SCI 107', 'name' => 'Environmental Science', 'units' => 3],
                    ['code' => 'MC SCI 108', 'name' => 'Science, Technology and Society', 'units' => 3],
                    ['code' => 'Prof. Ed 3', 'name' => 'The Teaching Profession', 'units' => 3],
                    ['code' => 'GE 6', 'name' => 'Art Appreciation', 'units' => 3],
                    ['code' => 'GE 7', 'name' => 'Ethics', 'units' => 3],
                    ['code' => 'PATHFIT 3', 'name' => 'Dance', 'units' => 2],
                ]
            ],

            // Second Year - Second Semester
            [
                'year_level' => 2,
                'sem' => 2,
                'subjects' => [
                    ['code' => 'MC SCI 109', 'name' => 'Physics 2 (Electricity, Magnetism, Light, and Optics)', 'units' => 4],
                    ['code' => 'MC SCI 110', 'name' => 'Analytical Chemistry', 'units' => 3],
                    ['code' => 'MC SCI 111', 'name' => 'Ecology and Evolution', 'units' => 3],
                    ['code' => 'Prof. Ed 4', 'name' => 'The Teacher and the Community, School Culture and Organizational Leadership', 'units' => 3],
                    ['code' => 'GE 8', 'name' => 'Life and Works of Rizal', 'units' => 3],
                    ['code' => 'PATHFIT 4', 'name' => 'Sports', 'units' => 2],
                ]
            ],

            // Third Year - First Semester
            [
                'year_level' => 3,
                'sem' => 1,
                'subjects' => [
                    ['code' => 'MC SCI 112', 'name' => 'Genetics and Biotechnology', 'units' => 3],
                    ['code' => 'MC SCI 113', 'name' => 'Earth and Space Science', 'units' => 3],
                    ['code' => 'MC SCI 114', 'name' => 'Research in Science Education 1', 'units' => 3],
                    ['code' => 'MC SCI 115', 'name' => 'Technology for Teaching and Learning in Science 1', 'units' => 3],
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
                    ['code' => 'MC SCI 116', 'name' => 'Microbiology and Parasitology', 'units' => 3],
                    ['code' => 'MC SCI 117', 'name' => 'Research in Science Education 2', 'units' => 3],
                    ['code' => 'MC SCI 118', 'name' => 'Science Investigatory Project', 'units' => 3],
                    ['code' => 'MC SCI 119', 'name' => 'Technology for Teaching and Learning in Science 2', 'units' => 3],
                    ['code' => 'Prof. Ed 9', 'name' => 'Assessment in Learning 2', 'units' => 3],
                    ['code' => 'Prof. Ed 10', 'name' => 'Building and Enhancing New Literacies Across the Curriculum', 'units' => 3],
                    ['code' => 'GE 9', 'name' => 'Philippine Indigenous Communities', 'units' => 3],
                ]
            ],

            // Fourth Year - First Semester
            [
                'year_level' => 4,
                'sem' => 1,
                'subjects' => [
                    ['code' => 'Prof. Ed 11', 'name' => 'Observation of Teaching-Learning in Actual School Environment (FS 1)', 'units' => 3],
                    ['code' => 'Prof. Ed 12', 'name' => 'Participation and Teaching Assistantship (FS 2)', 'units' => 3],
                    ['code' => 'CLASS REVIEW', 'name' => 'Enrichment Classes / Comprehensive Exam Review', 'units' => 6],
                ]
            ],

            // Fourth Year - Second Semester
            [
                'year_level' => 4,
                'sem' => 2,
                'subjects' => [
                    ['code' => 'Prof. Ed 13', 'name' => 'Teaching Internship (Off Campus)', 'units' => 6],
                    ['code' => 'CLASS REVIEW', 'name' => 'Enrichment Classes / Board Exam Review', 'units' => 6],
                ]
            ],
        ];

        $this->createBSEProgram('Science', $scienceCurricula);

        $filipinoCurricula = [
            // First Year - First Semester
            [
                'year_level' => 1,
                'sem' => 1,
                'subjects' => [
                    ['code' => 'MC FIL 101', 'name' => 'Introduksyon sa Pag-aaral ng Wika', 'units' => 3],
                    ['code' => 'MC FIL 102', 'name' => 'Komunikasyon sa Akademikong Filipino', 'units' => 3],
                    ['code' => 'GE 1', 'name' => 'Understanding the Self', 'units' => 3],
                    ['code' => 'GE 2', 'name' => 'Reading in the Philippine History', 'units' => 3],
                    ['code' => 'GE 3', 'name' => 'The Contemporary World', 'units' => 3],
                    ['code' => 'Prof. Ed 1', 'name' => 'The Child and Adolescent Learners and Learning Principles', 'units' => 3],
                    ['code' => 'PATHFIT 1', 'name' => 'Movement Competency Training', 'units' => 2],
                    ['code' => 'NSTP 1', 'name' => 'Civic Welfare Training Service 1', 'units' => 3],
                ]
            ],

            // First Year - Second Semester
            [
                'year_level' => 1,
                'sem' => 2,
                'subjects' => [
                    ['code' => 'MC FIL 103', 'name' => 'Pagbasa at Pagsulat Tungo sa Pananaliksik', 'units' => 3],
                    ['code' => 'MC FIL 104', 'name' => 'Gramatika at Istruktura ng Wikang Filipino', 'units' => 3],
                    ['code' => 'GE 4', 'name' => 'Mathematics in the Modern World', 'units' => 3],
                    ['code' => 'GE 5', 'name' => 'Purposive Communication', 'units' => 3],
                    ['code' => 'Prof. Ed 2', 'name' => 'Foundation of Special and Inclusive Education', 'units' => 3],
                    ['code' => 'PATHFIT 2', 'name' => 'Exercise-based Fitness Activities', 'units' => 2],
                    ['code' => 'NSTP 2', 'name' => 'Civic Welfare Training Service 2', 'units' => 3],
                ]
            ],

            // Second Year - First Semester
            [
                'year_level' => 2,
                'sem' => 1,
                'subjects' => [
                    ['code' => 'MC FIL 105', 'name' => 'Panitikan ng Pilipinas', 'units' => 3],
                    ['code' => 'MC FIL 106', 'name' => 'Masining na Pagpapahayag', 'units' => 3],
                    ['code' => 'MC FIL 107', 'name' => 'Introduksyon sa Pagsasalin', 'units' => 3],
                    ['code' => 'Prof. Ed 3', 'name' => 'The Teaching Profession', 'units' => 3],
                    ['code' => 'GE 6', 'name' => 'Art Appreciation', 'units' => 3],
                    ['code' => 'GE 7', 'name' => 'Science, Technology and Society', 'units' => 3],
                    ['code' => 'PATHFIT 3', 'name' => 'Dance', 'units' => 2],
                ]
            ],

            // Second Year - Second Semester
            [
                'year_level' => 2,
                'sem' => 2,
                'subjects' => [
                    ['code' => 'MC FIL 108', 'name' => 'Pagbasa at Pagsusuri ng Iba’t Ibang Teksto Tungo sa Pananaliksik', 'units' => 3],
                    ['code' => 'MC FIL 109', 'name' => 'Wika, Kultura at Lipunan', 'units' => 3],
                    ['code' => 'MC FIL 110', 'name' => 'Panitikang Pandaigdig', 'units' => 3],
                    ['code' => 'Prof. Ed 4', 'name' => 'The Teacher and the Community, School Culture and Organizational Leadership', 'units' => 3],
                    ['code' => 'GE 8', 'name' => 'Ethics', 'units' => 3],
                    ['code' => 'PATHFIT 4', 'name' => 'Sports', 'units' => 2],
                ]
            ],

            // Third Year - First Semester
            [
                'year_level' => 3,
                'sem' => 1,
                'subjects' => [
                    ['code' => 'MC FIL 111', 'name' => 'Introduksyon sa Linggwistikang Filipino', 'units' => 3],
                    ['code' => 'MC FIL 112', 'name' => 'Pagtuturo at Pagtataya ng Makrong Kasanayang Pangwika', 'units' => 3],
                    ['code' => 'MC FIL 113', 'name' => 'Pananaliksik sa Filipino 1', 'units' => 3],
                    ['code' => 'MC FIL 114', 'name' => 'Pagtuturo at Pagtataya ng Panitikan', 'units' => 3],
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
                    ['code' => 'MC FIL 115', 'name' => 'Pananaliksik sa Filipino 2', 'units' => 3],
                    ['code' => 'MC FIL 116', 'name' => 'Pagtuturo at Pagtataya sa Estruktura ng Wikang Filipino', 'units' => 3],
                    ['code' => 'MC FIL 117', 'name' => 'Retorika', 'units' => 3],
                    ['code' => 'MC FIL 118', 'name' => 'Kontekstuwalisadong Komunikasyon sa Filipino', 'units' => 3],
                    ['code' => 'Prof. Ed 9', 'name' => 'Assessment in Learning 2', 'units' => 3],
                    ['code' => 'Prof. Ed 10', 'name' => 'Building and Enhancing New Literacies Across the Curriculum', 'units' => 3],
                    ['code' => 'GE 9', 'name' => 'Life and Works of Rizal', 'units' => 3],
                ]
            ],

            // Fourth Year - First Semester
            [
                'year_level' => 4,
                'sem' => 1,
                'subjects' => [
                    ['code' => 'Prof. Ed 11', 'name' => 'Observation of Teaching-Learning in Actual School Environment (FS 1)', 'units' => 3],
                    ['code' => 'Prof. Ed 12', 'name' => 'Participation and Teaching Assistantship (FS 2)', 'units' => 3],
                    ['code' => 'CLASS REVIEW', 'name' => 'Enrichment Classes / Comprehensive Exam Review', 'units' => 6],
                ]
            ],

            // Fourth Year - Second Semester
            [
                'year_level' => 4,
                'sem' => 2,
                'subjects' => [
                    ['code' => 'Prof. Ed 13', 'name' => 'Teaching Internship (Off Campus)', 'units' => 6],
                    ['code' => 'CLASS REVIEW', 'name' => 'Enrichment Classes / Board Exam Review', 'units' => 6],
                ]
            ],
        ];

        $this->createBSEProgram('Filipino', $filipinoCurricula);
    }

    private function createBSEProgram(string $major, array $curricula): void
    {
        if (Program::where('code', 'BSE')->where('major', $major)->count() === 0) {
            $department = Department::createOrFirst([
                'name' => 'Education',
            ]);

            $program = Program::create([
                'name' => 'Bachelor of Secondary Education',
                'major' => $major,
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
