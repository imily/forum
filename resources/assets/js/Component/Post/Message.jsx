import React, {Component} from 'react';

class Message extends Component {
    constructor(props) {
        super(props);
    }

    render() {
        return (
            <ul className="message">
                {this.props.list.map((item, index) =>
                    <li key={index}>
                        <span className="user">{item.user_name}</span>
                        <p className="content">{item.description}</p>
                        {/*<div className="time">2018-7-26 19:34</div>*/}
                    </li>
                )}
            </ul>
        );
    }
}

export default Message;
