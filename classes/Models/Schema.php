<?php
/**
 * Schema Install file for To-Do List Code Challenge for Broadnet
 *
 * @author Chris Pitchford
 * @date 2018-04-26
 * @version 1.0
 *
 * This file installs the schema for the To-Do datastore. It requires PDO, but to
 * use Monolog, the file needs to get the vendor directory from composer after
 * the download of dependent packages.
 *
 *
 */

namespace Models;

use Composer\Script\Event;

/**
 * Class Schema
 *
 * @package Models
 */
class Schema {

  /**
   * @param \Composer\Script\Event $event
   */
  static function postAutoloadDump(Event $event) {
    // Don't know the meaning of failure
    $fail = false;

    // Where are we, and how can we do anything?
    $vendorDir = $event->getComposer()->getConfig()->get('vendor-dir');

    // Get autoload and run...
    require_once $vendorDir . '/autoload.php';

    $logger = new \Monolog\Logger('my_logger');
    $file_handler = new \Monolog\Handler\StreamHandler('logs/install.log');
    $logger->pushHandler($file_handler);

    // Get credentials
    require_once $vendorDir . '/../config/local.php';

    $pdo = new \PDO('mysql:host=' . $host . ';dbname=' . $db, $user, $pass);
    $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);

    $st = $pdo->prepare('CREATE DATABASE IF NOT EXISTS `todos` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_bin;
USE `todos`;');
    try {
      $st->execute();
    }
    catch (\Exception $e) {
      $logger->addInfo($e->getMessage());
    }

    $st = $pdo->prepare('
DROP TABLE IF EXISTS `item`;
CREATE TABLE `item` (
  `order` tinyint(3) UNSIGNED NOT NULL,
  `title` text COLLATE utf8mb4_bin NOT NULL,
  `completed` tinyint(1) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;');
    try {
      $st->execute();
    }
    catch (\Exception $e) {
      $logger->addInfo($e->getMessage());
    }
  }
}