<?php

class TodoList{
    function PDOConnect(){
        try {
            //Normally I would pass in via environment variables but I was having touble setting up phpdotenv with my version of PHP. Kept getting composer errors
            $user = "root";
            $pass = "474109Dav.";
            $dbh = new PDO('mysql:host=127.0.0.1;dbname=TodoList', $user, $pass);
            return $dbh;
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    function Fetch(){
      try{
        $dbh = $this->PDOConnect();
        
        $sth = $dbh->prepare("SELECT * FROM tasks");
        $sth->execute();
        $results = $sth->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($results);
      } catch (PDOException $e) {
        echo "Error!: " . $e->getMessage() . "<br/>";
        die();
      }
    }

    function add($title,$description,$due){
        try{
        $dbh = $this->PDOConnect();

        $data = [
          'title' => $title,
          'description' => $description,
          'due' => $due
        ];
        $sth = $dbh->prepare("INSERT INTO tasks (title,description,status,created,updated,due) VALUES(:title, :description, 0, NOW(), NOW(), :due)");
        $sth->execute($data);
        echo "success";
      } catch (PDOException $e) {
        echo "Error!: " . $e->getMessage() . "<br/>";
        die();
      }
    }

    function delete($id){
        try{
          $dbh = $this->PDOConnect();

          $data = [
            'id' => $id
          ];
          $sth = $dbh->prepare("DELETE FROM tasks WHERE id=:id");
          $sth->execute($data);
          echo $id;
        } catch (PDOException $e) {
          echo "Error!: " . $e->getMessage() . "<br/>";
          die();
        }
    }

    function update($id,$updateStatus){
      try{
        $dbh = $this->PDOConnect();

        $data = [
          'status' => $updateStatus,
          'id' => $id
        ];
        $sth = $dbh->prepare("UPDATE tasks SET status=:status, updated=NOW() WHERE id=:id");
        $sth->execute($data);
        echo $id;
      } catch (PDOException $e) {
        echo "Error!: " . $e->getMessage() . "<br/>";
        die();
      }
    }
}

$TodoList = new TodoList();

$route = $_POST['route'];

//Determine the type of request and navigate to the applicable function. 
if($route === "fetch"){
    $TodoList->fetch();

}elseif($route === "update") {
    $id = $_POST['id'];
    $updateStatus = $_POST['updateStatus'];
    $TodoList->update($id,$updateStatus);

}elseif($route === "add"){
    $title = $_POST['title'];
    $description = $_POST['description'];
    $due = $_POST['due'];
    $TodoList->add($title,$description,$due);

}elseif($route === "delete") {
    $id = $_POST['id'];
    $TodoList->delete($id);

}else{
    echo ($route." is not a valid route.");
}