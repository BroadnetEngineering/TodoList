<?php
require "Config.php";
require "MySQL.php";

if($config['show_php_errors']) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

$MySQL = new MySQL($config);
$db = $MySQL->getPdo();
