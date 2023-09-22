<?php

namespace Database\Seeders;

use App\Models\BookingStatus;
use App\Models\OrderStatus;
use App\Models\Room;
use App\Models\Technician;
use App\Models\User;
use App\Models\VisitsStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoomsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Schema::disableForeignKeyConstraints();

        Room::query()->truncate();

        $users = User::query()->first();

        if (!$users){
            User::create([
               'first_name' => 'guest',
               'last_name' => 'guest',
               'email' => 'guest@gmail.com',
               'phone' => '123456',
            ]);
        }

        foreach (User::all() as $user){
            Room::query()->create([
                'sender_id' =>$user->id,
                'sender_type' =>'App\Models\User',
            ]);
        }

        $technicians = Technician::query()->first();

        if (!$technicians){
            Technician::create([
                'name' => 'guest',
                'user_name' => 'guest',
                'email' => 'guest@gmail.com',
                'phone' => '123456',
                'password' => Hash::make('123456'),
            ]);
        }

        foreach (Technician::all() as $user){
            Room::query()->create([
                'sender_id' =>$user->id,
                'sender_type' =>'App\Models\Technician',
            ]);
        }

        \Schema::enableForeignKeyConstraints();

    }
}
