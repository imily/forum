import React, {Component} from 'react';

class Post extends Component {
    constructor(props) {
        super(props);
    }

    render() {
        const item = this.props.item;

        return (
            <div className="row clearfix">
                <div className="col sticker">
                    <div className={`pic sticker-${item.user_sicker_type}`}>
                    </div>
                </div>
                <div className="col">
                    <div className="main-post">
                        <div className="topic">{item.topic}</div>
                        <div className="posted-by">
                            <span className="user">{item.user_name}</span>
                            <div className="time">{item.update_time}</div>
                        </div>
                        <div className="main-content">{item.description}</div>
                        <a className="likes" href="#">LIKE
                            <span className="num">{item.likes.length}</span>
                        </a>
                        <div className="comment">
                            <button type="submit" className="btn-style-normal">ADD COMMENT</button>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}

export default Post;
