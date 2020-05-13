import React from 'react';
import Form from '../Form/Form';
import MyProvider from '../Context';
import ToDoContainer from '../ToDoContainer/ToDoContainer';
import './App.css';

function App() {
  return (
    <MyProvider>
      <main className="App">
        <Form />
        <ToDoContainer />
      </main>
    </MyProvider>
  );
}

export default App;
