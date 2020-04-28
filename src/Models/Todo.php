<?php
declare(strict_types = 1);

class Task {
    public int $id;
    public string $text;
    public bool $completed;

    public function __construct(string $text, bool $completed, ?int $id = null){
        $this->text = $text;
        $this->completed = $completed;
        $this->id = $id ? $id : random_int(1,9000);
    }

    public function setCompleted(bool $completed){
        $this->completed = $completed;
    }
}

class TodoList implements \Countable, \JsonSerializable {
    public array $tasks = [];
    
    public function __construct(array $tasks = []){
        $this->tasks = array_map(function($task){
            return new Task($task['text'], $task['completed'], $task['id']);
        }, $tasks);
    }
    public function add($task){
        if($id == null){
            $this->tasks[] = $task;
        }
    }
    public function get($id):Task {
        
        if(!$this->exists($id)){
            throw new Exception("Could not find Task");
        }
        return array_reduce($this->tasks, function($match, $task) use ($id) {
            if($match->id == $id){
                return $match;
            }
            if($task->id == $id){
                return $task;
            }
            
        });
    }
    public function remove($id){
        if(!$this->exists($id)){
            throw new Exception("Could not find Task");
        }
        $taskKey = array_search($id, array_column($this->tasks, 'id'));
        if(isset($taskKey)){
            unset($this->tasks[$taskKey]);
            $this->tasks = array_values($this->tasks);
            return true;
        }
    }
    protected function exists($id){
        $ret = array_reduce($this->tasks, function($match, &$task) use ($id){
                    if($match->id){
                        return $match;
                    }        
                    if($id == $task->id){
                        return $task;
                    }
                }); 
        return !empty($ret);
    }
    public function count(){
        return count($this->tasks);
    }
    public function jsonSerialize(){
        return $this->tasks;
    }
}