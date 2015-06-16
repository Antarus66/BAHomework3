<?php

namespace antarus66\BAHomework3\Recipe\Components\Creators;

use antarus66\BAHomework3\Exceptions\RepositoryException;
use antarus66\BAHomework3\Recipe\Recipe;
use antarus66\BAHomework3\Recipe\Repositories\AbstractRecipesRepository;

class ComponentCreator extends AbstractComponentCreator
{
    protected $recipe_repository;

    public function __construct(AbstractRecipesRepository $recipe_repository)
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
            try {
                $recipe = $this->recipe_repository->getRecipe($type);
            } catch (RepositoryException $e) {
                throw new \InvalidArgumentException("Incompatible component: '$type'!");
            }

            return $recipe;
        }
    }
}