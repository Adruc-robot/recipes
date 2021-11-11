<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Recipe Maintenance</title>
    <link rel="stylesheet" href="styles/normalize.css">
    <link rel="stylesheet" href="styles/styles.css">
</head>
    <body>
        <div class="parent">Create Recipe
            <div class="subStep"><a href="add_recipe.php">Add Recipe Name</a>
                <!--call add_recipe-->

            </div>
            <div class="parent subParent"><a href="add_recipe_ingredient.php">Add Recipe Ingredient</a>
                <div class="subStep"><a href="add_unit.php">Add Unit of Measure</a></div>
                <div class="parent subSubParent">Create Ingredient
                    <div class="subSubStep"><a href="add_ingredient_location.php">Add Ingredient Location in the Store</a></div>
                    <div class="subSubStep"><a href="add_ingredient_state.php">Add Ingredient State</a></div>
                    <div class="subSubStep"><a href="add_ingredient.php">Add Ingredient</a></div>
                </div>
            </div>
            <div class="subStep"><a href="add_recipe_step.php">Add Recipe Step</a></div>
        </div>
    </body>
</html>