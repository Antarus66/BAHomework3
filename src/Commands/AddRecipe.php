<?php

namespace antarus66\BAHomework3\Commands;

class AddRecipe extends Command
{
    public function __construct($recipe_builder, $recipe_repository)
    {
        $this->recipe_builder = $recipe_builder;
        $this->recipes_repository = $recipe_repository;
    }

    public function execute($options, $parameters)
    {
        // checking is options exist
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

        try {
            $recipe = $this->recipe_builder->makeRecipe($recipe_name, $parameters);
        } catch (\InvalidArgumentException $e) {
            fwrite(STDERR, $e->getMessage() . PHP_EOL);
            return;
        }

        fwrite(STDOUT, "Recipe $recipe_name created successfully." . PHP_EOL);

        $this->recipes_repository->addRecipe($recipe);
    }

    public static function getDescription()
    {
        return 'Adds a new recipe. Recipe can contain ingredients as well as other existant recipes.'
            . PHP_EOL
            . '    e.g. --irish espresso espresso whiskey whipped-cream';
    }
}