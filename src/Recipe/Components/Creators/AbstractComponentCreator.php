<?php

namespace antarus66\BAHomework3\Recipe\Components\Creators;

use antarus66\BAHomework3\Recipe\Components\Ingredients\Chocolate;
use antarus66\BAHomework3\Recipe\Components\Ingredients\Coffee;
use antarus66\BAHomework3\Recipe\Components\Ingredients\Milk;
use antarus66\BAHomework3\Recipe\Components\Ingredients\Sugar;
use antarus66\BAHomework3\Recipe\Components\Ingredients\Water;
use antarus66\BAHomework3\Recipe\Components\Ingredients\WhippedCream;
use antarus66\BAHomework3\Recipe\Components\Ingredients\WhippedMilk;
use antarus66\BAHomework3\Recipe\Components\Ingredients\Whiskey;

abstract class AbstractComponentCreator
{
    abstract public function makeComponent($type);

    protected $allowed_ingredient_types = [
        'chocolate'     => Chocolate::class,
        'coffee'        => Coffee::class,
        'milk'          => Milk::class,
        'sugar'         => Sugar::class,
        'water'         => Water::class,
        'whipped_cream' => WhippedCream::class,
        'whipped_milk'  => WhippedMilk::class,
        'whiskey'       => Whiskey::class,
    ];

    /*
     * Creates a new simple Ingredient of Recipe by string type.
     * We can use it for creating Recipes with only one nesting level.
     */
    protected function makeIngredient($type)
    {
        if (array_key_exists($type, $this->allowed_ingredient_types)) {
            return new $this->allowed_ingredient_types[$type]();
        } else {
            $available_ingredients = implode(', ', array_keys($this->allowed_ingredient_types));
            throw new \InvalidArgumentException("Incompatible ingredient: '$type'!"
                . PHP_EOL
                . "Available ingredients: $available_ingredients.");
        }
    }

}