import React from "react";

import {apiGetPosts} from '../../Api/Post';
import {RECEIVE_POSTS} from './Type';

export const receivePosts = (limit, json) => {
    return {
        type: RECEIVE_POSTS,
        list: json.data,
        allPages: Math.ceil(json.total_amount / limit),
        limit: limit
    }
}

export const actionGetPosts =
    (limit = 1, offset = 0, message_limit = 10, message_offset = 0) => {
        return dispatch => {
            return apiGetPosts(limit, offset, message_limit = 10, message_offset)
                .then(json => {
                    dispatch(receivePosts(limit, json))
                })
        }
    }
