<?php

    require_once 'dbconfig.php';

    session_start();
    if(!isset($_SESSION["nome_utente"])){
        echo "Non dovresti essere qui";
        exit();
    }

    header('Content-Type: application/json');

    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);

    if(!isset($_GET["Autore"]) || !isset($_GET["Immagine"]) || !isset($_GET["Link"])){
        echo "Errore nel caricamento dei dati";
        exit;
    }


    $username = mysqli_real_escape_string($conn, $_SESSION["nome_utente"]);
    if(isset($_GET["Titolo"])) $title = mysqli_real_escape_string($conn, $_GET["Titolo"]);
    if(isset($_GET["Contenuto"])) $content = mysqli_real_escape_string($conn, $_GET["Contenuto"]);
    $author = mysqli_real_escape_string($conn, $_GET["Autore"]);
    $image = mysqli_real_escape_string($conn, $_GET["Immagine"]);
    $url = mysqli_real_escape_string($conn, $_GET["Link"]);

    
    $query = "SELECT * FROM Preferiti WHERE UserID = '".$username."' AND Autore = '".$author."' AND Immagine = '".$image."' AND Link = '".$url."'" ;


    $res = mysqli_query($conn, $query);

            if (mysqli_num_rows($res) > 0) {

                //lo dobbiamo rimuovere

                $query = "DELETE FROM Preferiti WHERE UserID = '$username' AND Autore = '$author' AND Immagine = '$image' AND Link = '$url'";
                $res = mysqli_query($conn, $query);
                
                echo json_encode(array('done' => 'delete'));
                exit;
            }

            else{

            //lo dobbiamo aggiungere

            if(isset($title) && isset($content)){
            $query = "INSERT INTO Preferiti(UserID, Titolo, Contenuto, Autore, Immagine, Link) VALUES('".$username."', '".$title."', '".$content."', '".$author."', '".$image."', '".$url."')";
            $res = mysqli_query($conn, $query);

            echo json_encode(array('done' => 'insert'));
            exit;

            }

            }

            echo json_encode(array('done' => 'none'));
            
?>