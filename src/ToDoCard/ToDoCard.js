import React, { useState } from 'react';
import { MyContext } from '../Context';
import './ToDoCard.css';

function ToDoCard({ id, title, taskItems }) {
  const [checkedInputs, updateChecked] = useState({id: id, checkedInputs: []});

  function isChecked(item) {
    if (checkedInputs.checkedInputs.find(input => input === item)) {
      return true;
    } else {
      return false;
    }
  }

  function toggleChecked(item, updateState) {
    let updatedItems;

    if (checkedInputs.checkedInputs.find(input => input === item)) {
      updatedItems = checkedInputs.checkedInputs.filter(input => input !== item);
    } else {
      updatedItems = [...checkedInputs.checkedInputs, item];
    }

    item.checked = !item.checked;

    const updatedInputs = {
      id: id,
      checkedInputs: updatedItems,
    }

    updateChecked(updatedInputs);
    updateState({id: id, items: taskItems})
  }

  function renderTaskItems(taskItems, updateState) {
    return taskItems.map(item => (
      <div className="list-row" key={item.id}>
        <input
          type="checkbox"
          defaultChecked={item.checked}
          onClick={() => toggleChecked(item, updateState)}
        />
        <li>{item.text}</li>
      </div>
    ))
  }

  return (
    <MyContext.Consumer>
      {context => (
        <article className="todo-card">
          <div className="card-top">
            <p className="card-title">{ title }</p>
            <button onClick={() => context.deleteCard(id)}>x</button>
          </div>
          <div className="card-list-items">
            <ul>
              {renderTaskItems(taskItems, context.updateListItems)}
            </ul>
          </div>
        </article>
      )}
    </MyContext.Consumer>
  );
}

export default ToDoCard;
