<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="normalize.css">
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css?family=Muli:300,400,600,700" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-1.8.0.min.js"></script>
    <script src="scripts.js"></script>
    <style>
    </style>
</head>
<body>
    
    <input class="searcher" id="myInput" type="text" placeholder="Search for ingredient...">
    
    <div class="recipesWrapper">
        <div class="recipe" 
    <?php
        
        include ("includes/dbinfo.inc.php");

        $pdo = new PDO($dns, $user, $pass, $opt);
                        
        $query1String = "select group_concat(i.name separator '|') guh,r.name,r.the_key from recipes r inner join recipe_ingredients ri on r.the_key = ri.recipe inner join ingredients i on ri.ingredient = i.the_key group by r.name";
        $query2String = "select r.the_key, group_concat(concat(rs.step_number,'.  ',rs.step_text) separator '|') ger from recipes r inner join recipe_steps rs on r.the_key = rs.recipe group by r.name";
    
        $stmt1 = $pdo->query($query1String);
        $stmt2 = $pdo->query($query2String);
        $cnter = 0;
        while ($row = $stmt1->fetch()){
            $the_key = $row['the_key'];
            $query3String = "select concat(rs.step_number,'. ',rs.step_text) ger from recipes r inner join recipe_steps rs on r.the_key = rs.recipe where r.the_key = " .$the_key . " order by rs.step_number";
            $stmt3 = $pdo->query($query3String);
            $query4String = "select concat(ri.amount,' ',u.name,' ',i.name) gar from recipe_ingredients ri inner join recipes r on ri.recipe = r.the_key and r.the_key = ".$the_key." inner join ingredients i on ri.ingredient = i.the_key inner join states s on i.state = s.the_key inner join units u on ri.unit = u.the_key order by i.name";
            
            $stmt4 = $pdo->query($query4String);
//echo "<div class='divTableCell " . $row['guh'] . "' ";
            $cnter ++;
            if ($cnter > 1) {
                echo '        <div class="recipe" 
                ';
            }
            
                            //htmlspecialcharacters + ENT_QUOTES makes the name be safe for HTML
echo "      data-name='" . htmlspecialchars($row['name'],ENT_QUOTES) . "'";
                            $tSteps = "";
                            while ($escrow = $stmt3->fetch()){
                                //$tSteps = $tSteps . htmlspecialchars($escrow['ger'],ENT_QUOTES). "<br>";
                                $tSteps = $tSteps . "<p>" . htmlspecialchars($escrow['ger'],ENT_QUOTES) . "</p>";
                            };
echo " 
            data-steps='" . $tSteps."'";
                            $tIngredients = "";
                            while ($fscrow = $stmt4->fetch()){
                                //$tIngredients = $tIngredients . htmlspecialchars($fscrow['gar'],ENT_QUOTES). "<br>";
                                $tIngredients = $tIngredients . "<p>" . htmlspecialchars($fscrow['gar'],ENT_QUOTES) . "</p>";
                            };
echo " 
            data-ingredients='" . $tIngredients."' >";
echo "
            " . $row['name'] . "
        </div>
";
                        };
echo "          </div>
";
                        $pdo->connection = null;
                    ?>

          
 <!-- modal stuff -->    
        <div class="modal" id="myModal">    
            <div class="try">
                <div id="recNam"></div>
                <div id="oneLT">
            <div class="close" id="closer">&times;</div></div>
            </div>
	       <div class="modal-guts">
		      <!--this stuff does move-->
               <div id="recIngs"></div>
               <div id="recSteps"></div>
	       </div>
        </div>
        </div>
    </body>
</html>