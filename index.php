<?php

require "connect.php";
require "todo.class.php";

	if(isset($_POST['submit'])){
		$task = $_POST['text'];
		$statement = $link->prepare('INSERT INTO `todo_table` (text)
		VALUES (:text)');
		$statement->execute([
			'text' => $text
		]);
		header('location: demo.php');
	}

	$stmt = $con->prepare("SELECT * from todo_table");
	$result = $stmt->execute();

	while($result=$stmt->fetch(PDO::FETCH_ASSOC)){
		$todos[] = new TodoListApp($result);
	} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="styles.css">
	<title>Todo List App</title>
</head>
<body>
<div id="main">
	<div class="app-title">Todo List App</div>
	<form method = "POST" action = "ajax.php">
        <input placeholder = "Enter item here..." type="text" id = "task" name="task" class="task-input">
        <button id="addButton" type="submit" class = "add-btn" name="submit">Add item</button>
    </form>
	<ul class="todoList">
        <?php
		/* Showing todo List items */
		foreach($todos as $todo){
			echo $todo;
		}
		?>
    </ul>
</div>
<script type="text/javascript" src="app.js"></script>	
</body>
</html>
