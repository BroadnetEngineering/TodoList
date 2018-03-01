<?php

// We are loosely modeling MVC, as opposed to strict.

// Display/Launch the app

if(isset($_REQUEST['action'])) {
    require_once 'controller/TodoList.php';
    exit;
}

require_once 'views/TodoList.html';