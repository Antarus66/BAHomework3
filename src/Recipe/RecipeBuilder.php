<?php

namespace antarus66\BAHomework3\Recipe;

 class RecipeBuilder
 {
     protected $component_creator;

     public function __construct($component_creator)
     {
         $this->component_creator = $component_creator;
     }

     /*
      * Creates and returns new Recipe object by it's text description from user.
      * This object may consist of Ingredient objects and another recipes which exists
      * in the recipes repository.
      */
     public function makeRecipe($recipe_name, $component_names_list)
     {
         $components_list = [];

         foreach ($component_names_list as $comp_name) {
             $new_c = $this->component_creator->makeComponent($comp_name);
             $components_list[] = $new_c;
         }

         return new Recipe($recipe_name, $components_list);
     }
}