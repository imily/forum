const url = '/forum/public/api/posts';

const params = {
    offset: 0,
    limit: 2,
    message_offset: 0,
    message_limit: 10
};

function toQueryString(obj) {
    let parts = [];
    for (let i in obj) {
        if (obj.hasOwnProperty(i)) {
            parts.push(encodeURIComponent(i) + "=" + encodeURIComponent(obj[i]));
        }
    }
    return parts.join("&");
}

// get from API
export function fetchMemesJson() {
    return fetch(url + '?' + toQueryString(params))
        .then(response => response.json())
}
