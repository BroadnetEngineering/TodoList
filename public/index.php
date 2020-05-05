<?php
// This file plays the role of the controller
// Due to the time limitation MVC design is very simple
// and controller has some logic which it should not have normally
// I didn't implement any error handling logic due to the narrow scope of this project

require_once '../Core/Bootstrap.php';
require_once '../Models/ToDo.php';

$toDoModel = new ToDo($db);

if(isset($_REQUEST['action'])) {
    switch ($_REQUEST['action']) {
        case 'add_new':
            $toDoModel->save($_REQUEST);
            break;

        case 'update':
            // API request hence we want to stop the rest of
            // the application from executing, hence the die statement
            $toDoModel->update($_REQUEST); die;
            break;

        case 'delete':
            $toDoModel->delete($_REQUEST['id']); die;
            break;

        case 'checked':
            $toDoModel->update($_REQUEST); die;
            break;
    }
}

$toDos = $toDoModel->getList();

require '../Templates/home.phtml';