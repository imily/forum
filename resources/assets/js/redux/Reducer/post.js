import {combineReducers} from 'redux';
import {RECEIVE_POSTS} from '../Action/Type';

const postInitialState = {
    list: [],
    allPages: 0,
    limit: 0
};

function ReducerPosts(state = postInitialState, action) {
    switch (action.type) {
        case RECEIVE_POSTS:
            return {
                ...state,
                list: action.list,
                allPages: action.allPages,
                limit: action.limit
            };
        default:
            return state;
    }
}

const postReducer = combineReducers({ReducerPosts});
export default postReducer;
