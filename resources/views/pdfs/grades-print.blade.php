@php use App\Models\Grade; @endphp
@props([
    'curriculumSubjects' => [],
    'purpose' => 'any',
    'year_level' => 'first',
    'sem' => '1st',
    'gwa' => null,
    'student_id' => null,
    'student' => null,
    'school_year' => null,
])

@php
    $totalUnits = 0;

    foreach($curriculumSubjects as $subject) {
        $totalUnits += $subject->subject->units;
    }

    $grades = Grade::where('student_id', $student_id)->get();
@endphp

        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Grades</title>
    <style>
        .page-break {
            page-break-after: always;
        }
    </style>
    @vite('resources/css/app.css')
</head>
<body class="w-full min-h-screen h-full flex flex-col items-center ">
<img src="{{ asset('logo.png') }}" alt="Logo" class="w-28 h-28 absolute top-4 left-32">
<img src="{{ asset('logo.png') }}" alt="Logo" class="w-2/3 absolute bottom-40 opacity-5">
<div class="w-full max-w-full h-full flex flex-col items-center justify-center p-4 text-[12px]">
    <div class="w-full h-full flex flex-col items-center justify-center">
        <h5 class="">Republic of the Philippines</h5>
        <h5 class="">Commission of Higher Education</h5>
        <h5 class="">Region V - Bicol</h5>
        <h4 class="uppercase font-bold text-blue-500">Calabanga Community College</h4>
        <h5 class="">Belen, Calabanga, Camarines Sur</h5>
        <h5 class="font-bold mt-2 uppercase">Office of the Registrar</h5>
        <hr class="w-full mt-2 border"/>
        <div class="w-full flex items-center">
            <span class="w-12"></span>
            <hr class="w-full my-2 border-[0.5]"/>
            <span class="w-12 text-[6px]">CCC-RF-02</span>
        </div>
        <h5 class="mt-2 uppercase text-blue-600 font-[Tavern] text-6xl">Certification</h5>
    </div>
    <div class="w-full h-full flex flex-col items-center mt-12 text-left px-16 text-base">
        <div class="w-full flex flex-col font-serif">
            <b>To Whom It May Concern:</b>
            <p class="mt-4">&emsp; &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp; This is to certify that as per records on
                file in this office, <span
                        class="uppercase font-bold underline">{{ $student->first_name }} {{ $student->middle_name }} {{ $student->last_name }}</span>
                has taken the following subjects in Bachelor of Science in Entrepreneurship during {{ $year_level }}
                year {{ $sem }} Semester S/Y {{ $school_year }}, with corresponding ratings and credits
                below:</p>
            <table class="mt-4 border -mx-4 text-sm">
                <thead>
                <tr>
                    <th class="border px-1 py-0.5 text-center">SUBJECT CODE</th>
                    <th class="border px-1 py-0.5 text-center">DESCRIPTION</th>
                    <th class="border px-1 py-0.5 text-center">FINAL GRADES</th>
                    <th class="border px-1 py-0.5 text-center">UNITS</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($curriculumSubjects as $subject)
                    <tr class="border">
                        <td class="border px-1 py-0.5">{{ $subject->subject->code }}</td>
                        <td class="border px-1 py-0.5">{{ $subject->subject->description }}</td>
                        <td class="border px-1 py-0.5 text-center">
                            @php
                                $grade = $grades->where('subject_id', $subject->subject_id)->first();

                                if(!$grade){
                                    echo '';
                                }

                                echo $grade->average;
                            @endphp
                        </td>
                        <td class="border px-1 py-0.5 text-center">{{ $subject->subject->units }}</td>
                    </tr>
                @endforeach
                <tr class="border">
                    <td class="border h-[27px]"></td>
                    <td class="border h-[27px]"></td>
                    <td class="border h-[27px]"></td>
                    <td class="border h-[27px]"></td>
                </tr>
                <tr class="border">
                    <td class="border"></td>
                    <td class="border px-1 py-0.5 font-semibold text-right">General Weighted Average</td>
                    <td class="border px-1 py-0.5 text-center">{{ $gwa ?? '' }}</td>
                    <td class="border px-1 py-0.5 text-center">{{ $totalUnits }}</td>
                </tr>
                </tbody>
            </table>
        </div>

    </div>
    <div class="w-full flex flex-col px-12 font-serif text-[8px]">
        <div class="w-full mt-6">
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
    <div class="w-full h-full flex flex-col items-center mt-12 text-left px-16 text-base">
        <div class="w-full flex flex-col font-serif">
            <p class="mt-4">&emsp; &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp; This certification is issued
                this {{ today()->isoFormat('Do') }} day of {{ today()->format('M') }}, {{ today()->format('Y') }} at
                Calabanga Community College,
                Belen, Calabanga, Camarines Sur for {{ $purpose }} purposes.</p>
        </div>
    </div>
    <div class="w-full h-full flex items-center justify-end px-16 mt-32">
        <div class="w-2/5 flex flex-col items-center justify-around">
            <span class="w-full font-bold text-center border-b uppercase">{{ auth()->user()->name }}</span>
            <span class="uppercase">College Registrar</span>
        </div>
    </div>
</div>
</body>