<?php

namespace Database\Seeders;

use App\Models\HospitalInstallation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class HospitalInstallationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::beginTransaction();
        try {
            $jsonPath = database_path('seeders/data/hospital-installation.json');
            $json = File::get($jsonPath);
            $data = json_decode($json, true);
            foreach ($data as $datum) {
                HospitalInstallation::updateOrCreate(
                    ['id' => $datum['id']],
                    $datum
                );
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error("error seed hospital installation " . $th->getMessage());
        }
    }
}
