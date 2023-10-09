<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $host = "localhost";
    $port = "5432";
    $dbname = "postgres";
    $user = "postgres";
    $password = "123456789";

    $connect = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

    if (!$connect) {
        die("Ошибка: Не удалось подключиться к базе данных");
    }

    // Retrieving the documentation list from the database
    $query = "SELECT title, content FROM documentation";
    $result = pg_query($connect, $query);

    if (!$result) {
        die("Error: Unable to retrieve documentation list");
    }

    $documentationList = pg_fetch_all($result);

    // Displaying the documentation list
    foreach ($documentationList as $document) {
        echo "<div class='card my-2'>";
        echo "<div class='card-body'>";
        echo "<h5 class='card-title'>" . $document['title'] . "</h5>"; 
        echo "<p class='card-text'>" . $document['content'] . "</p>";
        echo "</div>";
        echo "</div>";
    }

    // Closing the database connection
    pg_close($connect);
?>