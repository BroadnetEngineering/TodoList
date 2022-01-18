<?php

class TodoListModel extends AbstractModel {

    /**
     * Add item to list
     * 
     * @param string $todo
     * 
     * @return int
     */
    public function add (string $todo) : int {
        return $this->insert(["todo" => $todo]);
    }

    /**
     * Update item on list
     * 
     * @param int $id
     * @param string $todo
     * 
     * @return void
     */
    public function updateItem (int $id, string $todo) {
        $this->update(
            $pairs = ["todo" => $todo],
            $where = [["id","=",$id]]
        );
    }

    /**
     * Complete item on list
     * 
     * @param int $id
     * 
     * @return void
     */
    public function complete (int $id) {
        $this->update(
            $pairs = ["completed" => 1],
            $where = [["id","=",$id]]
        );
    }

    /**
     * Uncomplete item on list
     * 
     * @param int $id
     * 
     * @return void
     */
    public function unComplete (int $id) {
        $this->update(
            $pairs = ["completed" => 0],
            $where = [["id","=",$id]]
        );
    }

    /**
     * Delete item on list
     * 
     * @param int $id
     * 
     * @return void
     */
    public function deleteItem (int $id) {
        $this->delete(
            $where = [["id","=",$id]]
        );
    }

    /**
     * Fetch the list of items
     * 
     * @return array
     */
    public function fetch () : array {
        return $this->select(["id","completed","todo"]);
    }

}