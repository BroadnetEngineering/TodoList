<?php

require "connect.php";
require "todo.class.php";

$id = (int)$_GET['id'];

try{
	switch($_GET['action'])
	{
		case 'addTask':
			TodoListApp::addTask($_GET['text']);
			break;
		case 'deleteTask':
			TodoListApp::deleteTask($id);
			break;
		case 'updateTask':
			TodoListApp::updateTask($id,$_GET['text']);
			break;
	}

}
catch(Exception $e){
	echo $e->getMessage();
}

?>