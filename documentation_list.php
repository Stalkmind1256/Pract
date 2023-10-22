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
    $query = "SELECT s.surname, d.title, d.resalt, d.marks FROM students s INNER JOIN documentation d ON s.id = d.id_student";
    $result = pg_query($connect, $query);

    if (!$result) {
        die("Error: Unable to retrieve documentation list");
    }

    $documentationList = pg_fetch_all($result);

    $error = pg_last_error($connect);
    if ($error) {
        die("Ошибка при выполнении запроса: " . $error);
    }


    // Displaying the documentation list
    foreach ($documentationList as $row) {
        echo "<div class='card my-2'>";
        echo "<div class='card-body'>";
        echo "<h5 class='card-title'>" . $row['surname'] . "</h5>";
        echo "<p class='card-text'>" . $row['title'] . "</p>";
        echo "<p class='card-text'>" . $row['resalt'] . "</p>";
        echo "<p class='card-number'>" . $row['marks'] . "</p>";    
        echo "</div>";
        echo "</div>";
    }

    // Closing the database connection
    pg_close($connect);
?>
