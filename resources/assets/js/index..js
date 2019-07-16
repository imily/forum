import React from 'react';
import ReactDOM from 'react-dom';
import Post from './components/post/Post';

import {Provider} from 'react-redux';
import store from './redux/store';

ReactDOM.render(
    <Provider store={store}>
        <Post/>
    </Provider>
    , document.getElementById('example'));
