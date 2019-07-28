import React, {Component} from 'react';
import {connect} from "react-redux";

import {actionGetPosts} from "../../Redux/Action/Post";
import Message from '../../Component/Post/Message';

class MessageMain extends Component {
    constructor(props) {
        super(props);
    }

    componentDidMount() {
        this.props.actionGetPosts();
    }

    render() {
        const message = this.props.list[0].messages.data;
        return (
            <Message list = {message}/>
        );
    }
}

const mapStateToProps = (state) => ({
    list: state.ReducerPosts.list
});

const mapDispatchToProps = (dispatch) => ({
    actionGetPosts: () => dispatch(actionGetPosts())
});

export default connect(mapStateToProps, mapDispatchToProps)(MessageMain);
