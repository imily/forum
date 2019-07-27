import React from 'react';
import ReactDOM from 'react-dom';
import PostMain from './Container/Post/PostMain';

import {Provider} from 'react-redux';
import store from './Redux/Store';

ReactDOM.render(
    <Provider store={store}>
        <PostMain/>
    </Provider>
    , document.getElementById('post-main'));
