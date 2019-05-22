# Message API文件

## 留言 API功能

0. [取得單一討論主題的單一留言](#取得單一討論主題的單一留言)
0. [新增單一討論主題的單一留言](#新增單一討論主題的單一留言)
0. [修改單一討論主題的單一留言](#修改單一討論主題的單一留言)

### 取得單一討論主題的單一留言

`GET /posts/{postId}/messages/{messageId}`

##### Response

`Status: 200 OK`

```json
{
    "id": 1,
    "user_id": 1,
    "description": "留言內容",
    "create_time": "2018-12-19 08:00:00",
    "update_time": "2018-12-20 08:00:00"
}
```
##### Error

```
{
  "error":  3002
}
```

代碼: 敘述

1: 未知的錯誤

3002: 無效的參數

3003: 查無指定參數的內容

### 新增單一討論主題的單一留言

`POST /posts/{postId}/message`

##### 參數

| 名稱          | 型別    | 敘述 |
| ---          | ---     | --- |
| user_id    | int     | 留言者 |
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

### 修改單一討論主題的單一留言

`PATCH /posts/{postId}/messages/{messageId}`

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

2002: 修改失敗

3002: 無效的參數

3003: 查無指定參數的內容
