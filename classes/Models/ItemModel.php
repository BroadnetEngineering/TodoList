<?php
/**
 * Combined ViewModel for To-Do List Code Challenge for Broadnet
 *
 * @author Chris Pitchford
 * @date 2018-04-26
 * @version 1.0
 *
 * This file is the mapper for the To-Do datastore. It requires PDO, and both it
 * and Monolog are injected here.
 *
 *
 */

namespace Models;

/**
 * Class ItemModel
 *
 * @package Models
 */
class ItemModel
{
  private $_db;
  private $_logger;

  /**
   * ItemModel constructor.
   *
   * @param \PDO $db
   * @param \Monolog\Logger $logger
   */
  public function __construct(\PDO $db, \Monolog\Logger $logger) {
    $this->_db = $db;
    $this->_logger = $logger;
  }

  /**
   * @param $id
   *
   * @return bool|mixed
   */
  public function fetchOne($id) {
    return $this->_find(intval($id));
  }

  /**
   * @return array
   */
  public function fetchAll() {
    $res = $this->_db->query('SELECT * FROM `item`', \PDO::FETCH_ASSOC);
    $items = [];
    foreach ($res as $row) {
      $items[] = $row;
    }
//    $this->_logger->addInfo(print_r($items, TRUE));
    if ($items) {
      return $items;
    }
    else {
      return [];
    }
  }

  /**
   * @param $post
   *
   * @return array|bool|mixed
   */
  public function service($post) {
//    $this->_logger->addInfo(print_r($post, TRUE));
    $item = array();
    // Handle update/delete
    if (isset($post['order']) && $post['order'] != '') {
      $item = $this->_find(intval($post['order']));
      if ($item) {
        // If there's no trimmed title, then there's nothing to-do!
        if ($post['title'] == '') {
          $st = $this->_db->prepare("DELETE FROM item WHERE `order`= :order");
          $st->execute(array(':order' => intval($post['order'])));
        }
        else {
          $st = $this->_db->prepare(
            "UPDATE item SET
              `title` = :title,
              `completed` = :completed
              WHERE `order`= :order"
          );
          $st->execute(array(
            ':title' => $post['title'],
            ':completed' => ($post['completed'] ? 1 : 0),
            ':order' => intval($post['order']),
          ));
          $item = $this->_find(intval($post['order']));
        }
      }
      else {
        // Handle insert
        $st = $this->_db->prepare(
          "INSERT INTO item (`order`, `title`, `completed`)
            VALUES (:order, :title, :completed)"
        );
        $completed = ($post['completed'] == 1 ? 1 : 0);
        $st->execute(array(
          ':order' => intval($post['order']),
          ':title' => $post['title'],
          ':completed' => $completed
        ));
        $item = $this->_find(intval($post['order']));
      }
    }
      return $item;
  }

  /**
   * @param int $id
   *
   * @return bool|mixed
   */
  private function _find($id = 0) {
    if ($id == 0) return FALSE;
    $sql = 'SELECT * FROM `item` WHERE `order` = :order';
    $stmt = $this->_db->prepare($sql);
    $res = $stmt->execute(array(':order' => $id));
    return $stmt->fetch(\PDO::FETCH_ASSOC);
  }
}