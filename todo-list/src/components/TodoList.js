import React from "react";
import TodoTask from "./TodoTask";

function TodoList({ todos }) {
    return (
        <ul>
            {todos.map(todo => (
                <TodoTask
                    key={ todo.id }
                    todo={ todo }
                />
            ))}
        </ul>
    )
}

export default TodoList;