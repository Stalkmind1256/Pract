<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Страница с документацией</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
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

    $surnameFilter = isset($_POST['surname']) ? $_POST['surname'] : '';
    $dateFilter = isset($_POST['date']) ? $_POST['date'] : '';

    $query = "SELECT s.surname, d.title, d.resalt, d.marks, d.dated FROM students s INNER JOIN documentation d ON s.id = d.id_student WHERE 1=1";

    if (!empty($surnameFilter)) {
        $query .= " AND s.surname = '$surnameFilter'";
    }

    if (!empty($dateFilter)) {
        $query .= " AND d.dated = '$dateFilter'";
    }

    $result = pg_query($connect, $query);

    if (!$result) {
        die("Error: Unable to retrieve documentation list");
    }

    $documentationList = pg_fetch_all($result);

    echo "<form method='post'>";
    echo "<input type='text' name='surname' placeholder='Введите фамилию'>";
    echo "<input type='date' name='date' placeholder='Выберите дату'>";
    echo "<input type='submit' value='Фильтровать'>";
    echo "</form>";

    echo "<div style='width: 100%'>";
    echo "<table class='table-width'>";
    echo "<colgroup>";
    echo "<col style='width: 20%;'>";
    echo "<col style='width: 20%;'>";
    echo "<col style='width: 20%;'>";
    echo "<col style='width: 20%;'>";
    echo "<col style='width: 20%;'>";
    echo "</colgroup>";
    echo "<tr>";
    echo "<th>Фамилия</th>";
    echo "<th>Тип работы</th>";
    echo "<th>Результат работы</th>";
    echo "<th>Оценка</th>";
    echo "<th>Дата</th>";
    echo "</tr>";

    foreach ($documentationList as $row) {
        echo "<tr>";
        echo "<td>" . $row['surname'] . "</td>";
        echo "<td>" . $row['title'] . "</td>";
        echo "<td>" . $row['resalt'] . "</td>";
        echo "<td>" . $row['marks'] . "</td>";
        echo "<td>" . $row['dated'] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
    echo "</div>";

    pg_close($connect);
?>
</body>
</html>