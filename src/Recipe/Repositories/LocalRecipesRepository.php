<?php

namespace antarus66\BAHomework3\Recipe\Repositories;

use antarus66\BAHomework3\Exceptions\RepositoryException;

class LocalRecipesRepository extends AbstractRecipesRepository
{
    protected $recipes;

    public function __construct($recipes=[])
    {
        $this->recipes = $recipes;
    }

    public function hasRecipe($recipe_name)
    {
        foreach ($this->recipes as $r) {
            if ($r->getName() === $recipe_name) {
                return true;
            }

            return false;
        }
    }

    public function getRecipe($recipe_name)
    {
        foreach ($this->recipes as $r) {
            if ($r->getName() === $recipe_name) {
                return $r;
            }
        }
        throw new RepositoryException('No such recipe!');
    }

    public function addRecipe($recipe)
    {
        if (array_search($recipe, $this->recipes) === false){
            $this->recipes[] = $recipe;
        } else {
            throw new RepositoryException('Recipe with this name is already exists.');
        }
    }

    public function getRecipesNames()
    {
        $names = [];

        foreach ($this->recipes as $r) {
            $names[] = $r->getName();
        }

        return $names;
    }
}