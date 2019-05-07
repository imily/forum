# Message API文件

## 留言 API功能

0. [取得單一主題的所有留言](#取得單一主題的所有留言)
0. [取得單一使用者的所有留言](#取得單一使用者的所有留言)
0. [修改單一主題的留言](#修改單一主題的留言)

### 取得單一主題的所有留言

`GET /{postId}/messages`

##### Response

`Status: 200 OK`

```json
[
  {
    "id": 1,
    "user_id": 1,
    "description": "留言內容",
    "create_time": "2018-12-19 08:00:00"
  },
  {
    "id": 2,
    "user_id": 2,
    "description": "第二則留言內容",
    "create_time": "2019-03-01 08:00:00"
  }
]
```
##### Error

```
{
  "error": 4001
}
```

代碼: 敘述

4001: 取得ID失敗

### 取得單一使用者的所有留言

`GET /{userId}/messages`

##### Response

`Status: 200 OK`

```json
[
  {
    "id": 1,
    "post_id": 1,
    "description": "留言內容",
    "create_time": "2018-12-19 08:00:00"
  },
  {
    "id": 2,
    "post_id": 2,
    "description": "第二則留言內容",
    "create_time": "2019-03-01 08:00:00"
  }
]
```
##### Error

```
{
  "error": 4001
}
```

代碼: 敘述

4001: 取得ID失敗

### 新增單一主題的單一留言

`POST /{postId}/message`

##### 參數

| 名稱          | 型別    | 敘述 |
| ---          | ---     | --- |
| user_id    | int     | 留言的人 |
| description  | string     | 敘述 |

##### Example

```json
{
  "user_id": 1,
  "description": "第二則留言內容"
}
```

##### Error

```
{
  "error": 2001
}
```

代碼: 敘述

1: 未知的錯誤

2001: 新增失敗

3001: 輸入有空值

3002: 無效的參數

### 修改單一主題的留言

`PATCH /{postId}/message/{messageId}`

##### 參數

| 名稱          | 型別    | 敘述 |
| ---          | ---     | --- |
| description  | string     | 敘述 |

##### Response

`Status: 204 OK`

##### Example

```json
{
  "description": "第二則留言內容"
}
```

##### Error

```
{
  "error": 3002
}
```

代碼: 敘述

1: 未知的錯誤

3002: 無效的參數

4001: 取得ID失敗
