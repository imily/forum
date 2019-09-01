import React from 'react';
import ReactDOM from 'react-dom';
import { HashRouter } from 'react-router-dom';

import {Provider} from 'react-redux';
import Store from './Redux/Stroe';

import './styles/css/normalize.css';
import './styles/css/basic.css';
import './styles/css/jquery.fancybox.min.css';
import './styles/css/style.css';
import './styles/css/rwd.css';

import Master from './Master';

ReactDOM.render(
    <Provider store={Store}>
        <HashRouter>
            <Master/>
        </HashRouter>
    </Provider>
    , document.getElementById('root'));
