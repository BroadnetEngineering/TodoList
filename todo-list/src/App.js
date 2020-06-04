import React from 'react';
import './App.css';
import TodoForm from './components/TodoForm';
import TodoList from './components/TodoList';

function App() {
  return (
    <div className="App">
      <header className="App-header">
        <p>Todo List</p>
        <TodoForm />
        <TodoList />
      </header>
    </div>
  );
}

export default App;
