import React from 'react';
import { MyContext } from '../Context';
import ToDoCard from '../ToDoCard/ToDoCard';
import './ToDoContainer.css';

function ToDoContainer() {

  function displayCards(cards) {
    const columnA = [];
    const columnB = [];

    cards.forEach(card => {
      if (columnA.length > columnB.length) {
        columnB.unshift(card);
      } else {
        columnA.unshift(card);
      }
    })

    return (
      <>
        <div className="todo-container-left">
          {generateHTML(columnA)}
        </div>
        <div className="todo-container-right">
          {generateHTML(columnB)}
        </div>
      </>
    )
  }

  function generateHTML(cards) {
    return cards.map(card =>
      <ToDoCard
        key={card.id}
        id={card.id}
        title={card.title}
        taskItems={card.taskItems}
      />
    )
  }

  return (
    <MyContext.Consumer>
      {context => (
        <section className="todo-container">
          {displayCards(context.state.cards)}
        </section>
      )}
    </MyContext.Consumer>
  );
}

export default ToDoContainer;
