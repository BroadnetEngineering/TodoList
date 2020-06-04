import React from "react";
import { Checkbox, ListItem, IconButton, Typography } from '@material-ui/core';
import DeleteRoundedIcon from '@material-ui/icons/DeleteRounded';

function TodoTask({ todo, toggleComplete, removeTodo }) {
    
    function handleStatusClick() {
        toggleComplete(todo.id);
    }

    function handleRemoveClick() {
        removeTodo(todo.id);
    }

    return (
        <ListItem style={{ display: "flex" }}>
            <Checkbox
                defaultChecked
                color="primary"
                inputProps={{ 'aria-label': 'secondary checkbox' }}
                checked={ todo.completed }
                onClick={ handleStatusClick } 
            />
            <Typography
                variant="body1"
                style={{
                    textDecoration: todo.completed ? "line-through" : null
                }}
            >
                { todo.task }
            </Typography>
            <IconButton onClick={ handleRemoveClick } >
                <DeleteRoundedIcon />
            </IconButton>
        </ListItem>
    );
}

export default TodoTask;

