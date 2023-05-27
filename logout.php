<?php

    session_start();

    if(!isset($_SESSION["nome_utente"])){
        echo("Non dovresti essere qui");
        header("Location: home.php");
        exit;
    }

    session_destroy();
    header("Location: ".$_GET["location"]);

?>