<?php

namespace antarus66\BAHomework3\Models\Recipe\Components\Ingredients;

use antarus66\BAHomework3\Models\Recipe\Components\Ingredients;
use antarus66\BAHomework3\Models\Recipe\Components\RecipeComponent;

abstract class Ingredient implements RecipeComponent
{
    protected $name;

    public function getIngredients()
    {
        return [$this];
    }

    public function getName()
    {
        return $this->name;
    }
}