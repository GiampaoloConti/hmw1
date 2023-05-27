
<?php

    require_once 'dbconfig.php';

    session_start();

    header('Content-Type: application/json');

    //se non è settata la sessione o non abbiamo testo, articolo e propic usciamo
    if(!isset($_SESSION["nome_utente"]) || !isset($_GET["text_value"]) || !isset($_GET["link"]) || !isset($_GET["propic"])){
        echo "non dovresti essere qui";
        header("Location: home.php");
        exit;
    }

    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $username = mysqli_real_escape_string($conn, $_SESSION["nome_utente"]);
    $text = mysqli_real_escape_string($conn, $_GET["text_value"]);
    $url = trim(mysqli_real_escape_string($conn, $_GET["link"]));
    $Propic = trim(mysqli_real_escape_string($conn, $_GET["propic"]));

    //Se è passata get q vogliamo cancellare un commento, sennò vogliamo inserirlo
    if(isset($_GET["q"]))
    $query = "DELETE FROM Commenti WHERE UserID = '$username' AND Link = '$url' AND ProfilePic = '$Propic' AND Testo = '$text'";
    
    else $query = "INSERT INTO Commenti(UserID, Link, ProfilePic, Testo) VALUES('$username','$url','$Propic','$text')";
    
    $res = mysqli_query($conn, $query);

    $entry = array('UserID'=> $username, 'Link' => $url, 'ProfilePic' => $Propic, 'Testo' => $_GET["text_value"]);

    echo json_encode($entry);




?>