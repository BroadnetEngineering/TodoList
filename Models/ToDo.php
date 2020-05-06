<?php
require_once 'AbstractModel.php';

class ToDo implements AbstractModel {
    private $db = null;

    public function __construct(\PDO $db) {
        $this->db = $db;
    }

    public function getList() {
        return $this->db->query('SELECT * FROM to_dos', PDO::FETCH_ASSOC)->fetchAll();
    }

    public function delete($id) {
        $sql = $this->db->prepare('DELETE FROM to_dos WHERE id = :id');
        $sql->bindValue(':id', $id); // Mitigating SQL injection

        $sql->execute();
    }

    public function update($params) {
        // Making updates a little more versatile since we are using this in more than one scenario
        $fieldsToUpdate = [];
        if(isset($params['to_do'])) $fieldsToUpdate[] = 'to_do = :to_do';
        if(isset($params['status'])) $fieldsToUpdate[] = 'status = :status';
        $fieldsToUpdateString = implode(',', $fieldsToUpdate);

        $sql = $this->db->prepare("UPDATE to_dos SET $fieldsToUpdateString WHERE id = :id");

        if(isset($params['status'])) $sql->bindParam(':status', $params['status']);
        if(isset($params['to_do'])) $sql->bindParam(':to_do', $params['to_do']);

        $sql->bindParam(':id', $params['id']);

        $sql->execute();
    }

    public function save($params) {
        $sql = $this->db->prepare("INSERT INTO to_dos(to_do, status) VALUES (:to_do, 'false')");
        $sql->bindParam(':to_do', $params['to_do']);

        $sql->execute();
    }
}