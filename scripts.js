const titleInput = document.querySelector('.title-input')
const bodyInput = document.querySelector('.body-input')
const saveInput = document.querySelector('.save-button')
const toDoList = document.querySelector('.toDo-list')
let toDos = []

const populateToDos = () => {
    toDos.forEach(toDo => {
        toDoList.innerHTML += toDo.html
    })
}

if (localStorage.getItem('toDos')) {
    toDos = JSON.parse(localStorage.getItem('toDos'))
    populateToDos()
}

function ToDo (title, body) {
    this.title = title;
    this.body = body;
    this.dateIdentifier = Date.now()
    this.html = `
        <article class="toDo-card" id=${this.dateIdentifier}>
            <h2 contenteditable="true">${this.title}</h2>
            <button class="delete">delete</button>
            <p contenteditable="true">${this.body}</p>
        <article>`
}

const saveToDo = (e) => {
    e.preventDefault()
    const newToDo = new ToDo(titleInput.value, bodyInput.value)
    toDoList.innerHTML += newToDo.html
    titleInput.value = ('')
    bodyInput.value = ('')
    toDos.push(newToDo)
    localStorage.setItem('toDos', JSON.stringify(toDos))
}

const getToDo = (id) => {
    const selectedToDo = toDos.find(toDo => toDo.dateIdentifier === id)
    return selectedToDo
}

const deleteToDo = (e) => {
    const cardToDelete = e.target.parentNode.id 
    console.log(e.target.parentNode)
    console.log(cardToDelete)
    if (e.target.className === 'delete') {
        e.target.parentNode.remove()
        const toDoToDelete = getToDo(cardToDelete)
        toDos.splice(toDoToDelete.dateIdentifier, 1)
        localStorage.setItem('toDos', JSON.stringify(toDos))
    }
}



saveInput.addEventListener('click', saveToDo)
toDoList.addEventListener('click', deleteToDo)