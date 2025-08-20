<?php

namespace App\Console\Commands;

use App\Models\Enrollment;
use App\Settings\BillingSetting;
use Illuminate\Console\Command;

class InjectEmptyEnrollmentFees extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:inject-empty-enrollment-fees';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $billingSetting = app(BillingSetting::class);
        $enrollments = Enrollment::whereNull('fees')->get();

        foreach ($enrollments as $enrollment) {
            $enrollment->fees = [
                'library_fees' => $billingSetting->library_fees,
                'computer_fees' => $billingSetting->computer_fees,
                'lab_fees' => $billingSetting->lab_fees,
                'athletic_fees' => $billingSetting->athletic_fees,
                'cultural_fees' => $billingSetting->cultural_fees,
                'guidance_fees' => $billingSetting->guidance_fees,
                'handbook_fees' => $billingSetting->handbook_fees,
                'registration_fees' => $billingSetting->registration_fees,
                'medical_and_dental_fees' => $billingSetting->medical_and_dental_fees,
                'school_id_fees' => $billingSetting->school_id_fees,
                'admission_fees' => $billingSetting->admission_fees,
                'entrance_fees' => $billingSetting->entrance_fees,
                'development_fees' => $billingSetting->development_fees,
                'tuition_fee_per_unit' => $billingSetting->tuition_fee_per_unit,
                'nstp_fee_per_unit' => $billingSetting->nstp_fee_per_unit,
                'alco_mem_fees' => $billingSetting->alco_mem_fees,
                'pta_fees' => $billingSetting->pta_fees,
                'other_fees' => $billingSetting->other_fees,
            ];

            $enrollment->save();
        }
    }
}
