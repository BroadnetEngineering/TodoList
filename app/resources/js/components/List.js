import React from 'react';
import UpdateForm from './UpdateForm';

export default class List extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            id: props.id,
            name: props.name,
            description: props.description,
            status: props.status,
            unmount: props.unmount,
            update: false,
            delete: false
        }
    }

    /**
     * Hide the remaining lists and open the update form
     */
    updateList = (e) => {
        this.setState({
            update: true
        });
    }

    /**
     * Delete a list and force an empty rerender to remove without reloading data
     */
    deleteList = () => {
        const requestData = {
            id: this.state.id,
            name: this.state.name,
            description: this.state.description,
            status: this.state.status
        }

        const requestBody = {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(requestData)
        }

        fetch(process.env.MIX_API_URL + '/api/list/' + requestData.id, requestBody)
            .then(this.setState({
                delete: true
            }));   
    }

    render() {
        if (this.state.update) {
            return (
                <div>
                    <UpdateForm 
                        id = {this.state.id}
                        name = {this.state.name}
                        description = {this.state.description}
                        status = {this.state.status}
                    />
                </div>
            );
        } else if (this.state.delete) {
            return '';
        } else {
            return (
                <div className='component-container'>
                    <h2>List:</h2>
                    <p>Name: {this.state.name}</p>
                    <p>Description: {this.state.description}</p>
                    <p>Status: {this.state.status}</p>

                    <input type='submit' value='Update List' onClick={this.updateList}></input>
                    <input type='submit' value='Delete List' onClick={this.deleteList}></input>
                </div>
            );
        }
    }
}
