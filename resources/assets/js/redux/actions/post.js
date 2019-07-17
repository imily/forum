// 匯入API
import {fetchPostsJson} from '../../api/post';

// 定義行為
function receivePosts(json) {
    return {
        type: RECEIVE_POSTS,
        actionList: json.data,
        actionTotal: json.total_amount
    }
}

// 匯出行為(取得API)的dispatch
export function fetchPosts() {
    return function (dispatch) {
        return fetchPostsJson()
            .then(json => {dispatch(receivePosts(json))})
    }
}

export const RECEIVE_POSTS = 'RECEIVE_POSTS';
