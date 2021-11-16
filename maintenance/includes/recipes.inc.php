<?php
    //global $name, $tableName, $valuesArray, $fieldsArray, $valueQs;
    
    $valuesArray = array();
    $fieldsArray = array();
    //$name = $_POST['name'];
    $fieldsArray[0] = "name";
    $valuesArray[0] = $_POST['name'];
    $tableName = $_POST['tablename'];

    include "writeto.inc.php";
    writeTo($fieldsArray,$valuesArray,$tableName);
?>