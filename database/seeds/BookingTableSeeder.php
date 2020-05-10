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

        foreach (range(1, 5) as $index) {
            $booking = Booking::create([
                'user_id' => $index,
                'title' => $faker->name,
                'start' => $faker->dateTime->setDate(2020, 05, 11)->setTime(rand(9, 17), 30),
                'resourceId' => rand(1,2)
            ]);

            $booking->save();
        }
    }
}
