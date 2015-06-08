<?php

namespace antarus66\BAHomework3\Recipe\Components\Creators;

use antarus66\BAHomework3\Recipe\Recipe;

class ComponentCreator extends AbstractComponentCreator
{
    protected $recipe_repository;

    public function __construct($recipe_repository)
    {
        $this->recipe_repository = $recipe_repository;
    }

    /*
     * Returns new Ingredient or Recipe objects by Ingredient type or Recipe name
     * depends of it's existence in Ingredient hierarchy and Recipe repository.
     */
    public function makeComponent($type)
    {
        try {
            return $this->makeIngredient($type);
        } catch (\InvalidArgumentException $e) {
            $recipe = $this->recipe_repository->getRecipe($type);
            if ($recipe !== null) {
                return $recipe;
            } else {
                throw new \InvalidArgumentException("Incompatible component: '$type'!");
            }
        }
    }
}