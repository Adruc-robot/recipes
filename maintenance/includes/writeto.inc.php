<?php


function writeTo($fieldsArray,$valuesArray,$tableName) {
    include "dbinfo.inc.php";
    global $stmt;
    // Grabbing the data

    /*$fieldsString = "";
    $valuesString = "";
    global $valuesArray;
    $valuesArray = array();
    global $fieldsArray;
    $fieldsArray = array();
    $i = 0;*/
    /*foreach($_POST as $name => $value) {
        if ($name === "tablename") {
            $tableName = $value;
        } elseif ($name === "pageOrigin") {
            $returnFile = $value;
        } elseif ($name <> "submit") { 
            $fieldsArray[$i] = strtoupper($name);
            $valuesArray[$i] = $value;
            $i++;
            $fieldsString = $fieldsString . ", " . strtoupper($name);
        }
    }*/

    $pdo = new PDO($dns, $user, $pass, $opt);
    $fieldsString = implode(',', $fieldsArray);
    //can delete
    $valuesString = implode(',', $valuesArray);
    $valueQs = str_repeat('?,', count($valuesArray) - 1) . '?';
    //not sure if this needs to be prepared, but doing to make sure people aren't updating the classes
    $fieldCheck = "select kc.column_name taco,case when kc.referenced_table_name is null then 'neg' else kc.referenced_table_name end reference_table,case when kc.referenced_column_name is null then 'neg' else kc.referenced_column_name end reference_name,tc.constraint_type the_constraint from information_schema.table_constraints tc inner join information_schema.key_column_usage kc on tc.constraint_schema = kc.constraint_schema and tc.constraint_name = kc.constraint_name and tc.table_name = kc.table_name where tc.table_name = '{$tableName}' and tc.constraint_schema = '{$db}' and kc.column_name in ({$valueQs})  order by case when kc.column_name = 'name' then 1 else case when kc.column_name = 'state' then 2 else 3 end end;";
    $checkFld = $pdo->prepare($fieldCheck);
    if(!$checkFld->execute($fieldsArray)) {
        echo json_encode(array("statusCode"=>101));
        $checkFld->connection = null;
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
                //$heckIt = array_search($theField, $fieldsArray, false);
                $heckIt = array_search($theField, $fieldsArray, true);
                $theValue = $valuesArray[$heckIt];
                $theConstraint = $row['the_constraint'];
                $referencedField = $row['reference_name'];
                $referencedTable = $row['reference_table'];
                //$oh_0 = $fieldsArray[0] . " " . $fieldsArray[1] . " " . $fieldsArray[2];
                //$doot = $doot . "$oh_0,$theField,$theValue,$heckIt,$theConstraint,$referencedField,$referencedTable|";
                switch ($theConstraint) {
                    case "UNIQUE":
                        //make sure the corresponding index from the valuesArray is unique
                        $conCheck = "select {$theField} from {$tableName} where {$theField} = ?;";
                        break;
                    case "PRIMARY KEY":
                        //this probably shouldn't be something we need to do - think about how to manage
                        break;
                    case "FOREIGN KEY":
                        //make sure the corresonding index from the valuesArray exists in the foreign table - need to update the query to allow for this
                        $conCheck = "select {$referencedField} from {$referencedTable} where {$referencedField} = ?;";
                        break;
                    default:
                        //nothing
                }
                //query the database for $conCheck
                $constraintOK = $pdo->prepare($conCheck);              
                if(!$constraintOK->execute(array($theValue))) {
                    //fail
                    echo json_encode(array("statusCode"=>102));
                    $constraintOK->connection = null;
                    exit();
                } else {
                    //pass
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
                        echo json_encode(array("statusCode"=>103,"fields"=>$fieldsArray,"value"=>$theValue,"values"=>$valuesArray,"heck"=>$heckIt));
                        exit();
                        //some kind of key violation has occurred and we are going to stop
                        //header("location: ../$returnFile?error=$errorString");
                        //exit();
                    }
                }
            }
        }
    }

    //$fieldsString = "name";
    $queryString = "insert into {$tableName} ({$fieldsString}) values ({$valueQs});";
    
    $stmt = $pdo->prepare($queryString);
    if (!$stmt->execute($valuesArray)) {
        //fail
        $stmt->connection = null;
        echo json_encode(array("statusCode"=>104));
        exit();
    } else {
        //pass
        echo json_encode(array("statusCode"=>100));
        exit();
    }
}
?>