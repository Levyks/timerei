<?php

namespace Database\Seeders;

use App\Models\State;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $json = file_get_contents(__DIR__.'/data/states.json');
        $states = json_decode($json, true);
        $now = Carbon::now()->toDateTimeString();
        State::insert(array_map(fn ($state) => [
            'code' => $state['code'],
            'name' => $state['name'],
            'abbreviation' => $state['abbreviation'],
            'created_at' => $now,
            'updated_at' => $now,
        ], $states));
    }
}

