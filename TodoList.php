<?php

$TodoList = new TodoList();

$submit_type = $_POST['submit_type'];

//Determine the type of request and navigate to the applicable function. 
if($submit_type === "fetch"){
    $TodoList->FetchTable();

}elseif($submit_type === "add"){
    $task = $_POST['task_desc'];
    $TodoList->AddItem($task);

}elseif($submit_type === "delete") {
    $task_id = $_POST['task_id'];
    $TodoList->DeleteItem($task_id);

}elseif($submit_type === "edit") {
    $task_id = $_POST['task_id'];
    $task = $_POST['task_desc'];
    $TodoList->EditItem($task_id, $task);

}else{
    echo ("An error has occurred. '".$submit_type."' does not match a proper submit type.");
}

class TodoList{
    function DBConnect(){
        $mysqli = new mysqli("127.0.0.1", "root", "password", "TodoDB");
        if ($mysqli -> connect_errno) {
            echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
            exit();
        }
        return $mysqli;
    }

    function FetchTable(){
        $i=0;
        $return = [];

        $todo_db = $this->DBConnect();
        
        $query = "SELECT * FROM TodoDB.TodoList";
        $result = $todo_db->query($query);
        
        if ($result->num_rows > 0) {
            
            while($row = mysqli_fetch_assoc($result)) {
                $return[$i]["task_id"] = $row["Task_ID"];
                $return[$i]["task_desc"] = $row["Task_Desc"];
                $i++;
            }
            $todo_db->close();
            echo json_encode($return);
        }
    }

    function AddItem($task){
        $return = [];
        $return["task_desc"] = $task;

        $todo_db = $this->DBConnect();
        
        $query = "INSERT INTO TodoDB.TodoList (Task_Desc) VALUES ('".$task."')";
        if ($result = $todo_db -> query($query) === TRUE){
            $return["task_id"] = $todo_db->insert_id;

        }else{
            $todo_db->close();
            echo "Error: " . $query . "<br>" . $todo_db->error;
        }

        $todo_db->close();
        echo json_encode($return);
    }

    function DeleteItem($task_id){
        $return = [];
        $return["task_id"] = $task_id;

        $todo_db = $this->DBConnect();

        $query = "DELETE FROM TodoDB.TodoList WHERE Task_ID=".$task_id;
        if ($result = $todo_db -> query($query) === TRUE){
            $todo_db->close();
            echo json_encode($return);

        }else{
            $todo_db->close();
            echo "Error: " . $query . "<br>" . $todo_db->error;
        }
    }

    function EditItem($task_id, $task){
        $return = [];
        $return["task_desc"] = $task;
        $return["task_id"] = $task_id;

        $todo_db = $this->DBConnect();
        $query = "UPDATE TodoDB.TodoList SET Task_Desc='".$task."' WHERE Task_ID=".$task_id;
        if ($result = $todo_db -> query($query) === TRUE){
            $todo_db->close();
            echo json_encode($return);

        }else{
            $todo_db->close();
            echo "Error: " . $query . "<br>" . $todo_db->error;
        }
    }
}
