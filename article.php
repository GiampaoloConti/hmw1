<?php

    //login e registrazione devono essere disponibili anche qui
    require_once 'dbconfig.php';
    include 'login.php';
    session_start();
    if(!isset($_SESSION["nome_utente"])) session_destroy();
    else $user_id = $_SESSION["nome_utente"];

    //se non è settato url torniamo alla home
    if(!isset($_GET["url"])){
        echo("Errore nel carimento dell'articolo");
        header("Location: home.php");
    }

    //url per location
    $urldata = 'article.php?url='.$_GET["url"];

    $error = checkData($urldata);

    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    

    if(isset($user_id)){
        $username = mysqli_real_escape_string($conn, $user_id);
        $query = "SELECT ProfilePic FROM TabellaRegistrazione WHERE Nome_utente = '".$username."'";
        $res = mysqli_query($conn, $query);
        $row = mysqli_fetch_row($res);
        $Profile_pic = $row[0];
    }

    $url = trim(mysqli_real_escape_string($conn, $_GET["url"]));

    if(isset($_GET['q']) && isset($user_id)){

        //verifichiamo se l'articolo è tra i preferiti dell'utente, in caso lo carichiamo da lì(potrebbe non essere più
        //disponibile in contenuti)
        $username = mysqli_real_escape_string($conn, $user_id);
        $query = "SELECT * FROM Preferiti WHERE UserID = '$username' AND Link = '$url'";
        $res = mysqli_query($conn, $query) or die(mysqli_error($conn));

    }

    else{

        //sennò carichiamo da contenuti
    $query = "SELECT * FROM Contenuti WHERE Link = '$url'";
    $res = mysqli_query($conn, $query) or die(mysqli_error($conn));


    }

    
    if (mysqli_num_rows($res) > 0) {
        // Ritorna una sola riga, il che ci basta perché il link è univoco
        $entry = mysqli_fetch_assoc($res);

        $title = $entry["Titolo"];
        $content = $entry["Contenuto"];
        $author = $entry["Autore"];
        $image = $entry["Immagine"];
        $link = $entry["Link"];

        

    } else{
        echo($query);
        exit;
    }

    if(isset($user_id)){
    $query = "SELECT * FROM Preferiti WHERE UserID = '$username' AND Link = '$url'";
        $res = mysqli_query($conn, $query) or die(mysqli_error($conn));

        if (mysqli_num_rows($res) > 0) {
            $favourites = true;
        }

    }

    mysqli_close($conn);

    
?>

<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>GeekInf - 
            <?php
                echo $title;
            ?>
        </title>
        <link rel="stylesheet" href="home.css">
        <link rel="stylesheet" href="article.css">
        <script src="home.js" defer></script>
        <script src="signup.js" defer></script>
        <script src="login.js" defer></script>
        <script src="favourites.js" defer></script>
        <script src="comments.js" defer></script>
    </head>

    <body>
        <div id="overlay"
        <?php           
            if(!isset($error))
                echo "class = 'hidden'";
        ?>
        >
            <div class = 'login_popup'
            <?php           
                if(!isset($error))
                    echo "class = 'hidden'";
            ?>
             >
                <div id = 'login_box'>
                    <div id = 'login_message'>
                        <h2 id="login_text">Login</h2>
                    </div>
                    <form method="post" name = 'form_login' action="article.php?url=
                    <?php
                        echo $_GET["url"];
                    ?>
                    ">
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
                    <form id = 'form' method="post" enctype="multipart/form-data" name = 'form_register' action = "signup.php?location=
                    <?php
                        echo $urldata;
                    ?>
                    " autocomplete="off">
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
                            <label><input class="invio" type="submit"></label>
                    </div>

                    </div>  
                    </form>
                </div>
            </div>        
        </div>
        <header>
            <nav>
                <a id="logo" href="home.php">
                    <img class="not_zoom" src="https://i.ibb.co/km4zGgg/Screenshot-2023-05-07-alle-17-37-16.png">
                </a>
                <div id = 'links'>
                    <a href='search.php'>Ricerca Personalizzata</a>
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

                    if(isset($user_id)){
                        echo '<a id = "welcome" href = "account.php" >';
                            echo "<h2 id = welcome_text>";
                                echo "Benvenuto, ";
                                echo $user_id ;
                            echo "</h2>";
                            echo "<div id = image_container>";
                                echo "<img id = 'propic' ";
                                    echo "src='".$Profile_pic."'>";
                            echo "</div>";
                        echo '</a>';
                        
                        if(isset($_GET["q"])) echo "<a href= 'logout.php?location=home.php' id = 'logout'>";
                        else echo "<a href= 'logout.php?location=article.php?url=".$url."' id = 'logout'>";
                            echo "Logout" ;
                        echo "</a>";
                    }
                    else{
                        echo "<a id='login_icon' href=#>" ;
                            echo "Login"; 
                        echo "</a>";
                    }

                ?>

                <a id = 'nav_icon_box' href=#>
                    <img src='assets/nav_icon.png' class = 'not_zoom'>
                </a>

            </nav>
        </header>

        <div id='nav_bar' class = 'hidden'>
            <div id= 'nav_box'>
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

        <div id = 'first_space'>
            <img id = 'main_image' src = 
            <?php
            echo $image;
            ?>
            >
        </div>    

        <div id = 'title_box'>
            <h1 id = 'title'>
                <?php
                    echo $title;
                ?>  
            </h1>
            <div id='button_box'>
                <div id = 'author_box'>
                    <h2> Autore: </h2>
                    <h2 id = 'author_name'>
                        <?php
                            echo $author;
                        ?>
                    </h2>
                </div>   
                <a href='#' 
                
                <?php

                    if(isset($favourites)){
                        echo " class='favourites_button_selected'";
                    } 
                    else if(!isset($user_id)) echo "id = 'favourites_nologin_button'";
                    else echo "class='favourites_button'";
                ?>
                
                >
                <?php

                    if(isset($favourites)){
                        echo "Aggiunto ai Preferiti";
                    } else echo "Aggiungi ai Preferiti";
                ?>
                
            
                </a>
            </div>    
        </div>

        <div id='bottom_box'>
                <h2 id= 'text_box'>
                    <?php
                        echo $content;
                    ?>
                </h2>
                    <a href=
                    <?php                   
                        echo $link;
                    ?>
                    id='keep_reading'>Leggi l'articolo completo </a>
            </div>

        <div id='comment_container'>

            <div id = 'leave_comment'
            <?php
                if(!isset($user_id)) echo "class ='hidden'";
            ?>  
            >
                <div class='propic_box'>
                    <img src = '
                    <?php
                        if(isset($Profile_pic)) echo $Profile_pic;
                    ?>
                    ' class= 'propic_comment'>
                </div>
                <form id = 'form_comment' method="post" name = 'form_comment' autocomplete="off">
                    <label><input type="text" name="comment_text" id='text_comment' placeholder = 'Lascia un commento'></label>
                    <label><input type="text" name="url" class= 'hidden' value = '
                    <?php
                        if(isset($link)) echo $link;
                    ?>
                    '></label>
                    <label><input type="text" name="propic" class= 'hidden' value = '
                    <?php
                        if(isset($Profile_pic)) echo $Profile_pic;
                    ?>
                    '></label>
                    <label><input class="hidden" type="submit"></label>
                </form>
            </div>

            <div id='comment_box'>
            </div>
        </div>

        <div id="bottom">
            <h4 id="bottom_text">Giampaolo Conti 1000014446  Web-Programming 2022/23</h4>
        </div>
    </body>
</html>





