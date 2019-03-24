<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 3/12/19
 * Time: 10:55 PM
 */

namespace Tests\Unit;


use Tests\TestCase;

class BikeDataSeederTest extends TestCase
{

    public function testBikeDataReading() {

        $reader = new \BikesTableSeeder();
        $date = $reader->readBikeData();

        $this->assertEquals(3, count($date));
        $first = $date[0];
        $this->assertEquals(22, $first['size']);
        $this->assertEquals('City', $first['category']);
    }

}