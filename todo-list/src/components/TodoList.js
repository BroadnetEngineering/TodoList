import React from "react";
import TodoTask from "./TodoTask";

function TodoList({ todos, toggleStatus, removeTodo }) {
    return (
        <ul>
            {todos.map(todo => (
                <TodoTask
                    key = { todo.id }
                    todo = { todo }
                    toggleStatus = { toggleStatus }
                    removeTodo = { removeTodo }
                />
            ))}
        </ul>
    );
}

export default TodoList;