<?php
require_once 'connect.php';

class TodoListApp{
	
	private $data;
	
	/* The constructor */
	public function __construct($par) {
		if(is_array($par))
			$this->data = $par;
	}

	public function __toString(){
		
		return '
			<li id="todo-'.$this->data['id'].'" class="todo">
				<div class="text">'.$this->data['text'].'</div>
				<div class="actions">
					<a href="#" class="edit">Edit</a>
					<a href="#" class="delete">Delete</a>
				</div>
			</li>';
	}
	/*
		This method will execute updates in database.
	*/
	public static function updateTask($id, $text){
		global $con;
		$text = self::filterThis($text);
		$data = [
			'id' => $id,
			'text' => $text,
		];

		$sql = "UPDATE `todo_table` SET text=:text WHERE id=:id";
		$pdoExec = $con->prepare($sql)->execute($data);
		if($pdoExec){
			echo $text;
		}else{
			echo 'ERROR Updating task';
    	}
	}
	
	/*
		This method will delete records in database.
	*/
	public static function deleteTask($id){
		 
		global $con;
		$pdoQuery = "DELETE FROM `todo_table` WHERE `id` = :id";
		$pdoResult = $con->prepare($pdoQuery);
		$pdoExec = $pdoResult->execute(array(":id"=>$id));
		if($pdoExec)
		{
			echo 'todo-'.$id;
		}else{
			echo 'ERROR Data Not Deleted';
		}
	}
		
	/*
		This method will add a new record in database
	*/
	public static function addTask($text){
		global $con;
		$text = self::filterThis($text);
		$sql = "INSERT INTO `todo_table` (text) VALUES (?)";
		$con->prepare($sql)->execute([$text]);
		echo (new TodoListApp(array(
			'id'	=> $con->lastInsertId(),
			'text'	=> $text
		)));
		exit;
	}
	
	/*
	  Simple method to sanitize a string:
	*/
	public static function filterThis($string) {
		$safe = htmlspecialchars($string);
		return $safe;
	}
}

?>