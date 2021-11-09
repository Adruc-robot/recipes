<?php
    //function new_conn ($dbInfo,&$pdo){
    function new_conn ($dbInfo,&$pdo){
        $dbInfoArr["food_db"] = "adruc.com|php_dude|Op1inion2|food_stuffs";
        $dbInfoArr["frs_stuff"] = "adruc.com|php_dude|Op1inion2|frs_stuff";
        $dbInfoArr["localtest_db"] ="localhost:3306|php_dude|Op1inion2|food_stuffs";
        $dbInfoArr["localtest_dn"] ="localhost:3306|php_writer|Eat1Shit!|dnd";
        $dbInfoArr["localtest_dr"] ="localhost:3306|php_dude|Op1inion2|dnd";
        $dbInfoArr["dnd_db"] = "adruc.com|php_dude|Op1inion2|dnd";
        $infoStr = $dbInfoArr["$dbInfo"];
        $infoArr = explode("|",$infoStr);
        $host = $infoArr[0];
        $user = $infoArr[1];
        $pass = $infoArr[2];
        $db = $infoArr[3];

        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $opt = array(
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        );
        global $pdo;
        $pdo = new PDO($dsn, $user, $pass, $opt);
        //for some reason, the $opt above fails - it doesn't like the opening bracket, but I haven't figured out why yet
        
        //$pdo = new PDO($dsn, $user, $pass);
        //$stmt = $pdo->query("select THE_KEY, NAME from recipes order by the_key");
        //while ($row = $stmt->fetch())
        //{
            //echo '<option id ="' .$row['THE_KEY']. '">' . $row['NAME'] . '</option>';
        //};
    };
?>