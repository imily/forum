import React, {Component} from 'react';
import {connect} from "react-redux";

import {actionGetPosts} from "../../Redux/Action/Post";

import PageMain from '../../Container/Post/PageMain';
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
                {this.props.list.map((item, index) =>
                    <Post item={item} key={index}/>
                )}
                <PageMain/>
            </div>
        );
    }
}

const mapStateToProps = (state) => ({
    list: state.ReducerPosts.list
});

const mapDispatchToProps = (dispatch) => ({
    actionGetPosts: () => dispatch(actionGetPosts())
});

export default connect(mapStateToProps, mapDispatchToProps)(PostMain);
