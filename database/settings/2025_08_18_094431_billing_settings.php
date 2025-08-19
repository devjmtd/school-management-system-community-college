<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('admin.library_fees', null);
        $this->migrator->add('admin.computer_fees', null);
        $this->migrator->add('admin.lab_fees', null);
        $this->migrator->add('admin.athletic_fees', null);
        $this->migrator->add('admin.cultural_fees',null);
        $this->migrator->add('admin.guidance_fees',null);
        $this->migrator->add('admin.handbook_fees',null);
        $this->migrator->add('admin.registration_fees',null);
        $this->migrator->add('admin.medical_and_dental_fees',null);
        $this->migrator->add('admin.school_id_fees',null);
        $this->migrator->add('admin.admission_fees',null);
        $this->migrator->add('admin.entrance_fees',null);
        $this->migrator->add('admin.development_fees',null);
        $this->migrator->add('admin.tuition_fee_per_unit',null);
        $this->migrator->add('admin.nstp_fee_per_unit',null);
        $this->migrator->add('admin.other_fees',null);
    }
};
