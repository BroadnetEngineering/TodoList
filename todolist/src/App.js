import React from 'react';
import Fab from '@material-ui/core/Fab';
import TextField from '@material-ui/core/TextField';
import AddIcon from '@material-ui/icons/Add';
import DeleteIcon from '@material-ui/icons/Delete';
import Grid from '@material-ui/core/Grid';
import './App.css';

class TodoList extends React.Component {
  constructor(props) {
    super(props)
    this.state = {
      todoList: [],
      currentInputValue: ''
    }
  }

  addTodoItem = () => {
    const { todoList, currentInputValue } = this.state;
    const newTodoList = [...todoList];
    newTodoList.push(currentInputValue);
    this.setState({
      todoList: newTodoList,
      currentInputValue: ''
    });
  }

  handleInputChange = (event) => {
    const { value } = event.target;
    this.setState({
      currentInputValue: value
    })
  }

  deleteTodo = idx => {
    const { todoList } = this.state;
    const deleteTodoList = [...todoList];
    deleteTodoList.splice(idx, 1);
    this.setState({
      todoList: deleteTodoList
    });
  }

  editTodoItem = (event, i) => {
    const { todoList } = this.state;
    const { value } = event.target;
    const editedTodoList = [...todoList];
    editedTodoList[i] = value;
    this.setState({
      todoList: editedTodoList
    });
  }

  render() {
    const { currentInputValue, todoList } = this.state;
    return (
      <section className="todo-container">
        <div className="todo-box">
          <h1 className="todo-header">Todo list</h1>
          <form className="todo-form" noVd alidate autoComplete="off">
            {todoList.map((todo, i) =>
              <Grid spacing={1} container className="input-grid" alignItems="flex-end">
                <Grid item className="input-grid-item">
                  <TextField
                    onChange={(event) => this.editTodoItem(event, i)}
                    value={todoList[i]}
                    className="todo-input"
                    id="input-with-icon-grid"
                    color="secondary"
                  >
                    {todo}
                  </TextField>
                </Grid>
                <Grid item>
                  <DeleteIcon
                    color="secondary"
                    onClick={() => this.deleteTodo(i)}
                  />
                </Grid>
              </Grid>)}
            <TextField
              variant="outlined"
              value={currentInputValue}
              onChange={(event) => this.handleInputChange(event)}
              className="todo-input"
              id="outlined-basic"
              label="Add a todo"
              color="secondary"
            />
          </form>
          <Fab color="secondary" className="add-icon" size="small" aria-label="add">
            <AddIcon onClick={(todo) => this.addTodoItem(todo)} />
          </Fab>
        </div>
      </section >
    );
  }
}

export default TodoList;