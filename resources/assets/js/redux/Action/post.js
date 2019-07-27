import React from "react";

// 匯入API
import {apiGetPosts} from '../../Api/Post';
import {RECEIVE_POSTS} from './Type';

// 定義行為
export const receivePosts = (json) => {
    return {
        type: RECEIVE_POSTS,
        list: json.data,
        totalAmount: json.total_amount
    }
}

// 匯出行為(取得API)的dispatch
export const actionGetPosts = () => {
    return dispatch => {
        return apiGetPosts()
            .then(json => {
                dispatch(receivePosts(json))
            })
    }
}
