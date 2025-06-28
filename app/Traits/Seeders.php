<?php

namespace App\Traits;

use App\Enums\Roles;
use App\Models\User;
use App\Models\Setting;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

trait Seeders
{
    public function seedRoles()
    {
        $role = Role::insert([
            ['name' => 'admin', 'guard_name' => 'web'],
            ['name' => 'client', 'guard_name' => 'web'],
        ]);        
    }

    public function seedSetting()
    {
        Setting::create([
            'email' => 'info@watermillinstitutionaltradingllc.com',
            'name' => 'Watermill Institutional Trading',
            'short_name' => 'LLC',
            'phone_number' => '+19174237888',
        ]);
    }
    
    public function seedAdmin()
    {
        $user = User::create([
            'id' => 1,
            'name' => 'Admin',
            'email' => 'admin@site.com',
            'email_verified_at' => now(),
            'password' => ('secret'),
            'username' => 'admin',
            'phone_number' => '+4454554',
            'status' => true,
            'first_login' => false,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $user->assignRole(Roles::ADMIN()->value);

        $user->addMedia(public_path('white/img/default-avatar.jpg'))
            ->preservingOriginal()
            ->toMediaCollection('profile_image');
        $user->getMedia('profile_image')->first()->copy($user, 'passport_photo');

    }

    public function seedUser()
    {
        $user = User::create(
            [
                'id' => 4,
                'name' => 'User',
                'email' => 'user@site.com',
                'email_verified_at' => now(),
                'password' => 'secret',
                'username' => 'user',
                'phone_number' => '+92544665454545',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
        );
        $user->assignRole(Roles::CLIENT()->value);

        $user->addMedia(public_path('white/img/default-avatar.jpg'))
            ->preservingOriginal()
            ->toMediaCollection('profile_image');
        $user->getMedia('profile_image')->first()->copy($user, 'passport_photo');

    }
}