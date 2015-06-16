<?php

namespace antarus66\BAHomework3\Recipe;

abstract class AbstractRecipeBuilder
{
    abstract function makeRecipe($recipe_name, $component_names_list);
}