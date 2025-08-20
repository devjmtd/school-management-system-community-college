<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('admin.alco_mem_fees',null);
        $this->migrator->add('admin.pta_fees',null);
    }
};
