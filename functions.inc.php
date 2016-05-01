<?php
/**
 * Jens Knobloch
 * jens.knobloch@stud.fh-luebeck.de
 * 207845
 *
 */

// Formular schreiben: form-Tag
function print_form(){
    return "<form action='index.php' method='post'>";
}
// Formular schreiben: form-ende-Tag
function print_form_ende_tag(){
    return "</form>";
}

// Formular schreiben: form-Submit
function print_form_submit_tag($name=""){
    return "<input type='submit' id='$name' name='$name' value='Senden'>";
}

// Formular schreiben: form-Reset
function print_form_reset_tag($name=""){
    return '<input type="reset" id="$name" name="$name" value="Zurücksetzen">';
}

// Formular schreiben: Text-Inputfield
function print_form_input_text_field($name="void",$label="Void", $size=25, $maxlength=100, $value=""){
    return "<label for='$name'>$label: <input id='$name' name='$name' maxlength='$maxlength' size='$size' value='$value'></label><br />";
}

//Headlines schreiben
function print_headline($stat="", $size = 1){
    return "<h". $size . " class='headline_". $size ."'>" .  $stat . "</h".$size.">";
}

//Header der Seite
function print_header(){
    echo <<< HEAD
<!doctype html>
<html lang="de">
    <head>
    <meta charset="utf-8">
    <meta name="description" content="Wunschformular">
    <meta name="keywords" content="">
    <link rel="stylesheet" type="text/css" href="style.css" media="all">
    <title>Einsendeaufgabe 2</title>
    </head>
    <body>
HEAD;
}

// Gibt den Footer aus
function print_footer($debug = 0){
// 1= debug modus ; 0 = debug modus aus
    if ($debug == 1) {
        echo "<hr><p><h3>Kontrollausgabe</h3></p>";
        echo "<hr><pre>" . var_dump($_SESSION) . "</pre>";
    }
    echo <<< FOOTER
 </body> </html>
FOOTER;
}

// helping functions
function check_input_field($input_field){
    $error = "";
    //'/[a-zA-Z0-9 äöüß]+$/i' /einfache Version
    // False, wenn Zeichen, welche nicht zu dem Wertebereich gehören enthalten sind
     if (!preg_match("/^[A-Za-z 0-9\ü\è\ö\é\ä\à\Ä\Ö\Ü\-\.]*$/", $input_field)){
        $error = "Sonderzeichen sind nicht erlaubt!!";
    }
    return $error;
}

function check_PLZ_field($input_field){
    $error = "";
    // False, wenn keine fünf Ziffern enthalten sind
    if (!preg_match('/\d{5}/', $input_field)){
        $error = "Falsches PLZ-Format (fünfstellig und nur Ziffern)";
    }
    return $error;
}

function dump_wishes(){
    echo "1.Wunsch ... " . $_SESSION['wish1'] . " ... <br>";
    echo "2.Wunsch ... " . $_SESSION['wish2'] . " ... <br>";
    echo "3.Wunsch ... " . $_SESSION['wish3'] . " ... <br>";
    echo "<hr>";
}

function dump_address(){
    echo "Vorname ... " . $_SESSION['vname'] . " ... <br>";
    echo "Nachname ... " . $_SESSION['nname'] . " ... <br>";
    echo "PLZ  ... " . $_SESSION['plz'] . " Ort ... ";
    echo $_SESSION['ort'] . " ... <br>";
    echo "<hr>";
}

function print_error_messages($err=""){
    return "<pre class='red fett'> " . $err. "</pre>";
}