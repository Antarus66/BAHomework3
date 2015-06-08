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

    /*
     * Creates a new simple Ingredient of Recipe by string type.
     * We can use it for creating Recipes with only one nesting level.
     */
    protected function makeIngredient($type)
    {
        switch (strtolower($type)) {
            case 'chocholate':
                return new Chocolate();
                break;
            case 'coffee':
                return new Coffee();
                break;
            case 'milk':
                return new Milk();
                break;
            case 'sugar':
                return new Sugar();
                break;
            case 'water':
                return new Water();
                break;
            case 'whipped_cream':
                return new WhippedCream();
                break;
            case 'whipped_milk':
                return new WhippedMilk();
                break;
            case 'whiskey':
                return new Whiskey();
                break;
            default:
                throw new \InvalidArgumentException("Incompatible ingredient: '$type'!");
                break;
        }
    }
}