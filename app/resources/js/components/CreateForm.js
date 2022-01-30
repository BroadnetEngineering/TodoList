import React from 'react';
import ReactDOM from 'react-dom';
import ListTable from './ListTable';

/**
 * Create a new TodoList
 */
export default class CreateForm extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            redirect: false,
            name: '',
            description: '',
            status: '',
        }
    }

    /**
     * Create a new TodoList and redirect to main screen
     */
    insertList = () => {
        const requestData = {
            name: this.state.name,
            description: this.state.description,
            status: this.state.status
        }

        const requestBody = {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(requestData)
        }

        fetch(process.env.MIX_API_URL + '/api/list', requestBody)
            .then(() => {
                this.setState({
                    redirect: true
                })
            });
    }

    handleForm = (e) => {
        e.preventDefault();

        this.insertList();
    }

    handleChange = (e) => {
        this.setState({
            [e.target.name]: e.target.value
        });
    }
    
    render = () => {
        {return this.state.redirect ? <ListTable /> : 
            <div>
                <form onSubmit={this.handleForm}>
                    <label>
                        Describe your new List name:
                        <input type='text' name='name' value={this.state.name} onChange={this.handleChange}></input>
                    </label>
                    <label>
                        Describe your new List:
                        <input type='text' name='description' value={this.state.description} onChange={this.handleChange}></input>
                    </label>
                    <label>
                        What is your new List's current status?
                        <input type='text' name='status' placeholder='To Do' value={this.state.status} onChange={this.handleChange}></input>
                    </label>
                    <input type='submit' value='Create new List'></input>
                </form>
            </div>
        };
    }
}

if (document.getElementById('list-form')) {
    ReactDOM.render(<CreateForm />, document.getElementById('list-form'));
}
