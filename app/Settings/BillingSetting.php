<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class BillingSetting extends Settings
{
    public ?float $library_fees = null;
    public ?float $computer_fees = null;
    public ?float $lab_fees = null;
    public ?float $athletic_fees = null;
    public ?float $cultural_fees = null;
    public ?float $guidance_fees = null;
    public ?float $handbook_fees = null;
    public ?float $registration_fees = null;
    public ?float $medical_and_dental_fees = null;
    public ?float $school_id_fees = null;
    public ?float $admission_fees = null;
    public ?float $entrance_fees = null;
    public ?float $development_fees = null;
    public ?float $tuition_fee_per_unit = null;
    public ?float $nstp_fee_per_unit = null;
    public ?float $alco_mem_fees = null;
    public ?float $pta_fees = null;
    public ?float $other_fees = null;

    public static function group(): string
    {
        return 'admin';
    }
}