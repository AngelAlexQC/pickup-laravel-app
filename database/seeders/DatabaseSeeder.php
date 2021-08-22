<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Adding an admin user
        $user = \App\Models\User::factory()
            ->count(1)
            ->create([
                'email' => 'admin@admin.com',
                'password' => \Hash::make('admin'),
            ]);
        $this->call(PermissionsSeeder::class);

        $this->call(VehicleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(CommentSeeder::class);
        $this->call(TicketSeeder::class);
        $this->call(ItemSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(RoadSeeder::class);
        $this->call(AddressSeeder::class);
        $this->call(TeamSeeder::class);
    }
}
