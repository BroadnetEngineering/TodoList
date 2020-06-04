import React from "react";
import TodoTask from "./TodoTask";
import { List } from '@material-ui/core';


function TodoList({ todos, toggleComplete, removeTodo }) {
    return (
        <List>
            {todos.map(todo => (
                <TodoTask
                    key = { todo.id }
                    todo = { todo }
                    toggleComplete = { toggleComplete }
                    removeTodo = { removeTodo }
                />
            ))}
        </List>
    );
}

export default TodoList;