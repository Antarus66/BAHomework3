<?php

namespace antarus66\BAHomework3\Recipe\Repositories;

class LocalRecipesRepository extends RecipesRepository
{
    protected $recipes;

    public function __construct($recipes=[])
    {
        $this->recipes = $recipes;

        /*
        $this->recipes = [
            // эспрессо (кофе + вода)
            'espresso' => new Recipe(['coffee', 'water']),
            // доппио (эспрессо + эспрессо)
            'doppio' => new Recipe('coffee', 'water', 'coffee', 'water'),
            // американо (эспрессо + вода)
            // каппучино (эспрессо + молоко + взбитое молоко)
        ];
        */
    }

    public function getRecipe($recipe_name)
    {
        foreach ($this->recipes as $r) {
            if ($r->getName() === $recipe_name) {
                return $r;
            }
        }
        return null;
    }

    public function addRecipe($recipe)
    {
        $this->recipes[] = $recipe;
    }
}