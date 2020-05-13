const titleInput = document.querySelector('.title-input')
const bodyInput = document.querySelector('.body-input')
const saveInput = document.querySelector('.save-button')
const toDoList = document.querySelector('.toDo-list')
const searchInput = document.querySelector('.search')
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
            <h2 contenteditable="true" id="title">${this.title}</h2>
            <button class="delete">X</button>
            <p contenteditable="true" id="body">${this.body}</p>
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

const getToDo = (selectedId) => {
    const selectedToDo = toDos.find(toDo => {
        return toDo.dateIdentifier == selectedId
    })
    return selectedToDo
}

const deleteToDo = (e) => {
    const idOfCard = e.target.parentNode.id 

    if (e.target.className === 'delete') {
        e.target.parentNode.remove()
        const toDoToDelete = getToDo(idOfCard)
        const toDoIndex = toDos.indexOf(toDoToDelete)
        toDos.splice(toDoIndex, 1)
        localStorage.setItem('toDos', JSON.stringify(toDos))
    }
}

const updateToDo = (e) => {
    const idOfCard = e.target.parentNode.id
    let cardToUpdate = getToDo(idOfCard)
    const toDoIndex = toDos.indexOf(cardToUpdate)

    if(e.target.id === "title") {
        cardToUpdate.title = e.target.innerHTML
    } else if (e.target.id === "body") {
        cardToUpdate.body = e.target.innerHTML
    }
    cardToUpdate.html = updateHTML(cardToUpdate)
    toDos.splice(toDoIndex, 1, cardToUpdate)
    localStorage.setItem('toDos', JSON.stringify(toDos))
}

const updateHTML = (toDo) => {
    return `
    <article class="toDo-card" id=${toDo.dateIdentifier}>
        <h2 contenteditable="true" id="title">${toDo.title}</h2>
        <button class="delete">delete</button>
        <p contenteditable="true" id="body">${toDo.body}</p>
    <article>`
}

const updateSearch = (e) => {

    const searchTerm = e.target.value.toLowerCase()
    let filteredToDos = toDos.filter(toDo => {
        return (toDo.title.toLowerCase().includes(searchTerm) || toDo.body.toLowerCase().includes(searchTerm))
    })
    if(searchTerm.length > 0) {
        toDoList.innerHTML = ""
        filteredToDos.forEach(toDo => {
            toDoList.innerHTML += toDo.html
        })
    } else {
        toDoList.innerHTML = ""
        toDos.forEach(toDo => {
            toDoList.innerHTML += toDo.html
        })
    }
}


saveInput.addEventListener('click', saveToDo)
toDoList.addEventListener('click', deleteToDo)
toDoList.addEventListener('keyup', updateToDo)
searchInput.addEventListener('keyup', updateSearch)