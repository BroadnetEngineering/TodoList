<?php

$servername = "localhost";
$database = "todo-crud";
$username = "root";
$password = "";

session_start();

$conn = mysqli_connect($servername, $username, $password, $database);

$todo = "";
$update = false;
$id = 0;

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST["save"])) {
    $todo = $_POST["todo"];
    $date = date('F\ dS, Y');
    $sql = "INSERT INTO data (todo, date) VALUES('$todo', '$date')";
    $conn->query($sql) or die($conn->error);

    $_SESSION["message"] = "Todo task has been added!";
    $_SESSION["msg_type"] =  "success";

    header("location: index.php");
}

if (isset($_GET["delete"])) {
    $id = $_GET["delete"];
    $sql = "DELETE FROM data WHERE id=$id";
    $conn->query($sql) or die($conn->error);

    $_SESSION["message"] = "Todo task has been deleted!";
    $_SESSION["msg_type"] =  "danger";

    header("location: index.php");
}

if (isset($_GET["edit"])) {
    $id = $_GET["edit"];
    $update = true;
    $sql = "SELECT * FROM data WHERE id=$id";
    $result = $conn->query($sql) or die($conn->error);
    if ($result) {
        $row = $result->fetch_array();
        $todo = $row["todo"];
    }
}

if (isset($_POST["update"])) {
    $id = $_POST["id"];
    $todo = $_POST["todo"]; 
    $sql = "UPDATE data SET todo='$todo' WHERE id=$id";
    $conn->query($sql) or die($conn->error);

    $_SESSION["message"] = "Todo task has been updated!";
    $_SESSION["msg_type"] = "warning";

    header("location: index.php");
}

mysqli_close($conn);
