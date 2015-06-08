<?php

namespace antarus66\BAHomework3\Commands;

use antarus66\BAHomework3\AbstractCoffeeCreator;
use antarus66\BAHomework3\CoffeeDrink;
use antarus66\BAHomework3\Exceptions\CommandException;
use antarus66\BAHomework3\Recipe\Repositories\RecipesRepository;

class MakeCoffee extends Command
{
    protected $description;

    public function __construct(RecipesRepository $recipes_repository,
                                $ingredient_creator)
    {
        $this->recipes_repository = $recipes_repository;
        $this->ingredient_creator = $ingredient_creator;
    }

    public function execute($options, $parameters)
    {
        if (empty($options)) {
            fwrite(STDERR,'The command mode is not detected!' . PHP_EOL);
            return;
        } else {
            $recipe_name = $options[0];
        }

        if (empty($parameters)) {
            fwrite(STDERR,'The parameters is not detected!' . PHP_EOL);
            return;
        }

        $recipe = $this->recipes_repository->getRecipe($recipe_name);
        if ($recipe === null) {
            fwrite(STDERR, "No such recipe: $recipe_name" . PHP_EOL);
            return;
        }

        // Processing in array_map function causing a Warning
        foreach ($parameters as $p) {
            try {
                $ingredients[] = $this->ingredient_creator->makeComponent($p);
            } catch (\InvalidArgumentException $e) {
                fwrite(STDERR, $e->getMessage() . PHP_EOL);
                return;
            }
        }

        if ($recipe->isIngredientsMatches($ingredients)) {
            $coffee_drink = new CoffeeDrink($ingredients);
            fwrite(STDOUT, "There is your coffee:" . PHP_EOL);
            foreach ($coffee_drink->getIngredients() as $ing) {
                fwrite(STDOUT, $ing->getName() . PHP_EOL);
            }
        } else {
            fwrite(STDERR, "Ingredients isn't correct for this recipe" . PHP_EOL);
        }
    }

    public static function getDescription()
    {
        return 'Makes coffee by recipes. e.g.: --espresso coffee water' . PHP_EOL;
    }
}