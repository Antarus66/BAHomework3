<?php

namespace antarus66\BAHomework3\Models\Recipe\Components\Ingredients;

use antarus66\BAHomework3\Models\Recipe\Components\Ingredients\Ingredient;

class Coffee extends Ingredient
{
    public function __construct()
    {
        $this->name = 'Coffee';
    }
}