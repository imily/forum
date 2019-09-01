import React, {Component} from 'react';
import {connect} from "react-redux";

import {actionGetPosts} from "../../Redux/Action/Post";

import Header from '../../Component/Common/Header';
import Footer from '../../Component/Common/Footer';
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
            <React.Fragment>
                <Header />
                    <div className="forum-container">
                        {this.props.list.map((item, index) =>
                            <Post item={item} key={index}/>
                        )}
                        <PageMain/>
                    </div>
                <Footer />
            </React.Fragment>
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
