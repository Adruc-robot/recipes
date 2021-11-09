<?php
    //session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<section class="index-login">
    <!--
        <div class="wrapper">
            <div class="index-login-signup">
                <h4>describe what do</h4>
                <form action="includes/writeto.inc.php" method="post">
                    <input type="text" name="field_1_name" placeholder="meaningful placeholder">
                    <select name="field_2_name">
                        <option value="the_key">field value</option>
                        <option>dropdowns are used for foriegn key relations</option>
                        <option>populate this with php/sql - follow the example below</option>
                    </select>
                    <input type="text" name="tablename" class="noShow" value="actual_table_name" >
                    <br>
                    <button type="submit" name="submit">add to db</button>
                </form>
            </div>
        </div>
-->
<div class="thisdumb"><h4>Ingredient management</h4>
    <div class="genFlex">
        <div class="wrapper" id="add_ingredient">
            <div class="index-login-signup">
                <h4>Add Ingredient</h4>
                <!--<form action="includes/writeto.inc.php" method="post">-->
                <form action="includes/writeto.inc.php" method="post">
                    <input type="text" name="name" placeholder="ingredient name" maxlength="200">
                    <select name="state">
                        <?php
                            include ("includes/dbinfo.inc.php");
                            $queryString = "select group_concat(thing separator '\n') doot from (select concat(thing,'</option>') thing,'1' doot from (select concat(thing,name) thing from (select concat(thing,'''>') thing,name from (select concat('<option value=''',the_key) thing,name from states order by name) d) d) d) d group by doot;";
                            $pdo = new PDO($dns, $user, $pass, $opt);
                            $stmt = $pdo->query($queryString);
                            $row = $stmt->fetch();
                            echo $row['doot'];

                            $stmt->connection = null;
                        ?>
                    </select>
                    <select name="location">
                        <?php
                            $queryString = "select the_key,name from locations order by name;";
                            $pdo = new PDO($dns, $user, $pass, $opt);
                            $stmt = $pdo->query($queryString);
                            $i=1;
                            while ($row = $stmt->fetch()) {
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
                    <input type="text" name="tablename" class="noShow" value="ingredients" >
                    <br>
                    <button type="submit" name="submit">add to db</button>
                </form>
            </div>
        </div>    
        <div class="wrapper" id="add_location">
            <div class="index-login-signup">
                <h4>add ingredient location in the store</h4>
                <form action="includes/writeto.inc.php" method="post">
                    <input type="text" name="name" placeholder="location name" maxlength="200">
                    <input type="text" name="tablename" class="noShow" value="locations" >
                    <br>
                    <button type="submit" name="submit">add to db</button>
                </form>
            </div>
        </div>
        <div class="wrapper" id="add_state">
            <div class="index-login-signup">
                <h4>add ingredient state (chopped, grated, liquid)</h4>
                <form action="includes/writeto.inc.php" method="post">
                    <input type="text" name="name" placeholder="state name" maxlength="200">
                    <input type="text" name="tablename" class="noShow" value="states" >
                    <br>
                    <button type="submit" name="submit">add to db</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="thisdumb"><h4>Recipe Management</h4>
    <div class="genFlex">
        <div class="wrapper">
            <div class="index-login-signup">
                <h4>add recipe</h4>
                <form action="includes/writeto.inc.php" method="post">
                    <input type="text" name="name" placeholder="recipe name" maxlength="200">
                    <input type="text" name="tablename" class="noShow" value="recipes" >
                    <br>
                    <button type="submit" name="submit">add to db</button>
                </form>
            </div>
        </div>
        <div class="wrapper">
            <div class="index-login-signup">
                <h4>add recipe ingredients</h4>
                <form action="includes/writeto.inc.php" method="post">
                    <select name="recipe">
                        <?php
                            $queryString = "select the_key,name from recipes order by name;";
                            $pdo = new PDO($dns, $user, $pass, $opt);
                            $stmt = $pdo->query($queryString);
                            $i=1;
                            while ($row = $stmt->fetch()) {
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
                    <select name="ingredient">
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
                    <input type="text" maxlength="4" name="amount" placeholder="amount">
                    <select name="unit">
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
                    <input type="text" name="prep_instructions" placeholder="preparation instructions" maxlength="200">
                    
                    <input type="text" name="tablename" class="noShow" value="recipe_ingredients" >
                    <br>
                    <button type="submit" name="submit">add to db</button>
                </form>
            </div>
        </div>
        <div class="wrapper">
            <div class="index-login-signup">
                <h4>add recipe step</h4>
                <form action="includes/writeto.inc.php" method="post">
                    <select name="recipe">
                        <?php
                            $queryString = "select the_key,name from recipes order by name;";
                            $pdo = new PDO($dns, $user, $pass, $opt);
                            $stmt = $pdo->query($queryString);
                            $i=1;
                            while ($row = $stmt->fetch()) {
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
                    <input type="number" step="1" name="step_number">
                    <textarea id="w3review" name="step_text" rows="4" cols="50">inpt the step text</textarea>
                    <input type="text" name="tablename" class="noShow" value="recipe_steps" >
                    <br>
                    <button type="submit" name="submit">add to db</button>
                </form>
            </div>
        </div>
    </div>
</div>
</section>
    
</body>
</html>