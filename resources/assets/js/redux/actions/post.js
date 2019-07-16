// 匯入API
import {fetchMemesJson} from '../../api/post';

// 定義行為
function receiveMemes(json) {
    const memes = json.data;
    return {
        type: RECEIVE_MEMES,
        memes
    }
}

// 匯出行為(取得API)的dispatch
export function fetchMemes() {
    return function (dispatch) {
        return fetchMemesJson()
            .then(json => dispatch(receiveMemes(json)))
    }
}

export const RECEIVE_MEMES = 'RECEIVE_MEMES';
