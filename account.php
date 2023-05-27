<?php

    require_once 'dbconfig.php';

    session_start();

    if(!isset($_SESSION["nome_utente"])){
        echo("Non dovresti essere qui");
        header("Location: home.php");
        session_destroy();
        exit;
    }

    //Recupero le informazioni dell'utente

    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
        $username = mysqli_real_escape_string($conn, $_SESSION["nome_utente"]);

        $queryNome = "SELECT Nome FROM TabellaRegistrazione WHERE nome_utente = '".$username."'";
        $resNome = mysqli_query($conn, $queryNome);
        $Nome = mysqli_fetch_row($resNome)[0];

        $queryCognome = "SELECT Cognome FROM TabellaRegistrazione WHERE nome_utente = '".$username."'";
        $resCognome = mysqli_query($conn, $queryCognome);
        $Cognome = mysqli_fetch_row($resCognome)[0];

        $queryEmail = "SELECT Email FROM TabellaRegistrazione WHERE nome_utente = '".$username."'";
        $resEmail = mysqli_query($conn, $queryEmail);
        $Email = mysqli_fetch_row($resEmail)[0];

        $queryPropic = "SELECT ProfilePic FROM TabellaRegistrazione WHERE nome_utente = '".$username."'";
        $resPropic = mysqli_query($conn, $queryPropic);
        $Profile_pic = mysqli_fetch_row($resPropic)[0];


    ?>




<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>GeekInf - Il mio Account</title>
        <link rel="stylesheet" href="account.css">
        <link rel="stylesheet" href="home.css">
        <script src="account.js" defer></script>
        <script src="home.js" defer></script>
    </head>

    <body>
    <header>
    <nav>
                <a id="logo" href="home.php">
                    <img class="not_zoom" src="https://i.ibb.co/km4zGgg/Screenshot-2023-05-07-alle-17-37-16.png">
                </a>

                
                    
                <div id = 'links' >
                
                    <a href='search.php' id = 'search_button'>Ricerca Personalizzata</a>
                    <a href='favourites.php'>Preferiti</a>                        
                    
                </div>

                <a id = 'nav_icon_box' href=#>
                    <img src='assets/nav_icon.png' class = 'not_zoom'>
                </a>

            </nav>
        </header>

        <div id='nav_bar' class = 'hidden'>
            <div id= 'nav_box'>
                <a href='search.php' id = 'search_button' class= 'nav_row'>Ricerca Personalizzata</a>

                <?php

                    
                        echo "<a id = 'welcome_mobile' href = 'account.php' class='nav_row'>Benvenuto, ";
                                echo $username;
                            echo "</a>";
                        echo "<a href='favourites.php' class='nav_row'>Preferiti</a>";
                        echo "<a id = 'logout_mobile' href = 'logout.php?location=home.php' class='nav_row'>Logout</a>";
                        echo "<a href = 'account.php' id = image_container_nav>";
                                    echo "<img id = 'propic' ";
                                        echo "src='".$Profile_pic."'>";
                                echo "</a>";
                    

                ?>

            </div>
        </div>

        <div id='container'>

            <div id = 'account_popup'>

                <div id = 'information_box'>
                    <div id = 'title_box'>

                        <div id = 'propic_box'>
                            <img class = 'img_propic' 
                            
                            <?php
                                echo "src='".$Profile_pic."'";
                            ?>
                            >
                        </div>


                        <div>
                            <h2 id="title_box_text">Il mio account</h2>
                        </div>
                
                    </div>

                    <div id = 'inf_container'>

                        <div id = 'inf_box'>

                            <div id = 'inf_column_left'>
                                <div id = 'inf_row'>
                                    <h2 id = 'inf_text'> Nome Utente<h2>
                                </div>

                                <div id = 'inf_row'>
                                    <h2 id = 'inf_text'> Email<h2>
                                </div>

                                <div id = 'inf_row'>
                                    <h2 id = 'inf_text'> Nome<h2>
                                </div>

                                <div id = 'inf_row'>
                                    <h2 id = 'inf_text'> Cognome<h2>
                                </div>
                                
                            </div>

                            <div id = 'inf_column_right'>
                                <div id = 'inf_row'>
                                    <h2 id = 'inf_text'> 
                                        <?php    
                                            echo $username;
                                        ?>
                                    <h2>
                                </div>

                                <div id = 'inf_row'>
                                    <h2 id = 'inf_text'> 
                                        <?php    
                                            echo $Email;
                                        ?>
                                    <h2>
                                </div>

                                <div id = 'inf_row'>
                                    <h2 id = 'inf_text'> 
                                        <?php    
                                            echo $Nome;
                                        ?>
                                    <h2>
                                </div>

                                <div id = 'inf_row'>
                                    <h2 id = 'inf_text'> 
                                        <?php    
                                            echo $Cognome;
                                        ?>
                                    <h2>
                                </div>
                                
                            </div>
                        </div>

                    </div>

                    <div id='button_box'>
                        <a href= 'logout.php?location=home.php' id = 'logout_account'>Logout</a>
                        <a href = # id = 'change'>Modifica Account</a>
                    </div>
                </div>

                <div id = 'register_box' class='hidden'>
                        <div id = 'register_message'>
                            <h2 id="register_text">Modifica Account</h2>
                        </div>
                        <form id = 'form' method="post" enctype="multipart/form-data" name = 'form_register' action = "change_data.php" autocomplete="off">
                            <div id='form_container'>
                                <div id='form_level'>
                                    <label for="nome">Nome</label>
                                    <div id='form_error' class="hidden">
                                        <span>Riempi il campo Nome<span>
                                    </div> 
                                </div>
                                <input type="text" name="nome" class="nome">
                        </div>
                        <div id='form_container'>
                                <div id='form_level'>
                                    <label for="cognome">Cognome</label>
                                    <div id='form_error' class="hidden">
                                        <span>Riempi il campo Cognome<span>
                                    </div>    
                                </div>
                                <input type="text" name="cognome" class="cognome">   
                        </div>
                        <div id='form_container'>
                                <div id='form_level'>
                                    <label for="nome_utente">Username</label>
                                    <div id='form_error' class="hidden">
                                        <span><span>
                                    </div>   
                                </div>
                                <input type="text" name="nome_utente" class="username">   
                        </div>
                        <div id='form_container'>
                                <div id='form_level'>
                                    <label for="email">Email</label>
                                    <div id='form_error' class="hidden">
                                        <span>Email già in uso<span>
                                    </div>  
                                </div>
                                <input type="text" name="email" class="email">
                        </div>
                        <div id='form_container'>
                                <div id='form_level'>
                                    <label for="password">Password</label>
                                    <div id='form_error' class="hidden">
                                        <span>Inserisci almeno 8 caratteri<span>
                                    </div>    
                                </div>
                                <input type="password" name="password" class="password">  
                        </div>
                        <div id='form_container'>
                                <div id='form_level'>
                                    <label for="password">Conferma Password</label>
                                    <div id='form_error' class="hidden">
                                        <span>Le password devono coincidere<span>
                                    </div>   
                                </div>
                                <input type="password" name="password_confirm" class="password_confirm">    
                        </div>
                        <div id='form_container'>
                                <div id='form_level'>
                                    <label for="avatar">Scegli un'immagine profilo</label>
                                    <input type="file" accept='.jpg, .jpeg, image/gif, image/png' name="avatar" class="avatar">    
                                </div>
                                
                        </div>  
                        <label><input class="invio" type="submit"></label>
                        
                        </form>
                    </div>
                    


            </div>
        </div>

        <div id="bottom">
            <h4 id="bottom_text">Giampaolo Conti 1000014446  Web-Programming 2022/23</h4>
        </div>

    </body>







</html>