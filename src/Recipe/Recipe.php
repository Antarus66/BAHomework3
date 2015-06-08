<?php

namespace antarus66\BAHomework3\Recipe;

use antarus66\BAHomework3\Recipe\Components\RecipeComponent;

class Recipe implements RecipeComponent
{
    protected $name;
    protected $components; // composite formula (i.e. espresso + water)

    public function __construct($name, $components)
    {
        $this->name = $name;
        $this->components = $components;
    }

    public function getName()
    {
        return $this->name;
    }

    // returns raw formula (i.e. coffee + water + water)
    public function getIngredients()
    {
        $ingredientsList = [];

        foreach ($this->components as $c) {
            $ingredientsList = array_merge($ingredientsList, $c->getIngredients());
        }

        return $ingredientsList;
    }

    public function isIngredientsMatches($ingredients)
    {
        return ($ingredients == $this->getIngredients());
    }

}
