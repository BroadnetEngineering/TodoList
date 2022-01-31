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

        fetch('/api/list', requestBody)
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
            <div className='list-component-container-form'>
                <form onSubmit={this.handleForm}>
                    <div className='form-component-container'>
                        <div className='form-component'>
                            <div className='form-field'>
                                New list name:
                            </div>
                            <input type='text' name='name' value={this.state.name} onChange={this.handleChange}></input>
                        </div>
                        <div className='form-component'>
                            <div className='form-field'>
                                What's in your list?
                            </div>
                            <textarea className='form-textarea' rows='3' cols='30' name='description' value={this.state.description} onChange={this.handleChange}></textarea>
                        </div>
                        <div className='form-component'>
                            <div className='form-field'>
                                What is your list's current status?
                            </div>
                            <input type='text' name='status' placeholder='To Do' value={this.state.status} onChange={this.handleChange}></input>
                        </div>
                        <input className='create-form-button' type='submit' value='Create new List'></input>
                    </div>
                </form>
            </div>
        };
    }
}

if (document.getElementById('list-form')) {
    ReactDOM.render(<CreateForm />, document.getElementById('list-form'));
}
