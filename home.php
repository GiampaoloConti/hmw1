<?php

require_once 'dbconfig.php';

    //Includiamo la pagina php con la funzione per controllare le credenziali 
    include_once 'login.php';
    session_start();

    //Se è settata la sessione recuperiamo la foto del profilo
    if(isset($_SESSION["nome_utente"])){
        $user_id = $_SESSION["nome_utente"];

        $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);

        $username = mysqli_real_escape_string($conn, $user_id);
        $query = "SELECT ProfilePic FROM TabellaRegistrazione WHERE Nome_utente = '".$username."'";
        $res = mysqli_query($conn, $query);
        $row = mysqli_fetch_row($res);
        $Profile_pic = $row[0];

    }
    else session_destroy();

    //Se abbiamo ricevuto delle variabili POST controlliamo le credenziali  
    $error = checkData("home.php");

?>








<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>GeekInf - Home</title>
        <link rel="stylesheet" href="home.css">
        <script src="home.js" defer></script>
        <script src="signup.js" defer></script>
        <script src="login.js" defer></script>
        <script src="content_download.js" defer></script>
    </head>

    <body 
        <?php           
            if(isset($error))
                echo "class = 'no-scroll'";
        ?>
        >
        <div id="overlay"
        <?php           
            if(!isset($error))
                echo "class = 'hidden'";
        ?>
        >

        <!--Popup che appare quando clicchiamo su login-->
            <div class = 'login_popup'
            <?php           

            //Se checkData() torna errore ricarichiamo la pagina col popup già su schermo
                if(!isset($error))
                    echo "class = 'hidden'";
            ?>
             >
                <div id = 'login_box'>
                    <div id = 'login_message'>
                        <h2 id="login_text">Login</h2>
                    </div>
                    <form method="post" name = 'form_login' action="home.php">
                        <div id='form_container_login'>
                            <div id='form_level'>
                                <label for="nome_utente">Username</label>  
                            </div>
                            <input type="text" name="nome_utente" class = "login_username">   
                        </div>
                        <div id='form_container_login'>
                            <div id='form_level'>
                                <label for="password">Password</label>    
                            </div>
                            <input type="password" name="password" class = "login_password">  
                        </div>
                        <label><input class="login_submit" type="submit"></label>
                    </form>

                    <!--Stampiamo l'errore di checkData()-->
                    <div id='login_error' 
                    <?php
                        if(!isset($error))
                        echo "class='hidden'"
                    ?>
                    >
                        <span>
                        <?php
                        if(isset($error)) echo $error;
                        ?>
                        <span>
                    </div> 
                    <div id= 'register_button'>
                        <h5>Non ancora un utente?</h5>
                        <label><input id="register" type="submit" value="Registrati"></label>
                    </div>
                </div>

                <div id = 'register_box' class='hidden'>
                    <div id = 'register_message'>
                        <h2 id="register_text">Registrati</h2>
                    </div>
                    <form id = 'form' method="post" enctype="multipart/form-data" name = 'form_register' action = "signup.php?location=home.php" autocomplete="off">
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
                                    <div id='form_error' class="hidden">
                                        <span>Le dimensioni del file superano 7 MB<span>
                                    </div>   
                                </div>
                                <div id='final_row'>
                                    <input type="file" accept='.jpg, .jpeg, image/gif, image/png' name="avatar" class="avatar">  
                                    <div id= 'login_button'>
                                        <h5>Hai già un account?</h5>
                                        <a id="login">Login</a>
                                    </div>
                                </div>  
                        </div>  
                        <label><input class="invio" type="submit"></label>               
                    </form>
                </div>
            </div>        
        </div>

        <header>
            <nav>
                <a id="logo" href="home.php">
                    <img class="not_zoom" src="https://i.ibb.co/km4zGgg/Screenshot-2023-05-07-alle-17-37-16.png">
                </a>

                
                    
                <div id = 'links' >
                    <a href=# id ='anime_button'>Anime</a>
                    <a href=# id ='cinema_button'>Cinema</a>
                    <a href=# id ='tv_button'>TV</a>
                    <a href=# id= 'videogames_button'>Videogiochi</a>
                    <a href='search.php' id = 'search_button'>Ricerca Personalizzata</a>

                    <!--Se settata la sessione preferiti deve portare alla pagina dei preferiti, sennò al login-->
                    <a
                    <?php
                        
                        if(isset($user_id)){
                            echo "href='favourites.php'";
                        }
                        else echo "href=# id='favourites_nologin'";
                    
                    ?>
                        >Preferiti</a>                        
                    </div>

                    <?php

                        //Se settata la sessione invece del login dobbiamo avere il pulsante per l'account
                        if(isset($user_id)){
                            echo '<a id = "welcome" href = "account.php" >';
                                echo "<h2 id = welcome_text>";
                                    echo "Benvenuto, ";
                                    echo $user_id;
                                echo "</h2>";
                                echo "<div id = image_container>";
                                    echo "<img id = 'propic' ";
                                        echo "src='".$Profile_pic."'>";
                                echo "</div>";
                            echo '</a>';

                            echo "<a href= 'logout.php?location=home.php' id = 'logout'>";
                                echo "Logout" ;
                            echo "</a>";
                        }
                        else{
                            echo "<a id='login_icon' href=#>" ;
                                echo "Login"; 
                            echo "</a>";
                        }

                    ?>    

                    <!--Nav button per mobile-->
                <a id = 'nav_icon_box' href=#>
                    <img src='assets/nav_icon.png' class = 'not_zoom'>
                </a>

                
            </nav>
        </header>


        <!--Nav Mobile-->
        <div id='nav_bar' class = 'hidden'>
            <div id= 'nav_box'>
                <a id = 'anime_button' href = # class='nav_row'>Anime</a>
                <a id = 'cinema_button' href = # class='nav_row'>Cinema</a>
                <a id = 'tv_button' href = # class='nav_row'>Tv</a>
                <a id = 'videogames_button' href = # class='nav_row'>Videogiochi</a>
                <a href='search.php' id = 'search_button' class= 'nav_row'>Ricerca Personalizzata</a>

                <?php

                    if(isset($user_id)){
                        echo "<a id = 'welcome_mobile' href = 'account.php' class='nav_row'>Benvenuto, ";
                                echo $user_id;
                            echo "</a>";
                        echo "<a href='favourites.php' class='nav_row'>Preferiti</a>";
                        echo "<a id = 'logout_mobile' href = 'logout.php?location=home.php' class='nav_row'>Logout</a>";
                        echo "<a href = 'account.php' id = image_container_nav>";
                                    echo "<img id = 'propic' ";
                                        echo "src='".$Profile_pic."'>";
                                echo "</a>";
                    }
                    else{
                        echo "<a id = 'login_icon_mobile' href = # class='nav_row'>Login/Registrati</a>" ;
                    }

                ?>

            </div>
        </div>

        <section id="main_news_space">
            <a id="main_news" href='#'>
                <img class="not_zoom" src="assets/loading.jpeg" >
                <div id="main_news_title">
                    <h3></h3>   
                </div>
            </a>
        </section>


        <section id="top_news_space">
            <div id="news_selection">
                <a class="news" href='#'>
                    <img class="zoom" src="assets/loading.jpeg">
                    <div class ="title_news_selection"> 
                        <h3 class="caption"></h3>
                    </div>
                </a>
                <a class="news" href='#'>
                    <img class="zoom" src="assets/loading.jpeg">
                    <div class ="title_news_selection">
                        <h3 class="caption"></h3>
                    </div>
                </a>
                <a class="news" href='#'>
                    <img class = "zoom" src="assets/loading.jpeg">
                    <div class ="title_news_selection"> 
                        <h3 class="caption"></h3>
                    </div>
                </a>
                <a class="news" href='#'>
                    <img class = "zoom" src="assets/loading.jpeg">
                    <div class ="title_news_selection"> 
                        <h3 class="caption"></h3>
                    </div>
                </a>
            </div>
        </section>


        <section id="small_news_space">
            <h2 id="fresh_section_title">Ultime Notizie</h2>
            <div id="small_news_section">
                <a class="small_news" href='article.php?id=5'>
                    <div class="small_news_image">
                        <img class= "zoom" src="assets/loading.jpeg">
                    </div>
                    <div class="small_news_title">
                        <h4></h4>   
                    </div>
                    
                </a>
                <a class="small_news" href='#'>
                    <div class="small_news_image">
                        <img class= "zoom" src="assets/loading.jpeg">
                    </div>
                    <div class="small_news_title">
                        <h4></h4>
                    </div>
                </a>   
                <a class="small_news" href='#'>
                    <div class="small_news_image">
                        <img class= "zoom" src="assets/loading.jpeg">
                    </div>
                    <div class="small_news_title">
                        <h4></h4>
                    </div>
                </a>
                <a class="small_news" href='#'>
                    <div class="small_news_image">
                        <img class= "zoom" src="assets/loading.jpeg">
                    </div>
                    <div class="small_news_title">
                        <h4></h4>
                    </div>
                </a>
            </div>


            <h2 id="hot_section_title">In Evidenza</h2>
            <div id="hot_news_section">
                <a class="small_news" href='#'>
                    <div class="small_news_image">
                        <img class= "zoom" src="assets/loading.jpeg">
                    </div>
                    <div class="small_news_title">
                        <h4></h4>
                    </div>
                <a class="small_news" href='#'>
                    <div class="small_news_image">
                        <img class= "zoom" src="assets/loading.jpeg">
                    </div>
                    <div class="small_news_title">
                        <h4></h4>
                    </div>
                </a>  
                <a class="small_news" href='#'>
                    <div class="small_news_image">
                        <img class= "zoom" src="assets/loading.jpeg">
                    </div>
                    <div class="small_news_title">
                        <h4></h4>
                    </div>
                </a>
                <a class="small_news" href='#'>
                    <div class="small_news_image">
                        <img class= "zoom" src="assets/loading.jpeg">
                    </div>
                    <div class="small_news_title">
                        <h4></h4>
                    </div>
                </a>    
            </div>

        </section>

        <footer id="bottom">
            <h4 id="bottom_text">Giampaolo Conti 1000014446  Web-Programming 2022/23</h4>
        </footer>

    </body>
</html>
