<?php

require_once 'dbconfig.php';

session_start();

if (!isset($_SESSION["nome_utente"])) {
    echo("Non dovresti essere qui");
    header("Location: home.php");
    session_destroy();
    exit;
}

header('Content-Type: application/json');

$conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);

if (!$conn) {
    echo json_encode(array('error' => 'Failed to connect to the database.'));
    exit;
}

//dipendentemente da cosa riceviamo dobbiamo verificare i dati 

$username = mysqli_real_escape_string($conn, $_SESSION["nome_utente"]);

if (isset($_GET["name"])) {
    $Nome = mysqli_real_escape_string($conn, $_GET["name"]);

    $query = "SELECT * FROM TabellaRegistrazione WHERE Nome_utente = '$username' AND Nome = '$Nome'";
    $res = mysqli_query($conn, $query);

    if (!$res) {
        echo json_encode(array('error' => 'Query failed: ' . mysqli_error($conn)));
        exit;
    }

    echo json_encode(array('exists' => mysqli_num_rows($res) > 0 ? true : false));

} else if (isset($_GET["surname"])) {
    $Cognome = mysqli_real_escape_string($conn, $_GET["surname"]);

    $query = "SELECT * FROM TabellaRegistrazione WHERE Nome_utente = '$username' AND Cognome = '$Cognome'";
    $res = mysqli_query($conn, $query);

    if (!$res) {
        echo json_encode(array('error' => 'Query failed: ' . mysqli_error($conn)));
        exit;
    }

    echo json_encode(array('exists' => mysqli_num_rows($res) > 0 ? true : false));

} else if (isset($_GET["password"])) {
    $Password = mysqli_real_escape_string($conn, $_GET["password"]);

    $query = "SELECT * FROM TabellaRegistrazione WHERE Nome_utente = '$username'";
    $res = mysqli_query($conn, $query);

    if (!$res) {
        echo json_encode(array('error' => 'Query failed: ' . mysqli_error($conn)));
        exit;
    }

    if (mysqli_num_rows($res) > 0) {
        $entry = mysqli_fetch_assoc($res);

        if (password_verify($Password, $entry['Password'])) {
            echo json_encode(array('exists' => true));
        } else {
            echo json_encode(array('exists' => false));
        }
    } else {
        echo json_encode(array('exists' => false));
    }
}
