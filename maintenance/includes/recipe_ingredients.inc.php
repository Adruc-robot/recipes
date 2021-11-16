<?php
    $valuesArray = array();
    $fieldsArray = array();
    $tableName = $_POST['tablename'];
    $fieldsArray[0] = "RECIPE";
    $fieldsArray[1] = "INGREDIENT";
    $fieldsArray[2] = "AMOUNT";
    //$fieldsArray[3] = "unit";
    $fieldsArray[3] = "UNIT";
    $fieldsArray[4] = "PREP_INSTRUCTIONS";
    $valuesArray[0] = $_POST['RECIPE'];
    $valuesArray[1] = $_POST['INGREDIENT'];
    $valuesArray[2] = $_POST['AMOUNT'];
    $valuesArray[3] = $_POST['UNIT'];
    $valuesArray[4] = $_POST['PREP_INSTRUCTIONS'];

    include "writeto.inc.php";
    writeTo($fieldsArray,$valuesArray,$tableName);
?>