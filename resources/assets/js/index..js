import React from 'react';
import ReactDOM from 'react-dom';

import {Provider} from 'react-redux';
import Store from './Redux/Stroe';

import './styles/css/normalize.css';
import './styles/css/basic.css';
import './styles/css/nivo-slider.css';
import './styles/themes/default/default.css';
import './styles/css/jquery.fancybox.min.css';
import './styles/css/style.css';
import './styles/css/rwd.css';

import Master from './Component/Common/Master';

ReactDOM.render(
    <Provider store={Store}>
        <Master/>
    </Provider>
    , document.getElementById('root'));
