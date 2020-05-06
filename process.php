<?php

$servername = "localhost";
$database = "todo-crud";
$username = "root";
$password = "";

$conn = mysqli_connect($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected successfully";

if (isset($_POST['save'])) {
    $todo = $_POST['todo'];

    $conn->query("INSERT INTO data (todo) VALUES('$todo')") or
        die($conn->error);
}

mysqli_close($conn);
