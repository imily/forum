import {combineReducers} from 'redux';
import {RECEIVE_POSTS} from '../Action/Type';

const postInitialState = {
    list : [],
    totalAmount : 0,
};

function ReducerPosts(state = postInitialState, action) {
    switch (action.type) {
        case RECEIVE_POSTS:
            return {
                ...state,
                list: action.list,
                totalAmount: action.totalAmount
            };
        default:
            return state;
    }
}

const postReducer = combineReducers({ReducerPosts});
export default postReducer;
