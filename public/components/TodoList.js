class TodoList extends React.Component {

    constructor (props) {
        super(props);
        this.state = { 
            data : [],
            notification : "Saved!"
        };
        this.updateTodoList = this.updateTodoList.bind(this);
        this.addTodoListItem = this.addTodoListItem.bind(this);
        this.deleteTodoListItem = this.deleteTodoListItem.bind(this);
        this.completeTodoListItem = this.completeTodoListItem.bind(this);
    }

    /* 
     * When the component is mounted, call the updateTodoList function
     * to fetch the current todo list from the database. This will also
     * make sure the todo list stays updated.
     */
    componentDidMount () {
        this.updateTodoList();
        setInterval(function () {
            this.updateTodoList();
        }.bind(this),10000);

        $("#todo-form").submit(function(e){
            e.preventDefault();
            this.addTodoListItem();
        }.bind(this));
    }

    /*
     * This sends the json '{"please":"FETCH"}' in the body of a POST request
     * to /api/todo/list. This will create an instance of TodoController and call
     * it's IndexAction() function. IndexAction() returns a javascript array
     * of the todo list
     */
    async updateTodoList () {
        try {
            const requestOptions = {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ please : 'FETCH' })
            };
            const res = await fetch("/api/todo/list", requestOptions);
            const data = await res.json();
            this.setState({ data : [] });
            this.setState({ data : data });
        } catch (e) {
            console.error(e);
        }
    }

    /*
     * This sends the json '{"please":"ADD"}' in the body of a POST request
     * to /api/todo/list. This will create an instance of TodoController and call
     * it's IndexAction() function. IndexAction() uses TodoListModel to add a
     * new todo list item
     */
    async addTodoListItem () {
        try {
            const requestOptions = {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ 
                    please : 'ADD',
                    todo : $("#todo-input").val()
                })
            };
            const res = await fetch("/api/todo/list", requestOptions);
            $("#todo-input").val("");
            this.updateTodoList();
        } catch (e) {
            console.error(e);
        }
    }

    /*
     * This sends the json '{"please":"UPDATE"}' in the body of a POST request
     * to /api/todo/list. This will create an instance of TodoController and call
     * it's IndexAction() function. IndexAction() uses TodoListModel to add a
     * new todo list item
     */
    async updateTodoListItem (id) {
        try {
            const requestOptions = {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ 
                    please : 'UPDATE',
                    id : id,
                    todo : $("#"+id.toString()+"-edit-item").val()
                })
            };
            const res = await fetch("/api/todo/list", requestOptions);
            $(".todo-notification").show();
            setTimeout(function(){
                $(".todo-notification").hide();
            },10000);
            this.updateTodoList();
        } catch (e) {
            console.error(e);
        }
    }

    /*
     * This sends the json '{"please":"DELETE"}' in the body of a POST request
     * to /api/todo/list. This will create an instance of TodoController and call
     * it's IndexAction() function. IndexAction() uses TodoListModel to delete
     * the todo list item
     */
    async deleteTodoListItem (id) {
        try {
            const requestOptions = {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ 
                    please : 'DELETE',
                    id : id
                })
            };
            const res = await fetch("/api/todo/list", requestOptions);
            this.updateTodoList();
        } catch (e) {
            console.error(e);
        }
    }

    /*
     * This sends the json '{"please":"COMPLETE"}' in the body of a POST request
     * to /api/todo/list. This will create an instance of TodoController and call
     * it's IndexAction() function. IndexAction() uses TodoListModel to complete
     * the todo list item
     */
    async completeTodoListItem (id) {
        try {
            const requestOptions = {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ 
                    please : 'COMPLETE',
                    id : id
                })
            };
            const res = await fetch("/api/todo/list", requestOptions);
            this.updateTodoList();
        } catch (e) {
            console.error(e);
        }
    }

    /*
     * This sends the json '{"please":"UNCOMPLETE"}' in the body of a POST request
     * to /api/todo/list. This will create an instance of TodoController and call
     * it's IndexAction() function. IndexAction() uses TodoListModel to set completed
     * to false for this todo list item
     */
    async unCompleteTodoListItem (id) {
        try {
            const requestOptions = {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ 
                    please : 'UNCOMPLETE',
                    id : id
                })
            };
            const res = await fetch("/api/todo/list", requestOptions);
            this.updateTodoList();
        } catch (e) {
            console.error(e);
        }
    }

    render () {
        return (
            <>
            <div className="todo-notification">
                <div className="close-notification" onClick={()=>$(".todo-notification").hide()}>
                    <i className="fas fa-window-close" />
                </div>
                {this.state.notification}
            </div>
            <div className="component-container">
                <div className="splash-container">
                    <div className="splash">
                        <h1 className="splash-head">Todo List</h1>
                        <div className="splash-subhead">
                            <form id="todo-form">
                                <table className="todo-table">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input placeholder="Add an item to your list" className="todo-input" type="text" id="todo-input" />
                                            </td>
                                            <td style={{paddingTop : "1px", width : "108px"}}>
                                                <a id="todo-button" onClick={()=>this.addTodoListItem()} className="todo-button pure-button pure-button-primary">
                                                    Submit
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>
                            <div className="markdown-body" style={{textAlign: "left"}}>
                                <div className="todo-list">
                                {this.state.data.map((todo) => (
                                    <div className="todo-item">
                                        <i onClick={()=>this.updateTodoListItem(todo.id,todo.id.toString()+"-edit-item")} className="todo-save fas fa-save" title="Save" />
                                        <i onClick={()=>this.deleteTodoListItem(todo.id)} className="todo-delete fas fa-trash-alt" title="Delete" />
                                        {(todo.completed == 1) ? (
                                            <i onClick={()=>this.unCompleteTodoListItem(todo.id)} className="todo-complete todo-complete-green fas fas fa-check-square" title="Uncheck" />
                                        ) : (
                                            <i onClick={()=>this.completeTodoListItem(todo.id)} className="todo-complete fas fa-square" title="Check" />
                                        )}
                                        <div className="div-edit-todo">
                                            <input id={todo.id.toString()+"-edit-item"} type="text" className="edit-todo" defaultValue={todo.todo} />
                                        </div>
                                    </div>
                                ))}
                                </div>
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>
            </>
        )
    }
}