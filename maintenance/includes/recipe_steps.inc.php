<?php
    $valuesArray = array();
    $fieldsArray = array();
    $tableName = $_POST['tablename'];
    $fieldsArray[0] = "recipe";
    $fieldsArray[1] = "step_number";
    $fieldsArray[2] = "step_text";
    $valuesArray[0] = $_POST['recipe'];
    $valuesArray[1] = $_POST['step_number'];
    $valuesArray[2] = $_POST['step_text'];

    include "writeto.inc.php";
    writeTo($fieldsArray,$valuesArray,$tableName);
?>