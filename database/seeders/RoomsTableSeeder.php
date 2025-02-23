<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomsTableSeeder extends Seeder
{
    public function run()
    {
        Room::create([
            'room_name' => '1',
            'professor_name' => 'Dr. Smith',
            'status' => 'Occupied',
            'time_in' => '09:00',
            'controller' => true,
        ]);

    }
}
