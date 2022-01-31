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

        fetch('/api/list/' + requestData.id, requestBody)
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
                <div className='list-component-container'>
                    <div className='list-button-container'>
                        <input className='list-button' type='submit' value='Update' onClick={this.updateList}></input>
                        <input className='list-button' type='submit' value='Delete' onClick={this.deleteList}></input>
                    </div>
                    <div className='list-component-header'>
                        <h2 className='list-component-name'>{this.state.name}</h2>
                    </div>
                    <div className='list-component-status'>Current Status: {this.state.status}</div>
                    <p className='list-component-description'>{this.state.description}</p>
                </div>
            );
        }
    }
}
