<?php

use Illuminate\Database\Seeder;

class BikesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Load the file
        $data = $this->readBikeData();

        // Insert into the database
        DB::table('bikes')->insert($data);
    }

    /**
     * @return mixed
     */
    public function readBikeData() : array
    {
        $path = base_path() . '/database/bike_data.json';
        $file = File::get($path);
        return json_decode($file, true);
    }
}
