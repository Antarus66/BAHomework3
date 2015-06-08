<?php

namespace antarus66\BAHomework3;

class CoffeeDrink
{
    protected $ingredients;

    public function __construct($ingredients)
    {
        $this->ingredients = $ingredients;
    }

    public function getIngredients()
    {
        return $this->ingredients;
    }
}
