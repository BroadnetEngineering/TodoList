import { v4 as uuidv4 } from 'uuid';

export const data = [
  {
    id: uuidv4(),
    title: "Default Card",
    taskItems: [
      {id: uuidv4(), text: "Land this job!", checked: false},
      {id: uuidv4(), text: "eat sushi", checked: false}
    ]
  },
  {
    id: uuidv4(),
    title: "Today's Workout",
    taskItems: [
      {id: uuidv4(), text: "Bench Press 3x5", checked: false},
      {id: uuidv4(), text: "Overhead Lift 5x5", checked: false},
      {id: uuidv4(), text: "Squats 5x10", checked: false}
    ]
  },
  {
    id: uuidv4(),
    title: "Grocery List",
    taskItems: [
      {id: uuidv4(), text: "Bananas", checked: false},
      {id: uuidv4(), text: "Broccoli", checked: false},
      {id: uuidv4(), text: "Chicken", checked: false},
      {id: uuidv4(), text: "Bread", checked: false},
      {id: uuidv4(), text: "Milk", checked: false}
    ]
  },
  {
    id: uuidv4(),
    title: "Weekend to-dos",
    taskItems: [
      {id: uuidv4(), text: "Mow Lawn", checked: false},
      {id: uuidv4(), text: "Fix Sink", checked: false}
    ]
  },
  {
    id: uuidv4(),
    title: "Next Week",
    taskItems: [{id: uuidv4(), text: "Apply to Broadnet", checked: false}]
  },
  {
    id: uuidv4(),
    title: "Dev Tasks",
    taskItems: [
      {id: uuidv4(), text: "Bug fixes", checked: false},
      {id: uuidv4(), text: "New features", checked: false}
    ]
  },
]
