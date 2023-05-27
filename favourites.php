<?php

require_once 'dbconfig.php';

    session_start();

    if(!isset($_SESSION["nome_utente"])){
        echo "Non dovresti essere qui";
        header("home.php");
        exit;
    }

    $user_id = $_SESSION["nome_utente"];

    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);

    $username = mysqli_real_escape_string($conn, $user_id);
    $query = "SELECT ProfilePic FROM TabellaRegistrazione WHERE Nome_utente = '".$username."'";
    $res = mysqli_query($conn, $query);
    $row = mysqli_fetch_row($res);
    $Profile_pic = $row[0];

    mysqli_close($conn);

?>

<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>GeekInf - Ricerca Personalizzata</title>
        <link rel="stylesheet" href="home.css">
        <link rel="stylesheet" href="search.css">
        <link rel="stylesheet" href="favourites.css">
        <script src="favourites_box.js" defer></script>
        <script src="home.js" defer></script>
    </head>

    <body>

    <header>
            <nav>
                <a id="logo" href="home.php">
                    <img class="not_zoom" src="https://i.ibb.co/km4zGgg/Screenshot-2023-05-07-alle-17-37-16.png">
                </a>
                <div id = 'links'>
                    <a href='search.php'>Ricerca Personalizzata</a>
                    <a href='favourites.php'>Preferiti</a>                  
                </div>

                <a id = "welcome" href = "account.php">
                    <h2 id = welcome_text>Benvenuto,

                    <?php echo $user_id; ?> 

                    </h2>

                    <div id = image_container>
                        <img id = 'propic' src=

                        <?php  echo $Profile_pic; ?> 

                        >
                    </div>
                </a>
                <a id = 'logout' href= 'logout.php?location=home.php'> Logout 

                </a>

                <a id = 'nav_icon_box' href=#>
                    <img src='assets/nav_icon.png' class = 'not_zoom'>
                </a>

            </nav>
        </header>

        <div id='nav_bar'>
            <div id= 'nav_box'>
                <a href='search.php' id = 'search_button' class= 'nav_row'>Ricerca Personalizzata</a>

                <?php
            
                        echo "<a id = 'welcome_mobile' href = 'account.php' class='nav_row'>Benvenuto, ";
                                echo $user_id;
                            echo "</a>";
                        echo "<a href='favourites.php' class='nav_row'>Preferiti</a>";
                        echo "<a id = 'logout_mobile' href = 'logout.php?location=home.php' class='nav_row'>Logout</a>";
                        echo "<div id = image_container_nav>";
                                    echo "<img id = 'propic' ";
                                        echo "src='".$Profile_pic."'>";
                                echo "</div>";
                ?>

            </div>
        </div>

        <div id=container>
            <div id = 'title_favourites_box'>
                <h1> I miei Preferiti </h1>
            </div>

            <div id = 'favourites_box'></div>
        </div>


        <div id="bottom">
            <h4 id="bottom_text">Giampaolo Conti 1000014446  Web-Programming 2022/23</h4>
        </div>


    </body>
</html>