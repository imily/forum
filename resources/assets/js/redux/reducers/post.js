import {combineReducers} from 'redux';
import {RECEIVE_POSTS} from '../actions/post';

const devicesInitialState = {
    list : [],
    totalAmount : 0,
};

function posts(state = devicesInitialState, action) {
    switch (action.type) {
        case RECEIVE_POSTS:
            return {
                ...state,
                list: action.actionList,
                totalAmount: action.actionTotal
            };
        default:
            return state;
    }
}

const postReducer = combineReducers({posts});

export default postReducer;
