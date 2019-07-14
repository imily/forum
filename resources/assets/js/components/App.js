import React, {Component} from 'react';
import {connect} from 'react-redux';
import MemeItem from './MemeItem';

class App extends Component {
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
                            <MemeItem key={index}
                                      meme={meme} />
                        )
                    })
                }
            </div>
        )
    }
}

function mapStateToProps(state) {
    return state;
}

export default connect(mapStateToProps, null)(App);
