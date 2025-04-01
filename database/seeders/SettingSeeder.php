<?php

namespace Database\Seeders;

use App\Traits\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SettingSeeder extends Seeder
{
    use Seeders;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->seedSetting();
    }
}
