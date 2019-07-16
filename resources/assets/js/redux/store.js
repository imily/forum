import {createStore, applyMiddleware} from 'redux';
import thunk from 'redux-thunk';

import postReducer from './reducers/post';
import {fetchMemes} from './actions/post';

const store = createStore(postReducer, applyMiddleware(thunk));

store.subscribe(() => console.log('store', store.getState()));
store.dispatch(fetchMemes());

export default store;
