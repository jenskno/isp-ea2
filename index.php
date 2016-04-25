<?php
/**
 * Created by PhpStorm.
 * User: jens.knobloch
 * Date: 25.04.16
 * Time: 11:05
 */
ini_set('error_reporting', error_reporting(E_ALL));
define("ERR_VOID", "Feld leer");
define("ERR_SPEC_CHAR", "Sonderzeichen nicht erlaubt");

// Entgegennahme der Werte
$parameter = $_POST ? $_POST:$_GET;

echo print_header();
echo "<h1>Meine Wünsche</h1>";


echo print_form();




echo print_footer();




echo processing_parameters($parameter);


//components
/*
 * TO-DO Auslagern
 */

function  processing_parameters ($param=0){
    $return = "";
    foreach($param as $p => $v){
        $return .= check_input_field($v);
    }

    echo $return;

}

function print_form(){
    echo '<form action="index.php" method="get">';
    echo '<label for="field1">Text Field</label><input name="field1" id="field3" type="text"><br />';
    echo '<label for="field2">Text Field</label><input name="field2" id="field2" type="text"><br />';
    echo '<label for="field3">Text Field</label><input name="field3" id="field3" type="text"><br />';
    echo '<input type="reset">';
    echo '<input type="submit">';
    echo '</form>';
}





function print_header(){
echo <<< HEAD
<!doctype html>
<html lang="de">
    <head>
    <meta charset="utf-8">
    <meta name="description" content="Wunschformular">
    <meta name="keywords" content="">
    <link rel="stylesheet" type="text/css" href="example.css" media="all">
    <title>Einsendeaufgabe 2</title>
    </head>
    <body>
HEAD;
}

function print_footer(){
echo <<< FOOTER
 </body> </html>
FOOTER;

}

//Helper
function check_input_field($input_field ){
    $error = "";
    if (empty($input_field)){
        $error = ERR_VOID;
    }
    return $error;
}

?>




