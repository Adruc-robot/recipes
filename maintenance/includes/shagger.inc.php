<?php
    include "dbinfo.inc.php";
    
    $valuesArray = array();
    $fieldsArray = array();
    //$name = $_POST['name'];
    $fieldsArray[0] = "name";
    $valuesArray[0] = $_GET['name'];
    $tableName = $_GET['tablename'];

    $pdo = new PDO($dns, $user, $pass, $opt);
    $fieldsString = implode(',', $fieldsArray);
    //can delete
    $valuesString = implode(',', $valuesArray);
    $valueQs = str_repeat('?,', count($valuesArray) - 1) . '?';
    //not sure if this needs to be prepared, but doing to make sure people aren't updating the classes
    $theQuery = "select the_key from recipes where name = ?";
    $getData = $pdo->prepare($theQuery);
    if(!$getData->execute($valuesArray)) {
        $data["statusCode"] = 105;
    } else {
        $dataColl = $getData->fetch();
        $data["theKey"] = $dataColl["the_key"];
        $data["statusCode"] = 100;
    }
    echo json_encode($data);
?>