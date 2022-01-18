<?php

class TodoController extends AbstractController {

    /**
     * Checks to make sure the request_method is POST. Then checks the
     * "please" value that was sent in the POST body and attempts to
     * take the corresponding actions. It sends JSON back to the front
     * 
     * @return void
     */
    public function ListAction () {
        if ($this->isPOST()) {
            if ($this->postBody["please"] == "ADD") {

                (new TodoListModel)->add($this->postBody["todo"]);

            } elseif ($this->postBody["please"] == "UPDATE") {

                (new TodoListModel)->updateItem($this->postBody["id"],$this->postBody["todo"]);

            } elseif ($this->postBody["please"] == "COMPLETE") {

                (new TodoListModel)->complete($this->postBody["id"]);

            } elseif ($this->postBody["please"] == "UNCOMPLETE") {

                (new TodoListModel)->unComplete($this->postBody["id"]);

            } elseif ($this->postBody["please"] == "DELETE") {

                (new TodoListModel)->deleteItem($this->postBody["id"]);

            } elseif ($this->postBody["please"] == "FETCH") {

                $this->jsonView((new TodoListModel)->fetch());
                
            }
        }
    }

}