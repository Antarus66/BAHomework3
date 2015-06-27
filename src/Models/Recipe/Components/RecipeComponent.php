<?php

namespace antarus66\BAHomework3\Models\Recipe\Components;

/*
 * Defines a behavior for the components of recipe for defining a flat list of allowed
 * for the input ingredients of the recipe for comparing with users input;
 *
 *
 */
interface RecipeComponent
{
    public function getIngredients();
}