import React from 'react';
import List from './List';

/**
 * Update an existing TodoList
 */
export default class UpdateForm extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            redirect: false,
            id: props.id,
            name: props.name,
            description: props.description ? props.description : '',
            status: props.status ? props.status : '',
            originalName: ''
        }
    }

    componentDidMount = () => {
        this.setState({
            originalName: this.state.name,
        })
    }

    /**
     * Update an existing TodoList and replace form component with
     * rerender of the updated TodoList
     */
    updateList = () => {
        const requestData = {
            id: this.state.id,
            name: this.state.name,
            description: this.state.description,
            status: this.state.status
        }

        const requestBody = {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(requestData)
        }

        fetch(process.env.MIX_API_URL + '/api/list/' + requestBody.id, requestBody)
            .then(() => {
                this.setState({
                    redirect: true
                })
            });
    }

    handleForm = (e) => {
        e.preventDefault();

        this.updateList();
    }

    handleChange = (e) => {
        this.setState({
            [e.target.name]: e.target.value
        });
    }
    
    render = () => {
        {return this.state.redirect ? 
            <List 
                id = {this.state.id}
                name = {this.state.name}
                description = {this.state.description}
                status = {this.state.status}
            /> 
        : 
            <div>
                <form onSubmit={this.handleForm}>
                    <label>
                        Update the name of List {this.state.originalName}:
                        <input type='text' name='name' value={this.state.name} onChange={this.handleChange}></input>
                    </label>
                    <label>
                        Update the description of List {this.state.originalName}:
                        <input type='text' name='description' value={this.state.description} onChange={this.handleChange}></input>
                    </label>
                    <label>
                        What is the status of List {this.state.originalName}?
                        <input type='text' name='status' placeholder='To Do' value={this.state.status} onChange={this.handleChange}></input>
                    </label>
                    <input type='submit' value='Update'></input>
                </form>
            </div>
        };
    }
}
