<?php

//load the database functions.
require_once 'helpers/database.inc.php';

// handle whichever action is being triggered
$action = $_REQUEST['action'];

switch ($action) {
    case 'getTasks' :
        break;

    case 'updateCompleted' :
        updateCompleted();
        break;

    case 'updateTask' :
        updateTask();
        break;

    case 'addItem' :
        addItem();
        break;

    case 'deleteItem' :
        deleteItem();
        break;

    default : ;

}
getTasks();


function updateCompleted() {
    // set the status of the todo item (completed or not)
    db_update('todos', array('completed' => $_REQUEST['checked']), array('id' => $_REQUEST['id']));
}

function updateTask() {
    // update the task's text
    db_update('todos', array('task' => $_REQUEST['task']), array('id' => $_REQUEST['id']));
}

function deleteItem() {
    // mark the todo item as deleted
    db_update('todos', array('deleted' => '1'), array('id' => $_REQUEST['id']));
}

function addItem() {
    // Add new todo item
    db_insert('todos', array('task' => $_REQUEST['task']));
}

function getTasks() {

    // retrieve the user's tasks from the database
    $tasks = db_select('todos', array( 'deleted' => 0 ), 'ORDER BY `completed` ASC');

    print json_encode(
        array(
            'status' => 200,
            'error' => '',
            'tasks' => $tasks
        )
    );

    exit;
}

//print_r($_REQUEST);