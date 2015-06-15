<?php

namespace antarus66\BAHomework3\Commands;

use antarus66\BAHomework3\Exceptions\CommandException;
use antarus66\BAHomework3\Exceptions\RepositoryException;

class AddRecipe extends Command
{
    public function __construct($recipe_builder, $recipe_repository)
    {
        $this->recipe_builder = $recipe_builder;
        $this->recipes_repository = $recipe_repository;

        $this->required_options_num = 1;
        $this->required_params_num = 1;
    }

    public function execute($options, $parameters)
    {
        $this->checkRequiredInput($options, $parameters);
        $recipe_name = $options[0];

        // Creating new Recipe object
        try {
            $recipe = $this->recipe_builder->makeRecipe($recipe_name, $parameters);
        } catch (\InvalidArgumentException $e) {
            throw new CommandException("Recipe wasn't created. " . $e->getMessage(), null, $e);
        }

        // Saving new recipe object
        try {
            $this->recipes_repository->addRecipe($recipe);
        } catch (RepositoryException $e) {
            throw new CommandException("Recipe wasn't saved. " . $e->getMessage(), null, $e);
        }

        //Succesfull case
        fwrite(STDOUT, "Recipe $recipe_name saved successfully." . PHP_EOL);
    }

    public static function getDescription()
    {
        return 'add-recipe - Adds recipe with required name and the list of components.'
            . PHP_EOL;
    }

    public static function getHelp() {
        return self::getDescription()
        . 'You can use as component any compatible ingredient or any memorized recipe.' . PHP_EOL
        . '    Syntax:  add-recipe --<recipe_name> <component> [component2...]>' . PHP_EOL
        . '    Example: add-recipe --mocha chocolate espresso milk whipped_cream' . PHP_EOL;
    }
}