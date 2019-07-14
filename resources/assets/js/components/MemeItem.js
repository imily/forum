import React, { Component } from 'react';

class MemeItem extends Component{

    render(){
        return (
            <div>
                <p>
                    {this.props.meme.user_name}
                </p>
            </div>
        )
    }
}

export default MemeItem;
