<?php

    //prendo la location così da riportare l'utente alla pagina precedente al login
    function checkData($Location){
    if (isset($_POST["nome_utente"]) && isset($_POST["password"]) )
    {

        // Se username e password sono stati inviati
        // Connessione al DB
        $conn = mysqli_connect("localhost", "root", "", 'hmw1');

        $username = mysqli_real_escape_string($conn, $_POST['nome_utente']);
        // ID e Username per sessione, password per controllo
        $query = "SELECT * FROM TabellaRegistrazione WHERE Nome_utente = '".$username."'";
        // Esecuzione
        $res = mysqli_query($conn, $query) or die(mysqli_error($conn));;
        
        if (mysqli_num_rows($res) > 0) {
            // Ritorna una sola riga, il che ci basta perché l'utente autenticato è solo uno
            $entry = mysqli_fetch_assoc($res);
            if (password_verify($_POST['password'], $entry['Password'])) {

                // Imposto una sessione dell'utente
                session_start();
                $_SESSION["nome_utente"] = $entry['Nome_utente'];
                header("Location:".$Location);
                mysqli_free_result($res);
                mysqli_close($conn);
                exit;
            }
            else{
                $error = "Username e/o password errati.";
                return $error;
            }
        }
        else{
        // Se l'utente non è stato trovato o la password non ha passato la verifica
            $error = "Username e/o password errati.";
            return $error;
        }
    }

}

?>