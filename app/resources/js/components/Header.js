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
            <div className='header'>
                <div className='header-container'>
                    <img className='logo' alt='Broadnet logo' src='/broadnet_logo.png'></img>
                    <div className='header-title'>Spencer Dant's Todo List App</div>
                </div>
            </div>
        )
    };
}

if (document.getElementById('header')) {
    ReactDOM.render(<Header />, document.getElementById('header'));
}
