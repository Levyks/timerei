<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\State;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $files = scandir(__DIR__.'/data/cities');
        $states = State::all()->keyBy('code');
        foreach ($files as $file) {
            if (!str_ends_with($file, '.json')) continue;
            $json = file_get_contents(__DIR__.'/data/cities/'.$file);
            $cities = json_decode($json, true);
            $now = Carbon::now()->toDateTimeString();
            City::insert(array_map(fn ($city) => [
                'code' => $city['code'],
                'name' => $city['name'],
                'abbreviation' => $city['abbreviation'],
                'state_id' => $states[$city['state_code']]->id,
                'created_at' => $now,
                'updated_at' => $now,
            ], $cities));
        }

    }
}

