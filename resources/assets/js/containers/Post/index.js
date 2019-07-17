import React, { Component } from 'react';
import {connect} from "react-redux";
import {fetchPosts} from "../../redux/actions/post";
import Post from '../../components/post/Post';

class PostMain extends Component {
    constructor(props) {
        super(props);
    }

    componentDidMount() {
        this.props.fetchPosts();
    }

    render() {
        return (
            <div>
                <h2> Welcome to the Meme Generator!</h2>
                <Post list = {this.props.posts.list}  />
            </div>
        );
    }
}

function mapStateToProps(state) {
    return state;
}

const mapDispatchToProps = (dispatch) => ({
    fetchPosts: () => dispatch(fetchPosts())
});

export default connect(mapStateToProps, mapDispatchToProps)(PostMain);
