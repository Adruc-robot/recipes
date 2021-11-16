<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Recipe Maintenance</title>
    <link rel="stylesheet" href="styles/normalize.css">
    <link rel="stylesheet" href="styles/styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="app/scripts.js" charset="utf-8"></script>
</head>
    <body>
        <section class="heading"><h1 id="recipe_name"></h1></section>
        <?php
            include ("includes/dbinfo.inc.php");
        ?>
        <div class="carousel-wrapper">
            <div class="carousel">
                <section class="input_region carousel__item initial" id="recipe">
                    <h4>Recipe name</h4>
                    <form  method="post">
                        <label for="name">Enter recipe name:</label>
                        <input id="recName" type="text" name="name" placeholder="enter text" maxlength="200">
                        <input id="recTableName" type="text" name="tablename" class="noShow" value="recipes" >
                        
                        <br>
                        <button type="submit" name="submit" id="recSave">add to db</button>
                    </form>
                </section>
                <section class="input_region carousel__item" id="recipe_ingredients">
                    <h4>Recipe ingredients</h4>
                    <form method="post">
                        <input id="recIngRecipe" type="number" name="recipe" class="recipe_holder noShow">
                        <label for="ingredient">Select ingredient:</label>
                        <select id="recIngIngredient" name="ingredient">
                            <?php
                                $queryString = "select the_key,name from ingredients order by name;";
                                $pdo = new PDO($dns, $user, $pass, $opt);
                                $stmt = $pdo->query($queryString);
                                $i=1;
                                while ($row = $stmt->fetch()){
                                    if ($i<>1) {
                                        echo chr(9).chr(9).chr(9).chr(9).chr(9).chr(9)."<option value='".$row['the_key']."'>".$row['name']."</option>".chr(10);
                                    } else {
                                        echo "<option value='".$row['the_key']."'>".$row['name']."</option>".chr(10);
                                        $i++;
                                    }
                                }
                                $stmt->connection = null;
                            ?>
                        </select>
                        <label for="amount">How much?</label>
                        <input id="recIngAmount" type="text" maxlength="8" name="amount" placeholder="enter amount">
                        <label for="unit">What unit?</label>
                        <select id="recIngUnit" name="unit">
                            <?php
                                //$queryString = "select group_concat(thing separator '\n') doot from (select concat(thing,'</option>') thing,'1' doot from (select concat(thing,name) thing from (select concat(thing,'''>') thing,name from (select concat('<option value=''',the_key) thing,name from units order by name) d) d) d) d group by doot;";
                                $queryString = "select the_key,name from units order by name;";
                                $pdo = new PDO($dns, $user, $pass, $opt);
                                $stmt = $pdo->query($queryString);
                                $i=1;
                                while ($row = $stmt->fetch()){
                                    if ($i<>1) {
                                        echo chr(9).chr(9).chr(9).chr(9).chr(9).chr(9)."<option value='".$row['the_key']."'>".$row['name']."</option>".chr(10);
                                    } else {
                                        echo "<option value='".$row['the_key']."'>".$row['name']."</option>".chr(10);
                                        $i++;
                                    }
                                }
                                $stmt->connection = null;
                            ?>
                        </select>
                        <label for="prep_instructions">Preparation instructions?</label>
                        <input id="recIngPrep" type="text" name="prep_instructions" placeholder="enter text" maxlength="200">
                        <input id="recIngTableName" type="text" name="tablename" class="noShow" value="recipe_ingredients">
                        <br>
                        <button type="submit" name="submit" id="recIngSave" >add to db</button>
                    </form>
                </section>
                <section class="input_region carousel__item" id="recipe_steps">
                    <h4>Recipe steps</h4>
                    <form method="post">
                        <input id="recStepRecipe" type="number" name="recipe" class="recipe_holder noShow">
                        <label for="step_number">Which step?</label>
                        <input id="recStepNumber" type="number" step="1" name="step_number">
                        <label for="step_text">Input the step text:</label>
                        <textarea id="recStepStepTxt" name="step_text" rows="4" cols="50">enter text</textarea>
                        <input id="recStepTableName" type="text" name="tablename" class="noShow" value="recipe_steps">
                        <br>
                        <button type="submit" name="submit" id="recStepSave">add to db</button>
                    </form>
                </section>
                <div class="carousel__button--next"></div>
                <div class="carousel__button--prev"></div>
            </div>
        </div>
        <div id="recipeSummary"><div id="theTitle"></div><div id="theIngredients"></div><div id="theSteps"></div></div>
    </body>
</html>