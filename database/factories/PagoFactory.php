<?php

use Faker\Generator as Faker;

$factory->define(App\Pago::class, function (Faker $faker) {
    return [
          'fecha'  => date('Y-m-d'),
          'referencia' =>str_random(10),
          'descripcion' => $faker->sentence,
          'moneda' => 'COP',
          'monto' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = NULL),
          'status' => 'OK'
      ];
});
