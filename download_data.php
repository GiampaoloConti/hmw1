<?php

require_once 'dbconfig.php';

    header('Content-Type: application/json');

    session_start();

    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);

    //se è settato il q e c'è un utente significa che vogliamo i preferiti
    if(isset($_GET['q']) && isset($_SESSION["nome_utente"])){

        $username = mysqli_real_escape_string($conn, $_SESSION["nome_utente"]);
        $query = "SELECT * FROM Preferiti WHERE UserID = '$username'";

    }

    elseif(isset($_GET["link"])){

        //se è settato link vogliamo i commenti (anche senza utente)
        $url = trim(mysqli_real_escape_string($conn, $_GET["link"]));
        $query = "SELECT * FROM Commenti WHERE Link = '$url'";

    }

    else{
        //altrimenti vogliamo i contenuti
        $query = "SELECT * FROM Contenuti";
    } 


    $res = mysqli_query($conn, $query);

    $rows = array(); // Array

    while ($row = mysqli_fetch_assoc($res)) {
        $rows[] = $row; 
    }

    // Da array a json
    $json = json_encode($rows);

    print_r($json);
?>
