<?php
    header('Content-Type: application/json');

    require_once 'dbconfig.php';

    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);

    //svuotiamo la tabella
    $query = "DELETE from Contenuti";

            // Execute the query
    $res = mysqli_query($conn, $query);

    $api_key = '3e2c29e915ae432ba82eb454606833fc';

    //se è passato get q cerchiamo quello, sennò generico
    if (!empty($_GET["q"])) {
        $url = 'https://newsapi.org/v2/everything?domains=everyeye.it,multiplayer.it&q=' . $_GET["q"] . '&sortBy=publishedAt&language=it&apiKey=' . $api_key;
    } else {
        $url = 'https://newsapi.org/v2/everything?domains=everyeye.it,multiplayer.it&sortBy=publishedAt&language=it&apiKey=' . $api_key;
    }

    $ch = curl_init();

    $headers = array("User-Agent: myprogram");

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);

    curl_close($ch);

    $data = json_decode($result, true);

    $articles = $data['articles'];


    //Inseriamo nel database il json ritornato
    if (isset($data['status']) && $data['status'] === 'ok') {
        $articles = $data['articles'];

        foreach ($articles as $article) {
            $title = mysqli_real_escape_string($conn, $article['title']);
            $content = mysqli_real_escape_string($conn, $article['content']); // Access the 'content' field
            $author = mysqli_real_escape_string($conn, $article['author']);
            $image = mysqli_real_escape_string($conn, $article['urlToImage']);
            $link = mysqli_real_escape_string($conn, $article['url']);

            $query = "INSERT INTO Contenuti(Titolo, Contenuto, Autore, Immagine, Link) VALUES ('$title', '$content', '$author','$image', '$link')";

            $res = mysqli_query($conn, $query);
        }
    } else {
        echo "Error occurred while fetching news articles.";
    }

    mysqli_close($conn);

    //torniamo il json
    print_r(json_encode($result));
?>
