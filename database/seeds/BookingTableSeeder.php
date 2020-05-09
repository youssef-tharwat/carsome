<?php

use Illuminate\Database\Seeder;
use App\Booking;
use Faker\Factory as Faker;

class BookingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1,3) as $index) {
            $booking = Booking::create([
                'user_id' => $index,
                'title' => $faker->name,
                'start' => $faker->dateTime
            ]);

            $booking->save();
        }
    }
}
