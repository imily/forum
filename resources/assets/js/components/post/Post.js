import React, {Component} from 'react';

class Post extends Component {
    constructor(props) {
        super(props);
    }

    render() {
        return (
            <ul>
                {this.props.list.map((item, index) =>
                    <li key={index}>
                        {item.user_name}
                    </li>
                )}
            </ul>
        );
    }
}

export default Post;
