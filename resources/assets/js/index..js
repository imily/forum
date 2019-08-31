import React from 'react';
import ReactDOM from 'react-dom';
import PostMain from './Container/Post/PostMain';

import {Provider} from 'react-redux';
import Store from './Redux/Stroe';

ReactDOM.render(
    <Provider store={Store}>
        <PostMain/>
    </Provider>
    , document.getElementById('post-main'));
