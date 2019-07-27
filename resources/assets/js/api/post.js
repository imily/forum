import axios from 'axios';

export const apiGetPosts =
    (offset=0, limit=2, message_offset=0, message_limit=10) => {
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
