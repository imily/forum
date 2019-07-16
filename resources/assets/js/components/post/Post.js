import React, { Component } from 'react';
import {connect} from "react-redux";
import PostItem from "./PostItem";
import {fetchMemes} from "../../redux/actions/post";

class Post extends Component {
    constructor(props) {
        super(props);
    }

    render() {
        return (
            <div>
                <h2> Welcome to the Meme Generator!</h2>

                {
                    this.props.memes.map((meme, index) => {
                        return (
                            <PostItem key={index}
                                      meme={meme} />
                        )
                    })
                }
            </div>
        );
    }
}

function mapStateToProps(state) {
    return state;
}

const mapDisPatchToProps = (dispatch) => { };

export default connect(mapStateToProps, mapDisPatchToProps())(Post);
