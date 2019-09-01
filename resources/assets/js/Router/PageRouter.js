import React, { Component } from 'react';
import { Route, Switch } from 'react-router-dom';

import PostMain from '../Container/Post/PostMain';
import MasterNoLogin from '../Component/MasterNoLogin';
import Login from '../Component/Auth/Login';
import { PrivateRoute } from './PrivateRoute';

class PageRouter extends Component {
    render() {
        return (
            <Switch>
                <Route exact path="/" component={MasterNoLogin} />
                <Route exact path="/login" component={Login} />
                <PrivateRoute exact path="/post" component={PostMain} />
            </Switch>
        );
    }
}

export default PageRouter;
