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

    if(!$connect){
        die("Ошибка: Не удалось подключиться к базе данных");
    }

    $title = "";
    $content = "";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $title = $_POST['title'];
        $content = $_POST['content'];
    }

    $query = "INSERT INTO public.documentation(title,content) VALUES($1, $2)";
    $params = array($title, $content);
    $res = pg_query_params($connect, $query, $params);
    
    if ($res) {
        $response = array("success" => true);
    } else {
        $response = array("success" => false);
    }

    $error = pg_last_error($connect);
    if($error){
        $response["error"] = "Ошибка: " . $error;
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    pg_close($connect);
?>
