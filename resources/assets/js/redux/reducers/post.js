import {combineReducers} from 'redux';
import {RECEIVE_MEMES} from '../actions/post';

function memes(state = [], action) {
    switch (action.type) {
        case RECEIVE_MEMES:
            return action.memes;
        default:
            return state;
    }
}

const postReducer = combineReducers({memes});

export default postReducer;
