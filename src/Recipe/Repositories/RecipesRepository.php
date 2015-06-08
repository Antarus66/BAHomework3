<?php

namespace antarus66\BAHomework3\Recipe\Repositories;

abstract class RecipesRepository
{
    abstract public function getRecipe($recipe_name);
    abstract public function addRecipe($receipe);
}