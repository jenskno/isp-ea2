<?php
session_start();
require_once (__DIR__ . '/functions.inc.php');
ini_set('error_reporting', error_reporting(E_ALL));

// declare / init array for form text input fields for wishes and addresses
$wishes_input_fields = array();
$wishes_input_fields[] = array('name' => 'wish1', 'label' => 'Wunsch 1','value' => '');
$wishes_input_fields[] = array('name' => 'wish2', 'label' => 'Wunsch 2','value' => '');
$wishes_input_fields[] = array('name' => 'wish3', 'label' => 'Wunsch 3','value' => '');

$address_input_fields = array();
$address_input_fields[] = array('name' => 'vname', 'label' => 'Vorname','value' => '');
$address_input_fields[] = array('name' => 'nname', 'label' => 'Nachname','value' => '');
$address_input_fields[] = array('name' => 'plz', 'label' => 'PLZ','value' => '');
$address_input_fields[] = array('name' => 'ort', 'label' => 'Ort','value' => '');

/* Seitenkopf */
print_header();
/* Begrüßung */
if (!isset($_SESSION['visited'])) {
    echo print_headline ("Hallo zu &quot;Meine Wünsche&quot;",1);
    $_SESSION['visited'] = true;
    $_SESSION['errors'] = false;
    $_SESSION['sent_wishes'] = false;
    $_SESSION['wishes_handling'] = true;
    $_SESSION['address_handling'] = false;
    $_SESSION['overview_handling'] = false;
} else {
    $_SESSION['wishes_handling'] = true;
}


/* Behandlung der Post-Variablen:
 * diese sollen auf Session-Variablen geschrieben werden, wenn
 * diese sich unterscheiden in den entsprechenden Inhalten
 */

//Entgegennahme der Post-Variablen
// Wünsche
if ($_POST['wishes_submit']){
    $_SESSION['sent_wishes'] = true;
    $error_messages = array();
    $error_flag = false;
    // Wenn neuer/anderer POST-Wert übergeben wurde
    if ($_SESSION['wish1'] != $_POST['wish1']){
        $_SESSION['wish1'] = $_POST['wish1'];

    }
    //Prüfung ob leer oder Sonderzeichen
    $error_messages[0] = check_input_field(trim($_SESSION['wish1']));
    if(!empty($error_messages[0])){$error_flag = true;}
    $wishes_input_fields[0]['value'] = $_SESSION['wish1'];

    if ($_SESSION['wish2'] != $_POST['wish2']){
        $_SESSION['wish2'] = $_POST['wish2'];
    }
    $error_messages[1] = check_input_field(trim($_SESSION['wish2']));
    if(!empty($error_messages[1])){$error_flag = true;}
    $wishes_input_fields[1]['value'] = $_SESSION['wish2'];

    if ($_SESSION['wish3'] != $_POST['wish3']){
        $_SESSION['wish3'] = $_POST['wish3'];
    }
    $error_messages[2] = check_input_field(trim($_SESSION['wish3']));
    if(!empty($error_messages[2])){$error_flag = true;}
    $wishes_input_fields[2]['value'] = $_SESSION['wish3'];

    if($error_flag === false){
        //Umschalten zum nächsten Formular
        $_SESSION['address_handling'] = true;
        $_SESSION['wishes_handling'] = false;
        $_SESSION['overview_handling'] = false;
    }
}

if ($_POST['address_submit']){
    $_SESSION['sent_address'] = true;
    $_SESSION['wishes_handling'] = false;
    $_SESSION['overview_handling'] = false;
    $_SESSION['sent_wishes'] = false;
    $error_messages_ad = array();
    $error_flag_ad = false;

    //
    // Wenn neuer/anderer POST-Wert übergeben wurde
    if ($_SESSION['vname'] != $_POST['vname']){
        $_SESSION['vname'] = $_POST['vname'];

    }
    //Prüfung ob leer oder Sonderzeichen
    $error_messages_ad[0] = check_input_field(trim($_SESSION['vname']));
    if(!empty($error_messages_ad[0])){$error_flag_ad = true;}
    $address_input_fields[0]['value'] = $_SESSION['vname'];



    if ($_SESSION['nname'] != $_POST['nname']){
        $_SESSION['nname'] = $_POST['nname'];
    }
    $error_messages_ad[1] = check_input_field(trim($_SESSION['nname']));
    if(!empty($error_messages_ad[1])){$error_flag_ad = true;}
    $address_input_fields[1]['value'] = $_SESSION['nname'];



    if ($_SESSION['plz'] != $_POST['plz']){
        $_SESSION['plz'] = $_POST['plz'];
    }
    $error_messages_ad[2] = check_plz_field(trim($_SESSION['plz']));
    if(!empty($error_messages_ad[2])){$error_flag_ad = true;}
    $address_input_fields[2]['value'] = $_SESSION['plz'];

    if ($_SESSION['ort'] != $_POST['ort']){
        $_SESSION['ort'] = $_POST['ort'];
    }
    $error_messages_ad[3] = check_input_field(trim($_SESSION['ort']));
    if(!empty($error_messages_ad[3])){$error_flag_ad = true;}
    $address_input_fields[3]['value'] = $_SESSION['ort'];

    if($error_flag_ad === false){
        //Umschalten zum nächsten Formular
        $_SESSION['address_handling'] = false;
        $_SESSION['wishes_handling'] = false;
        $_SESSION['overview_handling'] = true;
    }
}

// Wenn das Wunschformular angezeigt werden soll
if ($_SESSION['wishes_handling'] == true) {

// Das Formular wird geschrieben
    echo print_headline ("Meine Wünsche",1);
    echo print_form();
    for ($i = 0; $i <= 2; $i++) {
        echo print_form_input_text_field($wishes_input_fields[$i]['name'],$wishes_input_fields[$i]['label'],25,100,trim($wishes_input_fields[$i]['value']));
        if(!empty($error_messages[$i])){
            echo "<pre class='red fett'> $error_messages[$i] </pre>";
        }
    }
    echo print_form_reset_tag("wishes_reset");
    echo print_form_submit_tag("wishes_submit");
    echo print_form_ende_tag();
}


// next step
if ( ($_SESSION['address_handling'] === true) && ($_SESSION['wishes_handling'] === false)  ){
    echo print_headline ("Lieferangaben",1);
    echo dump_wishes();

    echo print_form();
    for ($i = 0; $i <= 3; $i++) {
        $size = ($address_input_fields[$i]['name'] == 'plz') ? 5:25;
        $length = ($address_input_fields[$i]['name'] == 'plz') ? 5:100;
        echo print_form_input_text_field($address_input_fields[$i]['name'],$address_input_fields[$i]['label'],$size,$maxlength,trim($address_input_fields[$i]['value']));
        if(!empty($error_messages_ad[$i])){
            echo "<pre class='red fett'> $error_messages_ad[$i] </pre>";
        }
    }
    echo print_form_reset_tag("address_reset");
    echo print_form_submit_tag("address_submit");
    echo print_form_ende_tag();
}

// next step
if ( ($_SESSION['address_handling'] === false) && ($_SESSION['wishes_handling'] === false)   && ($_SESSION['overview_handling'] === true) ){
    echo print_headline ("Wunschübersicht",1);
    echo dump_wishes();
    echo dump_address();
    session_destroy();
}



/* Fusszeile */
print_footer(1);

?>