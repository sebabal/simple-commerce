<?php

use DoubleThreeDigital\SimpleCommerce\Models\Country;
use DoubleThreeDigital\SimpleCommerce\Models\State;
use Faker\Generator as Faker;
use Statamic\Stache\Stache;

$factory->define(State::class, function (Faker $faker) {
    return [
        'uuid'          => (new Stache())->generateId(),
        'name'          => $faker->state,
        'abbreviation'  => $faker->stateAbbr,
        'country_id'    => function () {
            return factory(Country::class)->create()->id;
        },
    ];
});
