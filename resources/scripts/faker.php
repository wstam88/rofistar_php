<?php 

/**
 * Fake->name
 * @color lime
 */
function name() {
    $faker = Faker\Factory::create();
    return $faker->name;
}