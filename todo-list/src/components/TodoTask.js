import React from "react";

function TodoTask({ todo }) {
    return (
        <React.Fragment style={{ display: "flex" }}>
            <input type="checkbox" />
            <li>{ todo.task }</li>
            <button>X</button>
        </React.Fragment>
    )
}

export default TodoTask;