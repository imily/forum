# Message API文件

## 留言 API功能

0. [取得單一主題的所有留言](#取得單一主題的所有留言)
0. [取得單一使用者的所有留言](#取得單一使用者的所有留言)
0. [新增單一主題的留言](#新增單一主題的留言)
0. [修改單一主題的留言](#修改單一主題的留言)

### 取得單一主題的所有留言

`GET /posts/{postId}/messages`

#### 參數

| 名稱       | 型別   | 敘述                     |
| ---------- | ------ | ------------------------ |
| offset    | int | 非必要，留言偏移量  |
| limit     | int | 非必要，限制留言數量 |

##### Response

`Status: 200 OK`

```json
{
    "total_amount": 4,
    "data":[
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
}
```
##### Error

```
{
  "error": 4001
}
```

代碼: 敘述

1: 未知的錯誤

4001: 取得ID失敗

3002: 無效的參數

3003: 查無指定參數的內容

### 取得單一使用者的所有留言

`GET /users/{userId}/messages`

##### Response

`Status: 200 OK`

```json
{
    "total_amount": 4,
    "data":[
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
}
```

##### Error

```
{
  "error": 4001
}
```

1: 未知的錯誤

4001: 取得ID失敗

3002: 無效的參數

3003: 查無指定參數的內容

### 新增單一主題的單一留言

`POST /posts/{postId}/message`

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

### 新增單一主題的留言

`POST posts/{postId}/message`

##### 參數

| 名稱          | 型別    | 敘述 |
| ---          | ---     | --- |
| user_id    | int     | 發表留言的人 |
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

### 修改單一主題的單筆留言

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

4001: 取得ID失敗

3002: 無效的參數

3003: 查無指定參數的內容
