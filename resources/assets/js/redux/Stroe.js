import {createStore, applyMiddleware} from 'redux';
import thunk from 'redux-thunk';

import postReducer from './Reducer/Post';

const Store = createStore(postReducer, applyMiddleware(thunk));

export default Store;
