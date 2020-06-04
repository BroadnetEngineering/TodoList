import React, { useState, useEffect } from 'react';
import './App.css';
import TodoForm from './components/TodoForm';
import TodoList from './components/TodoList';

const LOCAL_STORAGE_KEY = "todo-list-storage"

function App() {

  const [todos, setTodos] = useState([])

  useEffect(() => {
    const storageTodos =  JSON.parse(localStorage.getItem(LOCAL_STORAGE_KEY));
    if (storageTodos) {
      setTodos(storageTodos);
    }
  }, [])

  useEffect(() => {
    localStorage.setItem(LOCAL_STORAGE_KEY, JSON.stringify(todos));
  }, [todos]);

  function addTodo(todo) {
    setTodos([todo, ...todos]);
  }

  return (
    <div className="App">
      <header className="App-header">
        <p>Todo List</p>
        <TodoForm addTodo={ addTodo } />
        <TodoList todos={ todos } />
      </header>
    </div>
  );
}

export default App;
