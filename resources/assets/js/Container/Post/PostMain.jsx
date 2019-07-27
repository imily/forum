import React, { Component } from 'react';
import {connect} from "react-redux";
import {actionGetPosts} from "../../Redux/Action/Post";
import Post from '../../Component/Post/Post';

class PostMain extends Component {
    constructor(props) {
        super(props);
    }

    componentDidMount() {
        this.props.actionGetPosts();
    }

    render() {
        return (
            <div className="forum-cotainer">
                {this.props.ReducerPosts.list.map((item, index) =>
                    <Post item = {item}  key = {index}  />
                )}
            </div>
        );
    }
}

function mapStateToProps(state) {
    return state;
}

const mapDispatchToProps = (dispatch) => ({
    actionGetPosts: () => dispatch(actionGetPosts())
});

export default connect(mapStateToProps, mapDispatchToProps)(PostMain);
