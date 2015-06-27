#!/usr/bin/php
<?php
/**
 * CoffeeMaker console bootstrap file.
 */

namespace antarus66\BAHomework3\App;

require __DIR__ . '/../../vendor/autoload.php';

use antarus66\BAHomework3\App\Application;
use antarus66\BAHomework3\Commands\MakeCoffee;
use antarus66\BAHomework3\Commands\AddRecipe;
use antarus66\BAHomework3\Commands\ShowHelp;
use antarus66\BAHomework3\Commands\ExitProgramm;
use antarus66\BAHomework3\Models\Recipe\Components\Creators\ComponentCreator;
use antarus66\BAHomework3\Models\Recipe\RecipeBuilder;
use antarus66\BAHomework3\Models\Recipe\Repositories\LocalRecipesRepository;
use antarus66\BAHomework3\Models\Recipe\Components\Creators\IngredientCreator;

$container = new \Pimple\Container();

$container['routes'] = [
    'make-coffee' => MakeCoffee::class,
    'add-recipe'  => AddRecipe::class,
    'help'        => ShowHelp::class,
    'exit'        => ExitProgramm::class,
];

$container['help_command_handler'] = function ($c) {
    return new $c['routes']['help']($c['routes']);
};

$container['make-coffee_command_handler'] = function ($c) {
    return new $c['routes']['make-coffee'](
        $c['recipes_repository'],
        new IngredientCreator()
    );
};

$container['add-recipe_command_handler'] = function ($c) {
    return new $c['routes']['add-recipe'](
        $c['recipe_builder'],
        $c['recipes_repository']
    );
};

$container['exit_command_handler'] = function ($c) {
    return new $c['routes']['exit']();
};

$container['default_recipes'] = [
    'espresso'   => ['coffee', 'water'],
    'doppio'     => ['espresso', 'espresso'],
    'americano'  => ['espresso', 'water'],
    'cappuccino' => ['espresso', 'milk', 'whipped_milk'],
];

$container['recipes_repository'] = function ($c) {
    return new LocalRecipesRepository();
};

$container['component_creator'] = function ($c) {
    return new ComponentCreator($c['recipes_repository']);
};

$container['recipe_builder'] = function ($c) {
    return new RecipeBuilder(
        $c['component_creator']
    );
};


$application = new Application($container);
$application->start();