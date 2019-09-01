import React, { Component } from 'react';
import { Route, HashRouter } from 'react-router-dom';

import PostMain from '../Container/Post/PostMain';

class PageRouter extends Component {
    render() {
        return (
            <HashRouter>
                <Route path="/" component={PostMain} />
            </HashRouter>
        );
    }
}

export default PageRouter;
