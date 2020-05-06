<?php

$servername = "localhost";
$database = "todo-crud";
$username = "root";
$password = "";

session_start();

$conn = mysqli_connect($servername, $username, $password, $database);

$todo = '';
$update = false;

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// echo "Connected successfully";

if (isset($_POST['save'])) {
    $todo = $_POST['todo'];
    $conn->query("INSERT INTO data (todo) VALUES('$todo')") or die($conn->error);

    $_SESSION['message'] = "Todo task has been added!";
    $_SESSION['msg_type'] =  "success";

    header("location: index.php");
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM data WHERE id=$id") or die($conn->error);

    $_SESSION['message'] = "Todo task has been deleted!";
    $_SESSION['msg_type'] =  "danger";

    header("location: index.php");
}

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $update = true;
    $result = $conn->query("SELECT * FROM data WHERE id=$id") or die($conn->error);
    if ($result) {
        $row = $result->fetch_array();
        $todo = $row['todo'];
    }
}

mysqli_close($conn);
