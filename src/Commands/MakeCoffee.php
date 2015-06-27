<?php

namespace antarus66\BAHomework3\Commands;

use antarus66\BAHomework3\Models\CoffeeDrink;
use antarus66\BAHomework3\Exceptions\CommandException;
use antarus66\BAHomework3\Exceptions\RepositoryException;
use antarus66\BAHomework3\Models\Recipe\Repositories\AbstractRecipesRepository;

class MakeCoffee extends Command
{
    protected $recipes_repository;
    protected $ingredient_creator;

    public function __construct(AbstractRecipesRepository $recipes_repository,
                                $ingredient_creator)
    {
        $this->recipes_repository = $recipes_repository;
        $this->ingredient_creator = $ingredient_creator;

        $this->required_options_num = 1;
        $this->required_params_num = 1;
    }

    public function execute($options, $parameters)
    {
        $this->checkRequiredInput($options, $parameters);

        $recipe_name = $options[0];

        // Getting the recipe for compare with users input
        try {
            $recipe = $this->recipes_repository->getRecipe($recipe_name);
        } catch (RepositoryException $e) {
            // Catching and rethrowing "no such recipe" exception;
            $avaliable_recipes = implode(', ', $this->recipes_repository->getRecipesNames());
            throw new CommandException('Recipe was not found. '
                . $e->getMessage()
                . PHP_EOL
                . "Available recipes: $avaliable_recipes.", null, $e);
        }

        // Processing in array_map function may cause a Warning in case of catched error.
        foreach ($parameters as $p) {
            // Creating component objects from the users list
            try {
                $ingredients[] = $this->ingredient_creator->makeComponent($p);
            } catch (\InvalidArgumentException $e) {
                // incompatible ingredient
                throw new CommandException('Ingredient was not processed. ' . $e->getMessage(),
                                            null, $e);
            }
        }
        // Comparing ingredients lists from saved recipe and users input
        if ($recipe->isIngredientsMatches($ingredients)) {
            // Success! Creating new CoffeeDrink object with ingredients list
            $coffee_drink = new CoffeeDrink($ingredients);

            // Showing it to user
            fwrite(STDOUT, "There is your coffee:" . PHP_EOL);
            foreach ($coffee_drink->getIngredients() as $ing) {
                fwrite(STDOUT, '   -> ' . $ing->getName() . PHP_EOL);
            }
        } else {
            throw new CommandException("Ingredients isn't correct for this
            recipe");
        }
    }

    public static function getDescription()
    {
        return 'make-coffee - Returns coffee by recipe from ingredients' . PHP_EOL;
    }

    public static function getHelp() {
        return self::getDescription()
            . '    Syntax:  make-coffee --<recipe_name> <ingredient1> [ingerdient2...]>' . PHP_EOL
            . '    Example: make-coffee --espresso coffee water' . PHP_EOL;
    }
}