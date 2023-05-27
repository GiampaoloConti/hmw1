<?php
    session_start();

    require_once 'dbconfig.php';


    if(!isset($_GET['location'])){
        header("Location: home.php");
        exit;
    }

    if (isset($_SESSION["nome_utente"])) {
        header("Location: home.php");
        exit;
    }

    $error = array();

    // Verifica l'esistenza di dati POST
    if (!empty($_POST["nome_utente"]) && !empty($_POST["password"]) && !empty($_POST["email"]) && !empty($_POST["nome"]) && !empty($_POST["cognome"]) && !empty($_POST["password_confirm"]))
    {
        $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
        
        # USERNAME
        // Controlla che l'username rispetti il pattern specificato
        if (!preg_match('/^[a-zA-Z0-9_]{1,15}$/', $_POST['nome_utente'])) {
            $error[] = "Username non valido";
        } else {
            $username = mysqli_real_escape_string($conn, $_POST['nome_utente']);
            // Cerco se l'username esiste già o se appartiene a una delle 3 parole chiave indicate
            $query = "SELECT Nome_utente FROM TabellaRegistrazione WHERE Nome_utente = '$username'";
            $res = mysqli_query($conn, $query);
            if (mysqli_num_rows($res) > 0) {
                $error[] = "Username già utilizzato";
            }
        }
        
        # PASSWORD
        if (strlen($_POST["password"]) < 8) {
            $error[] = "Caratteri password insufficienti";
        } 

        # CONFERMA PASSWORD
        if (strcmp($_POST["password"], $_POST["password_confirm"]) != 0) {
            $error[] = "Le password non coincidono";
        }

        # EMAIL
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $error[] = "Email non valida";
        } else {
            $email = mysqli_real_escape_string($conn, strtolower($_POST['email']));
            $res = mysqli_query($conn, "SELECT Email FROM TabellaRegistrazione WHERE Email = '$email'");
            if (mysqli_num_rows($res) > 0) {
                $error[] = "Email già utilizzata";
            }
        }

        # UPLOAD DELL'IMMAGINE DEL PROFILO  
        if ($_FILES['avatar']['size'] != 0) {
            $file = $_FILES['avatar'];
            $type = exif_imagetype($file['tmp_name']);
            $allowedExt = array(IMAGETYPE_PNG => 'png', IMAGETYPE_JPEG => 'jpg', IMAGETYPE_GIF => 'gif');
            if (isset($allowedExt[$type])) {
                if ($file['error'] === 0) {
                    if ($file['size'] < 7000000) {
                        $fileNameNew = uniqid('', true).".".$allowedExt[$type];
                        $fileDestination = 'assets/'.$fileNameNew;
                        if (move_uploaded_file($file['tmp_name'], $fileDestination)) {
                            // File uploaded successfully
                        } else {
                            $error[] = "Failed to move uploaded file";
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
        } else {
            $fileDestination = 'assets/anonymous.jpeg';
        }

        # REGISTRAZIONE NEL DATABASE
        if (count($error) == 0) {
            $name = mysqli_real_escape_string($conn, $_POST['nome']);
            $surname = mysqli_real_escape_string($conn, $_POST['cognome']);

            $password = mysqli_real_escape_string($conn, $_POST['password']);
            $password = password_hash($password, PASSWORD_BCRYPT);

            $query = "INSERT INTO TabellaRegistrazione(Nome_utente, Password, Nome, Cognome, Email, ProfilePic) VALUES('$username', '$password', '$name', '$surname', '$email', '$fileDestination')";
            
            if (mysqli_query($conn, $query)) {
                $_SESSION["nome_utente"] = $_POST["nome_utente"];
                mysqli_close($conn);
                header("Location: " .$_GET['location']);
                exit;
            } else {
                $error[] = "Errore di connessione al Database";
            }
        }

        mysqli_close($conn);
    } else if (isset($_POST["nome_utente"])) {
        $error[] = "Riempi tutti i campi";
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Signup</title>
</head>
<body>
    <?php
        if (!empty($error)) {
            foreach ($error as $err) {
                echo "$err";
            }
            exit;
        }
    ?>
</body>
</html>