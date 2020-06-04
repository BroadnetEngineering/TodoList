import React from "react";

function TodoTask({ todo, toggleStatus, removeTodo }) {
    
    function handleStatusClick() {
        toggleStatus(todo.id)
    }

    function handleRemoveClick() {
        removeTodo(todo.id)
    }

    return (
        <React.Fragment style={{ display: "flex" }}>
            <input 
                type="checkbox"
                onClick={ handleStatusClick } 
            />
            <li
                style={{
                    textDecoration: todo.completed ? "line-through" : null
                }}
            >
                { todo.task }
            </li>
            <button onClick={ handleRemoveClick }>Delete</button>
        </React.Fragment>
    )
}

export default TodoTask;