import React, { Component } from 'react';
import { Route, Switch } from 'react-router-dom';

import PostMain from '../Container/Post/PostMain';

class PageRouter extends Component {
    render() {
        return (
            <Switch>
                <Route path="/" component={PostMain} />
            </Switch>
        );
    }
}

export default PageRouter;
