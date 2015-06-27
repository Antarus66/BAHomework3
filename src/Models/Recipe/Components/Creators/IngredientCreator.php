<?php

namespace antarus66\BAHomework3\Models\Recipe\Components\Creators;

class IngredientCreator extends AbstractComponentCreator
{
    /*
     * Creates a new simple Ingredient of Recipe by string type.
     * We can use it for creating Recipes with only one nesting level.
     */
    public function makeComponent($type)
    {
        return parent::makeIngredient($type);
    }
}