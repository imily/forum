import React, {Component} from 'react';

class PostItem extends Component {

    render() {
        return (
            <div>
                {this.props.meme.user_name}
            </div>
        );
    }
}

export default PostItem;
