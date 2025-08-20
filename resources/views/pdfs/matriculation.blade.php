@props([
    'enrollment' => null,
    'data' => [],
])

@php
    $totalRows = 16;
    $remainingRows = $totalRows - count($enrollment->schedules);
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Matriculation</title>
    <style>
        .page-break {
            page-break-after: always;
        }
    </style>
    @vite('resources/css/app.css')
</head>
<body class="w-full h-full flex flex-col items-center justify-center">
    <div class="w-full max-w-full h-full flex flex-col items-center justify-center p-4 text-[8px]">
        <div class="w-full h-full flex flex-col items-center justify-center">
            <h4 class="uppercase font-bold">Calabanga Community College</h4>
            <h5 class="">Calabanga, Camarines Sur</h5>
            <h5 class="font-bold  uppercase">Office of the Registrar</h5>
            <h5 class="mt-2 font-bold uppercase">Certificate of Matriculation</h5>
        </div>
        <div class="w-full h-full flex items-center justify-center mt-4">
            <div class="basis-1/3 flex">
                <span class="font-bold">Name:</span>
                <p class="pl-2 border-b w-full">{{ $enrollment->student->first_name }} {{ $enrollment->student->middle_name }} {{ $enrollment->student->last_name }}</p>
            </div>
            <div class="basis-1/5 flex">
                <span class="basis-1/4 font-bold">Course:</span>
                <span class="basis-3/4 pl-2 border-b">{{ $enrollment->program->code }}</span>
            </div>
            <div class="basis-1/5 flex">
                <span class="basis-2/5 font-bold">School Year:</span>
                <span class="basis-3/5 pl-2 border-b">{{ $enrollment->schoolYear->name }}</span>
            </div>
            <div class="basis-1/5 flex">
                <span class="basis-1/2 font-bold">Student Number:</span>
                <span class="basis-1/2 pl-2 border-b">{{ $enrollment->student->student_id }}</span>
            </div>
        </div>
        <div class="w-full h-full flex items-start justify-center mt-2">
            <table class="border-collapse border w-3/4">
                <thead>
                    <tr>
                        <th class="border p-1 h-[18px]">Sub. Code</th>
                        <th class="border p-1 h-[18px]">Subject Description</th>
                        <th class="border p-1 h-[18px]">Day</th>
                        <th class="border p-1 h-[18px]">Time</th>
                        <th class="border p-1 h-[18px]">Instructor's Name</th>
                        <th class="border p-1 h-[18px]">Units</th>
                        <th class="border p-1 h-[18px]">Room</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($enrollment->schedules as $schedule)
                        <tr>
                            <td class="border p-1 h-[18px]">{{ $schedule->subject->code }}</td>
                            <td class="border p-1 h-[18px]">{{ $schedule->subject->name }}</td>
                            <td class="border p-1 h-[18px]">{{ $schedule->day_of_week_name }}</td>
                            <td class="border p-1 h-[18px]">{{ $schedule->start_time_formatted }} - {{ $schedule->end_time_formatted }}</td>
                            <td class="border p-1 h-[18px]">{{ $schedule->teacher?->name ?? '-' }}</td>
                            <td class="border p-1 h-[18px]">{{ $schedule->subject->units }}</td>
                            <td class="border p-1 h-[18px]">{{ $schedule->room?->name ?? '-' }}</td>
                        </tr>
                    @endforeach
                    @for ($i = 0; $i < $remainingRows; $i++)
                        <tr>
                            <td class="border h-[21px]"></td>
                            <td class="border h-[21px]"></td>
                            <td class="border h-[21px]"></td>
                            <td class="border h-[21px]"></td>
                            <td class="border h-[21px]"></td>
                            <td class="border h-[21px]"></td>
                            <td class="border h-[21px]"></td>
                        </tr>
                    @endfor
                </tbody>
            </table>
            <table class="border-collapse border ml-[-1px] w-1/4">
                <thead>
                    <tr>
                        <th class="border p-1 h-[18px]" colspan="2">Assessment of Fees</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border p-1 h-[18px] basis-1/2">Library Fees</td>
                        <td class="border p-1 h-[18px] basis-1/2 text-right">{{ number_format($enrollment->library_fees, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="border p-1 h-[18px] basis-1/2">Computer Fees</td>
                        <td class="border p-1 h-[18px] basis-1/2 text-right">{{ number_format($enrollment->computer_fees, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="border p-1 h-[18px] basis-1/2">Lab. Fee</td>
                        <td class="border p-1 h-[18px] basis-1/2 text-right">{{ number_format($enrollment->lab_fees, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="border p-1 h-[18px] basis-1/2">Athletic Fess/LCUAA</td>
                        <td class="border p-1 h-[18px] basis-1/2 text-right">{{ number_format($enrollment->athletic_fees, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="border p-1 h-[18px] basis-1/2">Cultural Fees</td>
                        <td class="border p-1 h-[18px] basis-1/2 text-right">{{ number_format($enrollment->cultural_fees, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="border p-1 h-[18px] basis-1/2">Guidance Fees</td>
                        <td class="border p-1 h-[18px] basis-1/2 text-right">{{ number_format($enrollment->guidance_fees, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="border p-1 h-[18px] basis-1/2">Handbook Fees</td>
                        <td class="border p-1 h-[18px] basis-1/2 text-right">{{ number_format($enrollment->handbook_fees, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="border p-1 h-[18px] basis-1/2">Registration Fees</td>
                        <td class="border p-1 h-[18px] basis-1/2 text-right">{{ number_format($enrollment->registration_fees, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="border p-1 h-[18px] basis-1/2">Medical & Dental Fees</td>
                        <td class="border p-1 h-[18px] basis-1/2 text-right">{{ number_format($enrollment->medical_and_dental_fees, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="border p-1 h-[18px] basis-1/2">School ID Fees</td>
                        <td class="border p-1 h-[18px] basis-1/2 text-right">{{ number_format($enrollment->school_id_fees, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="border p-1 h-[18px] basis-1/2">Admission Fees</td>
                        <td class="border p-1 h-[18px] basis-1/2 text-right">{{ number_format($enrollment->admission_fees, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="border p-1 h-[18px] basis-1/2">Entrance Fees</td>
                        <td class="border p-1 h-[18px] basis-1/2 text-right">{{ number_format($enrollment->entrance_fees, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="border p-1 h-[18px] basis-1/2">Tuition Fees</td>
                        <td class="border p-1 h-[18px] basis-1/2 text-right">{{ number_format($enrollment->tuition_fees, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="border p-1 h-[18px] basis-1/2">Dev't Fees</td>
                        <td class="border p-1 h-[18px] basis-1/2 text-right">{{ number_format($enrollment->development_fees, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="border p-1 h-[18px] basis-1/2">ALCO Mem. Fees</td>
                        <td class="border p-1 h-[18px] basis-1/2 text-right">{{ number_format($enrollment->alco_mem_fees, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="border p-1 h-[18px] basis-1/2">PTA</td>
                        <td class="border p-1 h-[18px] basis-1/2 text-right">{{ number_format($enrollment->pta_fees, 2) }}</td>
                    </tr>
            </table>
        </div>
        <div class="w-full h-full flex items-start justify-between mt-1">
            <span>Recommending Approval:</span>
            <div class="w-1/4 px-2 flex">
                <span>Total:</span>
                <p class="pl-2 border-b w-full text-right">{{ number_format($enrollment->total_fees, 2) }}</p>
            </div>
        </div>
    </div>
</body>