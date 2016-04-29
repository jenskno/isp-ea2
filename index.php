<?php
session_start();
ini_set('error_reporting', error_reporting(E_ALL));
define("ERR_VOID", "Feld leer");
define("ERR_SPEC_CHAR", "Sonderzeichen nicht erlaubt");

// Entgegennahme der Werte
$parameter = $_POST ? $_POST:$_GET;

$_SESSION['errors'] = false;
$_SESSION['sent_wishes'] = false;


var_dump($_POST);

echo print_header();

if (!isset($_SESSION['visited'])) {
    echo print_status ("Hallo Fremder");
    $_SESSION['visited'] = true;
    $_SESSION['errors'] = false;
    $_SESSION['sent_wishes'] = false;
} else {
    echo print_status ("Willkommen zurück");
}

if ($_SESSION['visited'] === true){
    echo print_wish_form();
    print_r($parameter);
}

if ($parameter['wishes_submit']){
    echo "<h2>hallo</h2>";

    //Jeden Wunsch auf Sonderzeichen prüfen
    $check = false;
    $error_arr = array();
    $wishes = array('wish1' => $parameter['wish1'],'wish2' => $parameter['wish2'], 'wish3' => $parameter['wish3']);

        foreach($wishes as $p => $v){
            // wishes auf session_var
            $_SESSION[$p] = $v;
            /*if(check_input_field($v)){
                //wenn falsch dann in error als fehlend
            }
            */
            if(check_special_characters($v)){
                //wenn falsch dann in error als Sonderzeichen
            }

        }
}


if ($_SESSION['sent_wishes'] === true){
    echo print_adress_form();
}


echo print_footer();
echo processing_parameters($parameter);

//session_destroy();


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

function print_wish_form(){
    $wish1_val =  isset($_SESSION['wish1']) ? $_SESSION['wish1'] : "";
    $wish2_val =  isset($_SESSION['wish2']) ? $_SESSION['wish2'] : "";
    $wish3_val =  isset($_SESSION['wish3']) ? $_SESSION['wish3'] : "";

    echo '<form action="index.php" method="post">';
    echo '<label for="wish1">Wunsch 1</label><input name="wish1" id="wish1" type="text" value="'. $wish1_val .'"><br />';
    echo '<label for="wish2">Wunsch 2</label><input name="wish2" id="wish2" type="text" value="'. $wish2_val .'"><br />';
    echo '<label for="wish3">Wunsch 3</label><input name="wish3" id="wish3" type="text" value="'. $wish3_val .'"><br />';
    echo '<input type="reset" id="wishes_reset" name="wishes_reset" value="Zurücksetzen">';
    echo '<input type="submit" id="wishes_submit" name="wishes_submit" value="Senden">';
    echo '</form>';
}

function print_adress_form(){
    echo '<form action="index.php" method="post">';
    echo '<label for="vorname">Text Field</label><input name="vorname" id="vorname" type="text"><br />';
    echo '<label for="nachname">Text Field</label><input name="nachname" id="nachname" type="text"><br />';
    echo '<label for="strasse">Text Field</label><input name="strasse" id="strasse" type="text"><br />';
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
echo "<hr><p><h3>Kontrollausgabe</h3></p>";
echo "<hr><pre>" . var_dump($_SESSION) . "</pre>";
echo <<< FOOTER
 </body> </html>
FOOTER;
session_destroy();
}


function print_status($stat=""){

    return "<h1>" .  $stat . "</h1>";

}


//Helper
function check_input_field($input_field){
    $error = "";
    if (empty($input_field)){
        $error = ERR_VOID;
    }
    return $error;
}

function check_special_characters($temp){
    return preg_match('/^[0-9a-z]+$/i', $temp);
}

?>




