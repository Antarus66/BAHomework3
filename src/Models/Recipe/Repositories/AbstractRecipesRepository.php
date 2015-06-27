<?php

namespace antarus66\BAHomework3\Models\Recipe\Repositories;

abstract class AbstractRecipesRepository
{
    abstract public function getRecipe($recipe_name);
    abstract public function addRecipe($recipe);
    abstract public function getRecipesNames();
}