<?php

require_once 'dbconfig.php';

session_start();

if (!isset($_SESSION["nome_utente"])) {
    session_destroy();
    header("Location: home.php");
    exit;
}

$error = array();

$conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);

$username = mysqli_real_escape_string($conn, $_SESSION["nome_utente"]);

if(!empty($_POST['nome_utente'])){

    //controllo che non esista già

    $new_username = mysqli_real_escape_string($conn, $_POST["nome_utente"]);


    $query = "SELECT Nome_utente FROM TabellaRegistrazione
                WHERE Nome_utente = '$new_username'";

    $res = mysqli_query($conn, $query) or die(mysqli_error($conn)); 

    if(mysqli_num_rows($res) === 0){

        $query = "UPDATE TabellaRegistrazione
                    SET Nome_utente = '$new_username' WHERE Nome_utente = '$username'";
        $res = mysqli_query($conn, $query) or die(mysqli_error($conn)); 
        $_SESSION["nome_utente"] = $new_username;

        $username = mysqli_real_escape_string($conn, $_SESSION["nome_utente"]);

    } else $error[] = "Username già utilizzato";

}


if(!empty($_POST['nome'])){

    $new_nome = mysqli_real_escape_string($conn, $_POST["nome"]);

    $query = "SELECT * FROM TabellaRegistrazione
                WHERE Nome_utente = '$username' AND Nome = '$new_nome'";

    $res = mysqli_query($conn, $query) or die(mysqli_error($conn)); 

    if(mysqli_num_rows($res) === 0){

        $query = "UPDATE TabellaRegistrazione
                    SET Nome = '$new_nome' WHERE Nome_utente = '$username'";
        $res = mysqli_query($conn, $query) or die(mysqli_error($conn)); 

    } else $error[] = "Nome uguale al precedente";

}

if(!empty($_POST['cognome'])){

    $new_cognome = mysqli_real_escape_string($conn, $_POST["cognome"]);

    $query = "SELECT * FROM TabellaRegistrazione
                WHERE Nome_utente = '$username' AND Cognome = '$new_cognome'";

    $res = mysqli_query($conn, $query) or die(mysqli_error($conn)); 

    if(mysqli_num_rows($res) === 0){

        $query = "UPDATE TabellaRegistrazione
                    SET Cognome = '$new_cognome' WHERE Nome_utente = '$username'";
        $res = mysqli_query($conn, $query) or die(mysqli_error($conn)); 

    } else $error[] = "Cognome uguale al precedente";

}

if(!empty($_POST['email'])){

    $new_email = mysqli_real_escape_string($conn, $_POST["email"]);

    $query = "SELECT * FROM TabellaRegistrazione
                WHERE Email = '$new_email'";

    $res = mysqli_query($conn, $query) or die(mysqli_error($conn)); 

    if(mysqli_num_rows($res) === 0){

        $query = "UPDATE TabellaRegistrazione
                    SET Email = '$new_email' WHERE Nome_utente = '$username'";
        $res = mysqli_query($conn, $query) or die(mysqli_error($conn)); 

    } else $error[] = "Email già in uso";

}

if(!empty($_POST['password']) && $_POST['password_confirm'] == $_POST['password']){

    $new_password = mysqli_real_escape_string($conn, $_POST["password"]);

    $query = "SELECT * FROM TabellaRegistrazione WHERE Nome_utente = '$username'";
    $res = mysqli_query($conn, $query);

    if (mysqli_num_rows($res) > 0) {
        $entry = mysqli_fetch_assoc($res);

        if (password_verify($new_password, $entry['Password'])) {
            $error[] = 'La password deve essere diversa dalla precedente';
        } else {
           
            $password = password_hash($new_password, PASSWORD_BCRYPT);
            $query = "UPDATE TabellaRegistrazione
                    SET Password = '$password' WHERE Nome_utente = '$username'";
            $res = mysqli_query($conn, $query) or die(mysqli_error($conn)); 
        }
    } else {
        $error[] = 'errore di connessione al database';
    }
}

if ($_FILES['avatar']['size'] != 0) {
    $file = $_FILES['avatar'];
    $type = exif_imagetype($file['tmp_name']);
    $allowedExt = array(IMAGETYPE_PNG => 'png', IMAGETYPE_JPEG => 'jpg', IMAGETYPE_GIF => 'gif');
    if (isset($allowedExt[$type])) {
        if ($file['error'] === 0) {
            if ($file['size'] < 7000000) {
                $fileNameNew = uniqid('', true).".".$allowedExt[$type];
                $fileDestination = 'assets/'.$fileNameNew;

                $query = "SELECT * FROM TabellaRegistrazione WHERE Nome_utente = '$username' AND ProfilePic = '$fileDestination'";
                $res = mysqli_query($conn, $query);

                if (mysqli_num_rows($res) == 0) {

                    if (move_uploaded_file($file['tmp_name'], $fileDestination)) {
                        // File uploaded successfully
                        $query = "UPDATE TabellaRegistrazione
                                SET ProfilePic = '$fileDestination' WHERE Nome_utente = '$username'";
                        $res = mysqli_query($conn, $query) or die(mysqli_error($conn)); 
                    } else {
                        $error[] = "Failed to move uploaded file";
                    }

            } else{
                $error[] = "The image is the same";
            }
            } else {
                $error[] = "The image should not exceed 7MB in size";
            }
        } else {
            $error[] = "Error uploading the file";
        }
    } else {
        $error[] = "Only .png, .jpeg, .jpg, and .gif formats are allowed";
    }
}

//se c'è anche solo un errore lo stampi e blocchi il sito
foreach($error as $errors){ echo $errors; $i=true; }

if($i) exit;

header("Location: account.php");










?>