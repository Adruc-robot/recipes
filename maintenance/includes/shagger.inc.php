<?php

    include "dbinfo.inc.php";
    function getHeaderSummary($tableName) {
        include "dbinfo.inc.php";
        $queryString = "select column_name name from information_schema.columns where table_schema = ? and table_name = ? order by ordinal_position;";
        $pdo = new PDO($dns, $user, $pass, $opt);
        $headers = $pdo->prepare($queryString);
        if(!$headers->execute(array($db,$tableName))) {
            $headers->connection = null;
            header("location: ../index.php?error=HeaderQueryError");
            exit();
        }
        $headerString = chr(9)."<tr>";
        while ($row = $headers->fetch()) {
            $headerString = $headerString.chr(9).chr(9).chr(9)."<th>".$row['name']."</th>".chr(10);
        }
        $headerString = $headerString.chr(9).chr(9)."</tr>".chr(10);
        echo $headerString;
    }
    function getSummary($tableName) {
        include "dbinfo.inc.php";
        //query to pull in column headers
        $headerQueryString = "select column_name name from information_schema.columns where table_schema = ? and table_name = ? order by ordinal_position;";
        //query to get data
        $queryString = "select * from $tableName;";
        //create the pdo object
        $pdo = new PDO($dns, $user, $pass, $opt);
        //prepare the queries
        
        $bodyData = $pdo->query($queryString);
        //execute them
        
        /*if(!$bodyData->execute(array($tableName))){
            $headers->connection = null;
            $bodyData->connection = null;
            header("location: ../index.php?error=bodyForBodyFailed");
        }*/
        $bodyString = "";
        //need to nest the header loop within the body loop
        while ($bRow = $bodyData->fetch()) {
            $bodyString = $bodyString."<tr>";
            $headers = $pdo->prepare($headerQueryString);
            if(!$headers->execute(array($db,$tableName))) {
                $headers->connection = null;
                $bodyData->connection = null;
                header("location: ../index.php?error=headersForBodyFailed");
            }
            while ($hRow = $headers->fetch()) {
                $colHead = $hRow['name'];
                $bodyString = $bodyString."<td>".$bRow[$colHead]."</td>";
            }
            $bodyString = $bodyString."</tr>";
        }
        echo $bodyString;

    }
    

/*if(isset($_POST["submit"]))
{
    include "dbinfo.inc.php";
    global $stmt;
    // Grabbing the data

    $fieldsString = "";
    $valuesString = "";
    $valuesArray = array();
    $i = 0;
    foreach($_POST as $name => $value) {
        if ($name === "tablename") {
            $tableName = $value;
        } elseif ($name <> "submit") { 
            $fieldsArray[$i] = strtoupper($name);
            $valuesArray[$i] = $value;
            $i++;

        }
    }
    $pdo = new PDO($dns, $user, $pass, $opt);
    $fieldsString = implode(',', $fieldsArray);
    //can delete
    $valuesString = implode(',', $valuesArray);
    $valueQs = str_repeat('?,', count($valuesArray) - 1) . '?';
    //not sure if this needs to be prepared, but doing to make sure people aren't updating the classes
    $fieldCheck = "select kc.column_name taco,case when kc.referenced_table_name is null then 'neg' else kc.referenced_table_name end reference_table,case when kc.referenced_column_name is null then 'neg' else kc.referenced_column_name end reference_name,tc.constraint_type the_constraint from information_schema.table_constraints tc inner join information_schema.key_column_usage kc on tc.constraint_schema = kc.constraint_schema and tc.constraint_name = kc.constraint_name and tc.table_name = kc.table_name where
    tc.table_name = '{$tableName}' and tc.constraint_schema = '{$db}' and kc.column_name in
    ({$valueQs})  order by case when kc.column_name = 'name' then 1 else case when kc.column_name = 'state' then 2 else 3 end end;";
    $checkFld = $pdo->prepare($fieldCheck);
    if(!$checkFld->execute($fieldsArray)) {
        $checkFld->connection = null;
        header("location: ../index.php?error=constraintQfailed");
        exit();
    } else {
        //If there is nothing returned, we don't need to check anything
        if ($checkFld->rowCount() <> 0) {
            //loop through the values
            //$row = $checkFld->fetch();
            $doot = "";
            //while ($row = $checkFld->fetch()){
            $beep = $checkFld->fetchall();
            //foreach($checkFld as $row) {
            foreach($beep as $row) {
                $theField = strtoupper($row['taco']);
                //get the value from the values array
                $heckIt = null;
                $heckIt = array_search($theField, $fieldsArray, false);
                $theValue = $valuesArray[$heckIt];
                $theConstraint = $row['the_constraint'];
                $referencedField = $row['reference_name'];
                $referencedTable = $row['reference_table'];
                $oh_0 = $fieldsArray[0] . " " . $fieldsArray[1] . " " . $fieldsArray[2];
                $doot = $doot . "$oh_0,$theField,$theValue,$heckIt,$theConstraint,$referencedField,$referencedTable|";
                switch ($theConstraint) {
                    case "UNIQUE":
                        //make sure the corresponding index from the valuesArray is unique
                        $conCheck = "select {$theField} from {$tableName} where {$theField} = ?;";
                        $errorString = "{$theValue} already exists in {$tableName} {$conCheck}";
                        break;
                    case "PRIMARY KEY":
                        //this probably shouldn't be something we need to do - think about how to manage
                        break;
                    case "FOREIGN KEY":
                        //make sure the corresonding index from the valuesArray exists in the foreign table - need to update the query to allow for this
                        $conCheck = "select {$referencedField} from {$referencedTable} where {$referencedField} = ?;";
                        $errorString = "{$theValue} should exist but doesn't";
                        break;
                    default:
                        //nothing
                }
                //query the database for $conCheck
                $constraintOK = $pdo->prepare($conCheck);              
                if(!$constraintOK->execute(array($theValue))) {
                    $constraintOK->connection = null;
                    header("location: ../index.php?error=queryfailed");
                    exit();
                } else {
                    $errorState = false;
                    //do a switch again trapping on the rowCount()
                    $howMany = $constraintOK->rowCount();
                    switch ($theConstraint) {
                        case "UNIQUE":
                            if ($howMany <> 0) {
                                //this means there's already an entry - exit
                                $errorString = "ThisItemAlreadyExists";
                                $errorState = true;
                            }
                            break;
                        case "PRIMARY KEY":
                            //this probably shouldn't be something we need to do - think about how to manage
                            break;
                        case "FOREIGN KEY":
                            if ($howMany < 1) {
                                //this means there isn't an an entry - exit
                                $errorString = "anItemIsMissing";
                                $errorState = true;
                            }
                            break;
                        default:
                        //nothing
                    } 
                    $constraintOK->connection = null;
                    $checkFld->connection = null;
                    if ($errorState){
                        //some kind of key violation has occurred and we are going to stop
                        header("location: ../index.php?error=$errorString");
                        exit();
                    }
                }
            }
        }
    }

    $queryString = "insert into {$tableName} ({$fieldsString}) values ({$valueQs});";
    
    $stmt = $pdo->prepare($queryString);
    if (!$stmt->execute($valuesArray)) {
        $stmt->connection = null;
        header("location: ../index.php?error=executefailed");
        exit();
    } 
    header("location: ../index.php?error=none");
}*/