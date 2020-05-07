<?php
require(__DIR__.'/Models/Todo.php');
// Use session to store the todos 
session_start();

// initialize the requested todo list
$todoList = null;

if(isset($_SESSION['tasks']) && $_SESSION['tasks'] != null){
    $todoList = new TodoList(json_decode($_SESSION['tasks'], true) ?? []);
}else{
    $todoList = new TodoList();
    $_SESSION['tasks'] = json_encode($todoList);
}
// get action so we know what to do, these really only do anything with ajax requests.
$action = $_GET['action'] ?? 'view';

// Application/Json header doesn't get picked up by $_POST, so this is how we get this data. have to do this with any non standard Content-Type Headers like application/csp-report.
if (empty($_POST)) {
    $_POST = json_decode(file_get_contents("php://input"), true) ? : [];
}

// execute the action specified. 
switch($action){
    case 'add':
        try{
            $taskData = validateNewTodoData($_POST);
            $todoList->add(new Task($taskData['taskText'],false));
            saveTasks($todoList);
            respondWithTasks();
        }catch(Exception $exception){
            respondWithUnprocessableDataErrorAndMessage($exception);
        }        
        break;
    case 'update':
        try{
            $taskData = validateUpdateTodoData($_POST);            
            $task = & $todoList->get($taskData['id']);
            $task->text = $taskData['text'];
            $task->completed = $taskData['completed'] ? true : false;
            saveTasks($todoList);
            respondWithTasks();
        }catch(Exception $exception){
            respondWithUnprocessableDataErrorAndMessage($exception);
        }
        exit();
        break;
    case 'remove':
        try{
            $taskData = validateRemoveTodoData($_POST);
            $todoList->remove($taskData['id']);

            saveTasks($todoList);
            respondWithTasks();            
        }catch(Exception $exception){
            respondWithUnprocessableDataErrorAndMessage($exception);
        }
        break;
    case 'complete':
        try { 
            $taskData = validateCompleteTodoData($_POST);
            $task = & $todoList->get($taskData['id']);
            $task->setCompleted($taskData['completed'] ? true : false);
            
            saveTasks($todoList);
            respondWithTasks();
        }catch(Exception $exception){
            respondWithUnprocessableDataErrorAndMessage($exception);
        }
        break;
    case 'destroy':
        session_destroy();
        session_start();
        respondWithTasks();
    default:
        break;
}
function respondWithUnprocessableDataErrorAndMessage(Exception $exception){
    http_response_code(422);
    echo json_encode([
        'error'=> $exception->getMessage()
    ]);
    exit();
}
function saveTasks(&$list){
    $_SESSION['tasks'] = json_encode($list);
}
function respondWithTasks(){
    echo $_SESSION['tasks'] ? : json_encode([]);
    exit();
}
function validateNewTodoData($data){
    $filterArgs = [
        'taskText' => FILTER_SANITIZE_STRING
    ];
    $taskData = filter_var_array(array_filter($data), $filterArgs);

    if(empty($taskData['taskText'])){
        throw new Exception("Text Cannot be Empty");
    }

    return $taskData;
}
function validateUpdateTodoData($data){
    $filterArgs = [
        'id' => FILTER_VALIDATE_INT,
        'text' => FILTER_SANITIZE_STRING,
        'completed' =>[
            'filter' => FILTER_VALIDATE_BOOLEAN,
            'flags' => FILTER_NULL_ON_FAILURE
        ]
    ];
    $taskData = filter_var_array(array_filter($data), $filterArgs);

    if(empty($taskData['text'])){
        throw new Exception("Text Cannot be Empty");
    }
    return $taskData;
}
function validateCompleteTodoData($data){
    $filterArgs = [
        'id' => FILTER_VALIDATE_INT,
        'completed' =>[
            'filter' => FILTER_VALIDATE_BOOLEAN,
            'flags' => FILTER_NULL_ON_FAILURE
        ]
    ];

    $taskData = filter_var_array(array_filter($data), $filterArgs);

    return $taskData;
}
function validateRemoveTodoData($data){
    $filterArgs = [
        'id' => FILTER_VALIDATE_INT,
    ];
    $taskData = filter_var_array(array_filter($data), $filterArgs);
    return $taskData;
}
?>
