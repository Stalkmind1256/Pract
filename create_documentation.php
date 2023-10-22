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

$surname = isset($_POST['surname']) ? $_POST['surname'] : '';
$title = isset($_POST['title']) ? $_POST['title'] : '';
$resalt = isset($_POST['resalt']) ? $_POST['resalt'] : '';
$marks = isset($_POST['marks']) ? $_POST['marks'] : '';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $surname = $_POST['surname'];
  $title = $_POST['title'];
  $resalt = $_POST['resalt'];
  $marks = $_POST['marks'];

  // Подготовка и выполнение запроса вставки данных в таблицу Students
  $queryStudents = "INSERT INTO public.students(surname) VALUES ($1) RETURNING id";
  $resultStudents = pg_query_params($connect, $queryStudents, array($surname));

  if ($resultStudents) {
    $studentId = pg_fetch_result($resultStudents, 0, 0);

  


    // Подготовка и выполнение запроса вставки данных в таблицу Documentation с указанием foreign key
    $queryDocumentation = "INSERT INTO public.documentation(title, id_student, resalt, marks) VALUES ($1, $2, $3,$4)";
    $paramsDocumentation = array($title, $studentId, $resalt,$marks);
    $resultDocumentation = pg_query_params($connect, $queryDocumentation, $paramsDocumentation);

    if ($resultDocumentation) {
      $response = array("success" => true);
    } else {
      $response = array("success" => false);
    }
  } else {
    $response = array("success" => false);
  }

  // Получение ошибки по запросу
  $error = pg_last_error($connect);
  if ($error) {
    $response["error"] = "Ошибка: " . $error;
  }

  // Закрытие соединения с базой данных
  pg_close($connect);

  // Отправка ответа в формате JSON
  header('Content-Type: application/json');
  echo json_encode($response);
}
?>
