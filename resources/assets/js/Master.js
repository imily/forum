import React, { Component } from 'react';
import PageRouter from './Router/PageRouter';

class Master extends Component {
    render() {
        return (
            <div className="wrap">
                <PageRouter />
            </div>
        );
    }
}

export default Master;
