<?php

namespace Database\Seeders;

use App\Models\Drink;
use Illuminate\Database\Seeder;

class DrinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Remove old records
        Drink::query()->truncate();

        $drinks = [
            ['Monster Ultra Sunrise', 75*2, 'A refreshing orange beverage that has 75mg of drink per serving. Every can has two servings.'],
            ['Black Coffee', 95, 'The classic, the average 8oz. serving of black coffee has 95mg of drink.'],
            ['Americano', 77, 'Sometimes you need to water it down a bit... and in comes the americano with an average of 77mg. of drink per serving.'],
            ['Sugar free NOS', (130*2), 'Another orange delight without the sugar. It has 130 mg. per serving and each can has two servings.'],
            ['5 Hour Energy', 200, 'And amazing shot of get up and go! Each 2 fl. oz. container has 200mg of drink to get you going.'],
        ];
        foreach ($drinks as $drink) {
            list($name, $caffeine, $desc) = $drink;
            Drink::query()->create([
                'name' => $name,
                'caffeine' => $caffeine,
                'desc' => $desc,
            ]);
        }
    }
}
