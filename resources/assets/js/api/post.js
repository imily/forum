import axios from 'axios';

export const apiGetPosts = (limit, offset, message_limit, message_offset)  => {
        const url = '/forum/public/api/posts';
        return axios.get(url , {params: {
                limit: limit,
                offset: offset,
                message_offset: message_offset,
                message_limit: message_limit
            }})
            .then(response => {
                return response.data;
            })
            .catch(error => {
                return error;
            });
};
