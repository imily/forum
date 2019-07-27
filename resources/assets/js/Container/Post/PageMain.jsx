import React, {Component} from 'react';
import {connect} from "react-redux";
import {actionGetPosts} from "../../Redux/Action/Post";
import Page from "../../Component/Post/Page";

class PageMain extends Component {
    constructor(props) {
        super(props);
        this.state = {
            nowPage: 1,
            page: {
                limit: 0,
                offset: 0,
                message_limit: 10,
                message_offset: 0
            }
        };
        this.setPage = this.setPage.bind(this);
        this.changePage = this.changePage.bind(this);
    }

    setPage(event) {
        let newPage = parseInt(event.target.value);
        let newOffset = (newPage - 1) * this.state.page.limit;
        this.setState({
            nowPage: newPage,
            page: {
                limit: this.props.limit,
                offset: newOffset,
                message_limit: 10,
                message_offset: 0
            }
        });
    }

    changePage() {
        let pageData = this.state.page;
        this.props.actionGetPosts(pageData.limit, pageData.offset, pageData.message_limit, pageData.message_offset);
    }

    render() {
        let pageList = [];
        for (let i = 1; i <= this.props.allPages; i++) {
            pageList.push(i);
        }
        return (
            <Page list={pageList}
                  onMainMouseOver={this.setPage}
                  onMainClick={this.changePage}/>
        );
    }
}

const mapStateToProps = (state) => ({
    allPages: state.ReducerPosts.allPages,
    limit: state.ReducerPosts.limit
});

const mapDispatchToProps = (dispatch) => ({
    actionGetPosts: (limit, offset, message_limit, message_offset) => dispatch(actionGetPosts(limit, offset, message_limit, message_offset))
});

export default connect(mapStateToProps, mapDispatchToProps)(PageMain);
