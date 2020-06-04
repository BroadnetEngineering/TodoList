import React from "react";
import { List } from '@material-ui/core';
import TodoTask from "./TodoTask";

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