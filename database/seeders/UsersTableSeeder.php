<?php
namespace Database\Seeders;

use App\Enums\Roles;
use App\Models\User;
use App\Traits\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    use Seeders;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->seedAdmin();
        $this->seedUser();
    }
}
