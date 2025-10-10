@props([
    'studentProgram' => null,
    'purpose' => 'any',
    'dateOfAdmission' => now()->format('Y'),
    'dateOfGraduation' => now()->format('F d, Y'),
    'checker' => auth()->user()->name,
    'signatory' => auth()->user()->name,
    'dateOfReleased' => now()->format('F d, Y'),
    'soNumber' => null,
])

@php

    $grades = \App\Models\Grade::where('student_id', $studentProgram->student_id)->get();
    $firstYearFirstSem = $studentProgram->curriculum->curriculumSubjects->where('year_level', \App\Enums\YearLevel::First)->where('semester', \App\Enums\Semester::First);
    $firstYearSecondSem = $studentProgram->curriculum->curriculumSubjects->where('year_level', \App\Enums\YearLevel::First)->where('semester', \App\Enums\Semester::Second);
    $secondYearFirstSem = $studentProgram->curriculum->curriculumSubjects->where('year_level', \App\Enums\YearLevel::Second)->where('semester', \App\Enums\Semester::First);
    $secondYearSecondSem = $studentProgram->curriculum->curriculumSubjects->where('year_level', \App\Enums\YearLevel::Second)->where('semester', \App\Enums\Semester::Second);
    $thirdYearFirstSem = $studentProgram->curriculum->curriculumSubjects->where('year_level', \App\Enums\YearLevel::Third)->where('semester', \App\Enums\Semester::First);
    $thirdYearSecondSem = $studentProgram->curriculum->curriculumSubjects->where('year_level', \App\Enums\YearLevel::Third)->where('semester', \App\Enums\Semester::Second);
    $fourthYearFirstSem = $studentProgram->curriculum->curriculumSubjects->where('year_level', \App\Enums\YearLevel::Fourth)->where('semester', \App\Enums\Semester::First);
    $fourthYearSecondSem = $studentProgram->curriculum->curriculumSubjects->where('year_level', \App\Enums\YearLevel::Fourth)->where('semester', \App\Enums\Semester::Second);
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TOR</title>
    <style>
        .page-break {
            page-break-after: always;
        }
    </style>
    @vite('resources/css/app.css')
</head>
<body class="w-full min-h-screen h-full flex flex-col items-center">
    <div class="min-h-screen h-full flex flex-col justify-between w-full relative">
        <img src="{{ asset('logo.png') }}" alt="Logo" class="w-28 h-28 absolute top-4 left-32">
        <img src="{{ asset('logo.png') }}" alt="Logo" class="w-2/3 absolute transform-[translateX(-50%)] left-1/2 bottom-40 opacity-5">
        <div class="w-full max-w-full min-h-screen h-full flex flex-col items-center justify-between p-4 text-[12px]">
            <div class="w-full flex flex-col justify-between h-full">
                <section class="w-full flex flex-col">
                    <div class="w-full h-full flex flex-col items-center justify-center">
                        <h5 class="">Republic of the Philippines</h5>
                        <h5 class="">Commission of Higher Education</h5>
                        <h5 class="">Region V - Bicol</h5>
                        <h4 class="uppercase font-bold text-blue-500">Calabanga Community College</h4>
                        <h5 class="">Belen, Calabanga, Camarines Sur</h5>
                        <h5 class="font-bold mt-2 uppercase">Office of the Registrar</h5>
                        <hr class="w-full mt-2 border" />
                        <hr class="w-full my-2 border-[0.5]" />
                        <h5 class="mt-1 uppercase font-bold">Official Transcript of Records</h5>
                    </div>
                    <div class="w-full h-full flex flex-col items-center mt-4 text-left px-16 text-[10px]">
                        <div class="w-full flex flex-col">
                            <div class="grid grid-cols-3">
                                <div><span>Name: </span><b class="underline uppercase">{{ $studentProgram->student->full_name }}</b></div>
                                <div><span>Gender: </span><span class="underline uppercase">{{ $studentProgram->student->others ? $studentProgram->student->others['gender'] : '' }}</span></div>
                                <div><span>Citizenship: </span><span class="underline uppercase">{{ $studentProgram->student->citizenship }}</span></div>
                            </div>
                            <div class="w-full grid grid-cols-3">
                                <div class="col-span-2"><span>Address: </span><span class="underline">{{ $studentProgram->student->address }}</span></div>
                                <span class="uppercase">Entrance Data</span>
                            </div>
                            <div class="w-full grid grid-cols-4">
                                <div><span>Date of Birth: </span><span class="underline">{{ $studentProgram->student->date_of_birth->format('F d, Y') }}</span></div>
                                <div></div>
                                <div><span>Date of Admission: </span><span class="underline">{{ $dateOfAdmission }}</span></div>
                            </div>
                            <div class="w-full grid grid-cols-4">
                                <div><span>College of: </span><span class="underline">{{ $studentProgram->program->department->name }}</span></div>
                                <div></div>
                                <div><span>Elem. School: </span><span class="underline">{{ $studentProgram->student->elementary_school }}</span></div>
                            </div>
                            <div class="w-full grid grid-cols-4">
                                <div class="col-span-2"><span>Date of Graduation: </span><span class="underline">{{ $dateOfGraduation }}</span></div>
                                <div class="col-span-2"><span>High School: </span><span class="underline">{{ $studentProgram->student->highschool_school }}</span></div>
                            </div>
                            <div class="w-full grid grid-cols-4">
                                <div class="col-span-2"><span>Degree/Title Conferred: </span><span class="underline">{{ $studentProgram->program->name }}</span></div>
                                <div class="col-span-2"><span>Address: </span><span class="underline">{{ $studentProgram->student->address }}</span></div>
                            </div>
                            @isset($studentProgram->program->major)
                                <div class="w-full grid grid-cols-4">
                                    <div class="col-span-2"><span>Major: </span><span class="underline">{{ $studentProgram->program->major }}</span></div>
                                </div>
                            @endisset

                        </div>
                    </div>
                </section>
                <section class="w-full h-full flex flex-col items-center text-left px-16 text-xs">
                    <table class="mt-4 border -mx-4 text-[8px] max-h-[550px] w-full">
                        <thead>
                        <tr>
                            <th class="border px-1 py-0.5 text-center">Term</th>
                            <th class="border px-1 py-0.5 text-center">Course No.</th>
                            <th class="border px-1 py-0.5 text-center uppercase">Description/Subjects</th>
                            <th class="border px-1 py-0.5 text-center uppercase">Grades</th>
                            <th class="border px-1 py-0.5 text-center uppercase">CG/RG</th>
                            <th class="border px-1 py-0.5 text-center uppercase">Credit Units</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="border-x"></td>
                            <td class="border-x"></td>
                            <td class="border-x text-center"><span class="font-bold uppercase underline">{{ $studentProgram->program->name }}</span></td>
                            <td class="border-x"></td>
                            <td class="border-x"></td>
                            <td class="border-x"></td>
                        </tr>
                        @isset($studentProgram->program->major)
                            <tr>
                                <td class="border-x"></td>
                                <td class="border-x"></td>
                                <td class="border-x text-center"><span class="underline">Major in {{ $studentProgram->program->major }}</span></td>
                                <td class="border-x"></td>
                                <td class="border-x"></td>
                                <td class="border-x"></td>
                            </tr>
                        @endisset
                        <tr class="h-6">
                            <td class="border-x"></td>
                            <td class="border-x"></td>
                            <td class="border-x"></td>
                            <td class="border-x"></td>
                            <td class="border-x"></td>
                            <td class="border-x"></td>
                        </tr>
                        @foreach($firstYearFirstSem as $subjects)
                            <tr>
                                <td class="border-x px-2">@if($loop->first) 1<sup>st</sup> Semester @endif</td>
                                <td class="border-x px-2">{{ $subjects->subject->code }}</td>
                                <td class="border-x px-2">{{ $subjects->subject->name }}</td>
                                <td class="border-x text-center w-6">
                                    @php
                                        $grade = $grades->where('subject_id', $subjects->subject_id)->first();

                                        if(!$grade){
                                            echo '';
                                        }

                                        echo $grade->average;
                                    @endphp
                                </td>
                                <td class="border-x"></td>
                                <td class="border-x text-center w-4">{{ $subjects->subject->units }}</td>
                            </tr>
                        @endforeach
                        <tr class="h-6">
                            <td class="border-x"></td>
                            <td class="border-x"></td>
                            <td class="border-x"></td>
                            <td class="border-x"></td>
                            <td class="border-x"></td>
                            <td class="border-x"></td>
                        </tr>
                        @foreach($firstYearSecondSem as $subjects)
                            <tr>
                                <td class="border-x px-2">@if($loop->first) 2<sup>nd</sup> Semester @endif</td>
                                <td class="border-x px-2">{{ $subjects->subject->code }}</td>
                                <td class="border-x px-2">{{ $subjects->subject->name }}</td>
                                <td class="border-x text-center w-6">
                                    @php
                                        $grade = $grades->where('subject_id', $subjects->subject_id)->first();

                                        if(!$grade){
                                            echo '';
                                        }

                                        echo $grade->average;
                                    @endphp
                                </td>
                                <td class="border-x"></td>
                                <td class="border-x text-center w-4">{{ $subjects->subject->units }}</td>
                            </tr>
                        @endforeach
                        <tr class="h-6">
                            <td class="border-x"></td>
                            <td class="border-x"></td>
                            <td class="border-x"></td>
                            <td class="border-x"></td>
                            <td class="border-x"></td>
                            <td class="border-x"></td>
                        </tr>
                        @foreach($secondYearFirstSem as $subjects)
                            <tr>
                                <td class="border-x px-2">@if($loop->first) 1<sup>st</sup> Semester @endif</td>
                                <td class="border-x px-2">{{ $subjects->subject->code }}</td>
                                <td class="border-x px-2">{{ $subjects->subject->name }}</td>
                                <td class="border-x text-center w-6">
                                    @php
                                        $grade = $grades->where('subject_id', $subjects->subject_id)->first();

                                        if(!$grade){
                                            echo '';
                                        }

                                        echo $grade->average;
                                    @endphp
                                </td>
                                <td class="border-x"></td>
                                <td class="border-x text-center w-4">{{ $subjects->subject->units }}</td>
                            </tr>
                        @endforeach
                        <tr class="h-2">
                            <td class="border-x"></td>
                            <td class="border-x"></td>
                            <td class="border-x italic text-center">Page 1 of 3</td>
                            <td class="border-x"></td>
                            <td class="border-x"></td>
                            <td class="border-x"></td>
                        </tr>
                        </tbody>
                    </table>
                </section>
            </div>
            <section class="w-full flex flex-col">
                <div class="w-full flex flex-col px-12 font-serif text-[8px]">
                    <div class="w-full mt-2">
                        <b>Grading System</b>
                    </div>
                    <div class="w-full grid grid-cols-8">
                        <div class="flex flex-col">
                            <span>1.0 — 100</span>
                            <span>1.1 — 99</span>
                            <span>1.2 — 98</span>
                            <span>1.25 — 97</span>
                            <span>1.3 — 96</span>
                        </div>
                        <div class="flex flex-col">
                            <span>1.4 — 95</span>
                            <span>1.5 — 94</span>
                            <span>1.6 — 93</span>
                            <span>1.7 — 92</span>
                            <span>1.75 — 91</span>
                        </div>
                        <div class="flex flex-col">
                            <span>1.8 — 90</span>
                            <span>1.9 — 89</span>
                            <span>2.0 — 88</span>
                            <span>2.1 — 87</span>
                            <span>2.2 — 86</span>
                        </div>
                        <div class="flex flex-col">
                            <span>2.25 — 85</span>
                            <span>2.3 — 84</span>
                            <span>2.4 — 83</span>
                            <span>2.5 — 82</span>
                            <span>2.6 — 81</span>
                        </div>
                        <div class="flex flex-col">
                            <span>2.7 — 80</span>
                            <span>2.75 — 79</span>
                            <span>2.8 — 78</span>
                            <span>2.9 — 77</span>
                            <span>3.0 — 76-75</span>
                        </div>
                        <div class="flex flex-col col-span-2">
                            <span>4 — Conditional 5 — 70 and Below (Failed)</span>
                            <span>DO — Dropped Officially</span>
                            <span>UD — Unauthorized Dropping</span>
                            <span>DFS — Dropped w/ Failure Standing</span>
                            <span>Dropped for Exceed 20% Absences</span>
                        </div>
                        <div class="flex flex-col">
                            <span>INC — Incomplete</span>
                            <span>NG — No Grad</span>
                        </div>
                    </div>
                </div>
                <div class="w-full flex flex-col mt-2 px-12 text-xs">
                    <hr class="border-t-2 border-black" />
                    <div>Copy valid for: <b>{{ $purpose }}</b></div>
                    <div>Prepared by: <b>{{ auth()->user()->name }}</b></div>
                    <div class="flex justify-between">
                        <span>Checked by: <b>{{ $checker }}</b></span>
                        <span>Date Issued: <span>{{ now()->format('m/d/Y') }}</span></span>
                    </div>
                    <hr class="border-t-2 border-black" />
                </div>
                <div class="w-full flex flex-col mt-2 px-16">
                    <div class="flex justify-between">
                        <div class="flex flex-col"><span>(NOT VALID WITHOUT)</span><span>(THE COLLEGE SEAL)</span></div>
                        <div class="flex flex-col">
                            <span class="mt-4"><b>{{ $signatory }}</b></span>
                            <span>College Registrar</span>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <div class="min-h-screen h-full flex flex-col justify-between w-full relative">
        <img src="{{ asset('logo.png') }}" alt="Logo" class="w-28 h-28 absolute top-4 left-32">
        <img src="{{ asset('logo.png') }}" alt="Logo" class="w-2/3 absolute transform-[translateX(-50%)] left-1/2 bottom-40 opacity-5">
        <div class="w-full max-w-full min-h-screen h-full flex flex-col items-center justify-between p-4 text-[12px]">
            <div class="w-full flex flex-col justify-between h-full">
                <section class="w-full flex flex-col">
                    <div class="w-full h-full flex flex-col items-center justify-center">
                        <h5 class="">Republic of the Philippines</h5>
                        <h5 class="">Commission of Higher Education</h5>
                        <h5 class="">Region V - Bicol</h5>
                        <h4 class="uppercase font-bold text-blue-500">Calabanga Community College</h4>
                        <h5 class="">Belen, Calabanga, Camarines Sur</h5>
                        <h5 class="font-bold mt-2 uppercase">Office of the Registrar</h5>
                        <hr class="w-full mt-2 border" />
                        <hr class="w-full my-2 border-[0.5]" />
                        <h5 class="mt-1 uppercase font-bold">Official Transcript of Records</h5>
                    </div>
                    <div class="w-full h-full flex flex-col items-center mt-4 text-left px-16 text-[10px]">
                        <div class="w-full flex flex-col">
                            <div class="grid grid-cols-3">
                                <div><span>Name: </span><b class="underline uppercase">{{ $studentProgram->student->full_name }}</b></div>
                                <div><span>Gender: </span><span class="underline uppercase">{{ $studentProgram->student->others ? $studentProgram->student->others['gender'] : '' }}</span></div>
                                <div><span>Citizenship: </span><span class="underline uppercase">{{ $studentProgram->student->citizenship }}</span></div>
                            </div>
                            <div class="w-full grid grid-cols-3">
                                <div class="col-span-2"><span>Address: </span><span class="underline">{{ $studentProgram->student->address }}</span></div>
                                <span class="uppercase">Entrance Data</span>
                            </div>
                            <div class="w-full grid grid-cols-4">
                                <div><span>Date of Birth: </span><span class="underline">{{ $studentProgram->student->date_of_birth->format('F d, Y') }}</span></div>
                                <div></div>
                                <div><span>Date of Admission: </span><span class="underline">{{ $dateOfAdmission }}</span></div>
                            </div>
                            <div class="w-full grid grid-cols-4">
                                <div><span>College of: </span><span class="underline">{{ $studentProgram->program->department->name }}</span></div>
                                <div></div>
                                <div><span>Elem. School: </span><span class="underline">{{ $studentProgram->student->elementary_school }}</span></div>
                            </div>
                            <div class="w-full grid grid-cols-4">
                                <div class="col-span-2"><span>Date of Graduation: </span><span class="underline">{{ $dateOfGraduation }}</span></div>
                                <div class="col-span-2"><span>High School: </span><span class="underline">{{ $studentProgram->student->highschool_school }}</span></div>
                            </div>
                            <div class="w-full grid grid-cols-4">
                                <div class="col-span-2"><span>Degree/Title Conferred: </span><span class="underline">{{ $studentProgram->program->name }}</span></div>
                                <div class="col-span-2"><span>Address: </span><span class="underline">{{ $studentProgram->student->address }}</span></div>
                            </div>
                            @isset($studentProgram->program->major)
                                <div class="w-full grid grid-cols-4">
                                    <div class="col-span-2"><span>Major: </span><span class="underline">{{ $studentProgram->program->major }}</span></div>
                                </div>
                            @endisset

                        </div>
                    </div>
                </section>
                <section class="w-full h-full flex flex-col items-center text-left px-16 text-xs">
                    <table class="mt-4 border -mx-4 text-[8px] max-h-[550px] w-full">
                        <thead>
                        <tr>
                            <th class="border px-1 py-0.5 text-center">Term</th>
                            <th class="border px-1 py-0.5 text-center">Course No.</th>
                            <th class="border px-1 py-0.5 text-center uppercase">Description/Subjects</th>
                            <th class="border px-1 py-0.5 text-center uppercase">Grades</th>
                            <th class="border px-1 py-0.5 text-center uppercase">CG/RG</th>
                            <th class="border px-1 py-0.5 text-center uppercase">Credit Units</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($secondYearSecondSem as $subjects)
                            <tr>
                                <td class="border-x px-2">@if($loop->first) 2<sup>nd</sup> Semester @endif</td>
                                <td class="border-x px-2">{{ $subjects->subject->code }}</td>
                                <td class="border-x px-2">{{ $subjects->subject->name }}</td>
                                <td class="border-x text-center w-6">
                                    @php
                                        $grade = $grades->where('subject_id', $subjects->subject_id)->first();

                                        if(!$grade){
                                            echo '';
                                        }

                                        echo $grade->average;
                                    @endphp
                                </td>
                                <td class="border-x"></td>
                                <td class="border-x text-center w-4">{{ $subjects->subject->units }}</td>
                            </tr>
                        @endforeach
                        <tr class="h-6">
                            <td class="border-x"></td>
                            <td class="border-x"></td>
                            <td class="border-x"></td>
                            <td class="border-x"></td>
                            <td class="border-x"></td>
                            <td class="border-x"></td>
                        </tr>
                        @foreach($thirdYearFirstSem as $subjects)
                            <tr>
                                <td class="border-x px-2">@if($loop->first) 1<sup>st</sup> Semester @endif</td>
                                <td class="border-x px-2">{{ $subjects->subject->code }}</td>
                                <td class="border-x px-2">{{ $subjects->subject->name }}</td>
                                <td class="border-x text-center w-6">
                                    @php
                                        $grade = $grades->where('subject_id', $subjects->subject_id)->first();

                                        if(!$grade){
                                            echo '';
                                        }

                                        echo $grade->average;
                                    @endphp
                                </td>
                                <td class="border-x"></td>
                                <td class="border-x text-center w-4">{{ $subjects->subject->units }}</td>
                            </tr>
                        @endforeach
                        <tr class="h-6">
                            <td class="border-x"></td>
                            <td class="border-x"></td>
                            <td class="border-x"></td>
                            <td class="border-x"></td>
                            <td class="border-x"></td>
                            <td class="border-x"></td>
                        </tr>
                        @foreach($thirdYearSecondSem as $subjects)
                            <tr>
                                <td class="border-x px-2">@if($loop->first) 2<sup>nd</sup> Semester @endif</td>
                                <td class="border-x px-2">{{ $subjects->subject->code }}</td>
                                <td class="border-x px-2">{{ $subjects->subject->name }}</td>
                                <td class="border-x text-center w-6">
                                    @php
                                        $grade = $grades->where('subject_id', $subjects->subject_id)->first();

                                        if(!$grade){
                                            echo '';
                                        }

                                        echo $grade->average;
                                    @endphp
                                </td>
                                <td class="border-x"></td>
                                <td class="border-x text-center w-4">{{ $subjects->subject->units }}</td>
                            </tr>
                        @endforeach
                        <tr class="h-2">
                            <td class="border-x"></td>
                            <td class="border-x"></td>
                            <td class="border-x italic text-center">Page 2 of 3</td>
                            <td class="border-x"></td>
                            <td class="border-x"></td>
                            <td class="border-x"></td>
                        </tr>
                        </tbody>
                    </table>
                </section>
            </div>
            <section class="w-full flex flex-col">
                <div class="w-full flex flex-col px-12 font-serif text-[8px]">
                    <div class="w-full mt-2">
                        <b>Grading System</b>
                    </div>
                    <div class="w-full grid grid-cols-8">
                        <div class="flex flex-col">
                            <span>1.0 — 100</span>
                            <span>1.1 — 99</span>
                            <span>1.2 — 98</span>
                            <span>1.25 — 97</span>
                            <span>1.3 — 96</span>
                        </div>
                        <div class="flex flex-col">
                            <span>1.4 — 95</span>
                            <span>1.5 — 94</span>
                            <span>1.6 — 93</span>
                            <span>1.7 — 92</span>
                            <span>1.75 — 91</span>
                        </div>
                        <div class="flex flex-col">
                            <span>1.8 — 90</span>
                            <span>1.9 — 89</span>
                            <span>2.0 — 88</span>
                            <span>2.1 — 87</span>
                            <span>2.2 — 86</span>
                        </div>
                        <div class="flex flex-col">
                            <span>2.25 — 85</span>
                            <span>2.3 — 84</span>
                            <span>2.4 — 83</span>
                            <span>2.5 — 82</span>
                            <span>2.6 — 81</span>
                        </div>
                        <div class="flex flex-col">
                            <span>2.7 — 80</span>
                            <span>2.75 — 79</span>
                            <span>2.8 — 78</span>
                            <span>2.9 — 77</span>
                            <span>3.0 — 76-75</span>
                        </div>
                        <div class="flex flex-col col-span-2">
                            <span>4 — Conditional 5 — 70 and Below (Failed)</span>
                            <span>DO — Dropped Officially</span>
                            <span>UD — Unauthorized Dropping</span>
                            <span>DFS — Dropped w/ Failure Standing</span>
                            <span>Dropped for Exceed 20% Absences</span>
                        </div>
                        <div class="flex flex-col">
                            <span>INC — Incomplete</span>
                            <span>NG — No Grad</span>
                        </div>
                    </div>
                </div>
                <div class="w-full flex flex-col mt-2 px-12 text-xs">
                    <hr class="border-t-2 border-black" />
                    <div>Copy valid for: <b>{{ $purpose }}</b></div>
                    <div>Prepared by: <b>{{ auth()->user()->name }}</b></div>
                    <div class="flex justify-between">
                        <span>Checked by: <b>{{ $checker }}</b></span>
                        <span>Date Issued: <span>{{ now()->format('m/d/Y') }}</span></span>
                    </div>
                    <hr class="border-t-2 border-black" />
                </div>
                <div class="w-full flex flex-col mt-2 px-16">
                    <div class="flex justify-between">
                        <div class="flex flex-col"><span>(NOT VALID WITHOUT)</span><span>(THE COLLEGE SEAL)</span></div>
                        <div class="flex flex-col">
                            <span class="mt-4"><b>{{ $signatory }}</b></span>
                            <span>College Registrar</span>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <div class="min-h-screen h-full flex flex-col justify-between w-full relative">
        <img src="{{ asset('logo.png') }}" alt="Logo" class="w-28 h-28 absolute top-4 left-32">
        <img src="{{ asset('logo.png') }}" alt="Logo" class="w-2/3 absolute transform-[translateX(-50%)] left-1/2 bottom-40 opacity-5">
        <div class="w-full max-w-full min-h-screen h-full flex flex-col items-center justify-between p-4 text-[12px]">
            <div class="w-full flex flex-col justify-between h-full">
                <section class="w-full flex flex-col">
                    <div class="w-full h-full flex flex-col items-center justify-center">
                        <h5 class="">Republic of the Philippines</h5>
                        <h5 class="">Commission of Higher Education</h5>
                        <h5 class="">Region V - Bicol</h5>
                        <h4 class="uppercase font-bold text-blue-500">Calabanga Community College</h4>
                        <h5 class="">Belen, Calabanga, Camarines Sur</h5>
                        <h5 class="font-bold mt-2 uppercase">Office of the Registrar</h5>
                        <hr class="w-full mt-2 border" />
                        <hr class="w-full my-2 border-[0.5]" />
                        <h5 class="mt-1 uppercase font-bold">Official Transcript of Records</h5>
                    </div>
                    <div class="w-full h-full flex flex-col items-center mt-4 text-left px-16 text-[10px]">
                        <div class="w-full flex flex-col">
                            <div class="grid grid-cols-3">
                                <div><span>Name: </span><b class="underline uppercase">{{ $studentProgram->student->full_name }}</b></div>
                                <div><span>Gender: </span><span class="underline uppercase">{{ $studentProgram->student->others ? $studentProgram->student->others['gender'] : '' }}</span></div>
                                <div><span>Citizenship: </span><span class="underline uppercase">{{ $studentProgram->student->citizenship }}</span></div>
                            </div>
                            <div class="w-full grid grid-cols-3">
                                <div class="col-span-2"><span>Address: </span><span class="underline">{{ $studentProgram->student->address }}</span></div>
                                <span class="uppercase">Entrance Data</span>
                            </div>
                            <div class="w-full grid grid-cols-4">
                                <div><span>Date of Birth: </span><span class="underline">{{ $studentProgram->student->date_of_birth->format('F d, Y') }}</span></div>
                                <div></div>
                                <div><span>Date of Admission: </span><span class="underline">{{ $dateOfAdmission }}</span></div>
                            </div>
                            <div class="w-full grid grid-cols-4">
                                <div><span>College of: </span><span class="underline">{{ $studentProgram->program->department->name }}</span></div>
                                <div></div>
                                <div><span>Elem. School: </span><span class="underline">{{ $studentProgram->student->elementary_school }}</span></div>
                            </div>
                            <div class="w-full grid grid-cols-4">
                                <div class="col-span-2"><span>Date of Graduation: </span><span class="underline">{{ $dateOfGraduation }}</span></div>
                                <div class="col-span-2"><span>High School: </span><span class="underline">{{ $studentProgram->student->highschool_school }}</span></div>
                            </div>
                            <div class="w-full grid grid-cols-4">
                                <div class="col-span-2"><span>Degree/Title Conferred: </span><span class="underline">{{ $studentProgram->program->name }}</span></div>
                                <div class="col-span-2"><span>Address: </span><span class="underline">{{ $studentProgram->student->address }}</span></div>
                            </div>
                            @isset($studentProgram->program->major)
                                <div class="w-full grid grid-cols-4">
                                    <div class="col-span-2"><span>Major: </span><span class="underline">{{ $studentProgram->program->major }}</span></div>
                                </div>
                            @endisset

                        </div>
                    </div>
                </section>
                <section class="w-full h-full flex flex-col items-center text-left px-16 text-xs">
                    <table class="mt-4 border -mx-4 text-[8px] max-h-[550px] w-full">
                        <thead>
                        <tr>
                            <th class="border px-1 py-0.5 text-center">Term</th>
                            <th class="border px-1 py-0.5 text-center">Course No.</th>
                            <th class="border px-1 py-0.5 text-center uppercase">Description/Subjects</th>
                            <th class="border px-1 py-0.5 text-center uppercase">Grades</th>
                            <th class="border px-1 py-0.5 text-center uppercase">CG/RG</th>
                            <th class="border px-1 py-0.5 text-center uppercase">Credit Units</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($fourthYearFirstSem as $subjects)
                            <tr>
                                <td class="border-x px-2">@if($loop->first) 1<sup>st</sup> Semester @endif</td>
                                <td class="border-x px-2">{{ $subjects->subject->code }}</td>
                                <td class="border-x px-2">{{ $subjects->subject->name }}</td>
                                <td class="border-x text-center w-6">
                                    @php
                                        $grade = $grades->where('subject_id', $subjects->subject_id)->first();

                                        if(!$grade){
                                            echo '';
                                        }

                                        echo $grade->average;
                                    @endphp
                                </td>
                                <td class="border-x"></td>
                                <td class="border-x text-center w-4">{{ $subjects->subject->units }}</td>
                            </tr>
                        @endforeach
                        <tr class="h-6">
                            <td class="border-x"></td>
                            <td class="border-x"></td>
                            <td class="border-x"></td>
                            <td class="border-x"></td>
                            <td class="border-x"></td>
                            <td class="border-x"></td>
                        </tr>
                        @foreach($fourthYearSecondSem as $subjects)
                            <tr>
                                <td class="border-x px-2">@if($loop->first) 2<sup>nd</sup> Semester @endif</td>
                                <td class="border-x px-2">{{ $subjects->subject->code }}</td>
                                <td class="border-x px-2">{{ $subjects->subject->name }}</td>
                                <td class="border-x text-center w-6">
                                    @php
                                        $grade = $grades->where('subject_id', $subjects->subject_id)->first();

                                        if(!$grade){
                                            echo '';
                                        }

                                        echo $grade->average;
                                    @endphp
                                </td>
                                <td class="border-x"></td>
                                <td class="border-x text-center w-4">{{ $subjects->subject->units }}</td>
                            </tr>
                        @endforeach
                        <tr class="h-6">
                            <td class="border-x"></td>
                            <td class="border-x"></td>
                            <td class="border-x"></td>
                            <td class="border-x"></td>
                            <td class="border-x"></td>
                            <td class="border-x"></td>
                        </tr>
                        <tr class="h-2">
                            <td class="border-x"></td>
                            <td class="border-x"></td>
                            <td class="border-x italic text-center">Page 3 of 3</td>
                            <td class="border-x"></td>
                            <td class="border-x"></td>
                            <td class="border-x"></td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="flex flex-col w-full mt-4">
                        <p class="text-center">ccccccccccccccccccccccccccccccccccccccc Nothing Follows ccccccccccccccccccccccccccccccccccccccc</p>
                        <p class="text-center italic font-bold">"Graduated with the degree of {{ $studentProgram->program->name }} @isset($studentProgram->program->major) major in {{ $studentProgram->program->major }} @endisset last {{ $dateOfGraduation }} and his/her degree is covered by Certificate of Program Compliance No. 53 s. 2021".</p>
                    </div>
                    <div class="flex flex-col w-full mt-4">
                        <div><span class="italic">Special Order No.: &emsp;</span><b>{{ $soNumber ?? $studentProgram->student->special_order_no }}</b></div>
                        <div><span class="italic">Date of Released: &emsp;&emsp;</span><b>{{ $dateOfReleased }}</b></div>
                        <div><span class="italic">NSTP Serial No. &emsp;&emsp;&emsp; </span><b>{{ $studentProgram->student->nstp_serial_no }}</b></div>
                    </div>
                </section>
            </div>
            <section class="w-full flex flex-col">
                <div class="w-full flex flex-col px-12 font-serif text-[8px]">
                    <div class="w-full mt-2">
                        <b>Grading System</b>
                    </div>
                    <div class="w-full grid grid-cols-8">
                        <div class="flex flex-col">
                            <span>1.0 — 100</span>
                            <span>1.1 — 99</span>
                            <span>1.2 — 98</span>
                            <span>1.25 — 97</span>
                            <span>1.3 — 96</span>
                        </div>
                        <div class="flex flex-col">
                            <span>1.4 — 95</span>
                            <span>1.5 — 94</span>
                            <span>1.6 — 93</span>
                            <span>1.7 — 92</span>
                            <span>1.75 — 91</span>
                        </div>
                        <div class="flex flex-col">
                            <span>1.8 — 90</span>
                            <span>1.9 — 89</span>
                            <span>2.0 — 88</span>
                            <span>2.1 — 87</span>
                            <span>2.2 — 86</span>
                        </div>
                        <div class="flex flex-col">
                            <span>2.25 — 85</span>
                            <span>2.3 — 84</span>
                            <span>2.4 — 83</span>
                            <span>2.5 — 82</span>
                            <span>2.6 — 81</span>
                        </div>
                        <div class="flex flex-col">
                            <span>2.7 — 80</span>
                            <span>2.75 — 79</span>
                            <span>2.8 — 78</span>
                            <span>2.9 — 77</span>
                            <span>3.0 — 76-75</span>
                        </div>
                        <div class="flex flex-col col-span-2">
                            <span>4 — Conditional 5 — 70 and Below (Failed)</span>
                            <span>DO — Dropped Officially</span>
                            <span>UD — Unauthorized Dropping</span>
                            <span>DFS — Dropped w/ Failure Standing</span>
                            <span>Dropped for Exceed 20% Absences</span>
                        </div>
                        <div class="flex flex-col">
                            <span>INC — Incomplete</span>
                            <span>NG — No Grad</span>
                        </div>
                    </div>
                </div>
                <div class="w-full flex flex-col mt-2 px-12 text-xs">
                    <hr class="border-t-2 border-black" />
                    <div>Copy valid for: <b>{{ $purpose }}</b></div>
                    <div>Prepared by: <b>{{ auth()->user()->name }}</b></div>
                    <div class="flex justify-between">
                        <span>Checked by: <b>{{ $checker }}</b></span>
                        <span>Date Issued: <span>{{ now()->format('m/d/Y') }}</span></span>
                    </div>
                    <hr class="border-t-2 border-black" />
                </div>
                <div class="w-full flex flex-col mt-2 px-16">
                    <div class="flex justify-between">
                        <div class="flex flex-col"><span>(NOT VALID WITHOUT)</span><span>(THE COLLEGE SEAL)</span></div>
                        <div class="flex flex-col">
                            <span class="mt-4"><b>{{ $signatory }}</b></span>
                            <span>College Registrar</span>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</body>