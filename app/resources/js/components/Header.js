import React from 'react';
import ReactDOM from 'react-dom';

export default class Header extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            loaded: false
        }
    }
    
    render = () => {
        return (
            <div className = 'header'>
                <h1><b>Spencer Dant's Super Duper Todo List App</b></h1>
                <h4>For Broadnet</h4>
            </div>
        )
    };
}

if (document.getElementById('header')) {
    ReactDOM.render(<Header />, document.getElementById('header'));
}
