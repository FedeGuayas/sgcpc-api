<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = 'secret',
        'remember_token' => str_random(10),
        'verified'=>$verificado=$faker->randomElement([\App\User::USUARIO_VERIFICADO,\App\User::USUARIO_NO_VERIFICADO]),
        'verification_token'=> $verificado==\App\User::USUARIO_VERIFICADO ? null : \App\User::generarVerificationToken()
    ];
});

$factory->define(App\Program::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->sentence(3),
        'code' => $faker->unique()->numberBetween(1,100),
    ];
});

$factory->define(App\Activity::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->sentence(6),
        'code' => $faker->unique()->numberBetween(1,15),
    ];
});

$factory->define(App\Area::class, function (Faker\Generator $faker) {
    return [
        'name' => $name=$faker->unique()->word,
        'code' => substr($name,0,5)
    ];
});


$factory->define(App\Department::class, function (Faker\Generator $faker) {
    return [
        'area_id' => \App\Area::all()->random()->id,
        'name' => $faker->word
    ];
});

$factory->define(App\Worker::class, function (Faker\Generator $faker) {

    $users=\App\User::all()->pluck('id');

    return [
        'user_id'=>$faker->unique()->randomElement($users),
        'department_id'=>\App\Department::all()->random()->id,
        'first_name'=>$faker->firstName,
        'last_name'=>$faker->lastName,
        'email'=>$faker->unique()->safeEmail,
        'dni'=>$faker->unique()->numerify('##########'),
        'passport'=>$faker->unique()->numerify('######'),
        'position'=>null,
        'title'=>null
    ];
});


$factory->define(App\Item::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->sentence(5),
        'code' =>$faker->unique()->numerify('######'),
        'description' => $faker->paragraph(3),
    ];
});

$factory->define(\App\Partida::class, function (Faker\Generator $faker) {

    $pro = \App\Program::all()->pluck('id');
    $act = \App\Activity::all()->pluck('id');
    $itm = \App\Item::all()->pluck('id');

    return [
        'program_id' => $prog_id = $faker->randomElement($pro),
        'activity_id' => $act_id = $faker->randomElement($act),
        'item_id' => $itm_id = $faker->unique()->randomElement($itm),
        'programa' => \App\Program::where('id',$prog_id)->first()->code,
        'actividad' => \App\Activity::where('id',$act_id)->first()->code,
        'renglon' => \App\Item::where('id',$itm_id)->first()->code,
        'presupuesto' => $presup = $faker->randomFloat(2, 0, 500000),
        'disponible' => $presup,
        'origen'=> $faker->randomElement([\App\Partida::ORIGEN_AUTOGESTION,\App\Partida::ORIGEN_ESTADO])
    ];
});
