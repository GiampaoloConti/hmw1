
<?php

require_once 'dbconfig.php';

session_start();

header('Content-Type: application/json');

if(!isset($_GET["user_id"])){
    echo "errore";
    exit;
}

if(isset($_SESSION["nome_utente"]) && isset($_GET["user_id"])){

    if($_SESSION["nome_utente"] === $_GET["user_id"]){
        echo json_encode(array('exists' => true));
        exit;
    }
    
     echo json_encode(array('exists' => false));

     exit;

}

echo json_encode(array('exists' => false));




?>