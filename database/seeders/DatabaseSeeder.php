<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Channel;
use App\Models\CommunityLink;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        DB::delete('delete from community_links');
        DB::delete('delete from channels');
        DB::delete('delete from users');

        User::factory()->count(5)->create();
        Channel::factory()->count(5)->create();
        CommunityLink::factory()->count(50)->create();
    }
}
