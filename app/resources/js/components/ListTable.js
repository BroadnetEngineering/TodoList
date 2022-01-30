import React from 'react';
import ReactDOM from 'react-dom';
import List from './List';

/**
 * Display all TodoLists
 */
export default class ListTable extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            loaded: false,
            lists: [],
        }
    }

    componentDidMount = () => {
        fetch(process.env.MIX_API_URL + '/api/list')
            .then(response => response.json())
            .then(
                (result) => {
                    this.setState({
                        loaded: true,
                        lists: result
                    })
                }
            );
    }

    // TODO: add individual list screen
    // showIndividualList = (list) => {
    //     fetch(process.env.MIX_API_URL + '/api/list/' + list.id)
    //         .then(response => response.json())
    //         .then(
    //             (result) => {
    //                 this.setState({
    //                     listToShow: result,
    //                     showIndividualList: true
    //                 })
    //             }
    //         )
    //         .finally(this.setState({
    //             canUpdateOrDeleteList: true
    //         }));
    // }
    
    render = () => {
        const lists = this.state.lists;

        return (
            <div>
                <form method='GET' action='/newList'>
                    <input type='submit' value='Create a New List'></input>
                </form>
                <ul>
                    {lists.map(list => {
                        return (
                            <div className = 'list-container'>
                                <List
                                    id = {list.id}
                                    name = {list.name}
                                    description = {list.description}
                                    status = {list.status} 
                                />
                            </div>
                        )
                    })}
                </ul>
            </div>
        );
    };
}

if (document.getElementById('list-table')) {
    ReactDOM.render(<ListTable />, document.getElementById('list-table'));
}
