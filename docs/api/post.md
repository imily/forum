# Post API文件

## 討論區 API功能

0. [取得所有討論主題](#取得所有討論主題)
0. [取得單一主題](#取得單一主題)
0. [取得單一使用者的所有主題](#取得單一使用者的所有主題)
0. [新增主題](#新增主題)
0. [修改單一主題](#修改單一主題)
0. [刪除單一主題](#刪除單一主題)

### 取得所有討論主題

`GET /posts`

#### 參數

| 名稱       | 型別   | 敘述                     |
| ---------- | ------ | ------------------------ |
| offset    | int | 非必要，主題偏移量  |
| limit     | int | 非必要，限制主題數量 |

##### Response

`Status: 200 OK`

```json
{
    "total_amount": 4,
    "data":[
      {
        "id": 1,
        "user_id": 1,
        "message_ids": [1,2,3,4],
        "topic": "討論標題",
        "description": "討論內容",
        "likes": [1,2,3,4],
        "create_time": "2018-12-19 08:00:00",
        "update_time": "2018-12-20 08:00:00"
      },
      {
        "id": 2,
        "user_id": 2,
        "message_ids": [5,6,7,8],
        "topic": "第二則討論標題",
        "description": "第二則討論內容",
        "likes": [5,6,7,8],
        "create_time": "2019-03-01 08:00:00",
        "update_time": "2019-03-10 08:00:00"
      }
  ]
}
```

### 取得單一主題

`GET /posts/{postId}`

##### Response

`Status: 200 OK`

```json
{
    "id": 1,
    "user_id": 1,
    "message_ids": [1,2,3,4],
    "topic": "討論標題",
    "description": "討論內容",
    "likes": [1,2,3,4],
    "create_time": "2018-12-19 08:00:00",
    "update_time": "2018-12-20 08:00:00"
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

### 取得單一使用者的所有主題

`GET /users/{userId}/posts`

#### 參數

| 名稱       | 型別   | 敘述                     |
| ---------- | ------ | ------------------------ |
| offset    | int | 非必要，主題偏移量  |
| limit     | int | 非必要，限制主題數量 |

##### Response

`Status: 200 OK`

```json
{
    "total_amount": 4,
    "data":[
      {
        "id": 1,
        "user_id": 1,
        "message_ids": [1,2,3,4],
        "topic": "討論標題",
        "description": "討論內容",
        "likes": [1,2,3,4],
        "create_time": "2018-12-19 08:00:00",
        "update_time": "2018-12-20 08:00:00"
      },
      {
        "id": 2,
        "user_id": 2,
        "message_ids": [5,6,7,8],
        "topic": "第二則討論標題",
        "description": "第二則討論內容",
        "likes": [5,6,7,8],
        "create_time": "2019-03-01 08:00:00",
        "update_time": "2019-03-10 08:00:00"
      }
  ]
}
```

### 新增主題

`POST /post`

##### 參數

| 名稱          | 型別    | 敘述 |
| ---          | ---     | --- |
| user_id    | int     | 發表主題的人 |
| topic        | string | 標題 |
| description  | string     | 敘述 |

##### Example

```json
{
  "user_id": 1,
  "topic": "第二則留言標題",
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

### 修改單一主題

`PATCH /posts/{postId}`

##### 參數

| 名稱          | 型別    | 敘述 |
| ---          | ---     | --- |
| topic        | string     | 標題 |
| description  | string | 敘述 |

##### Response

`Status: 204 OK`

##### Example

```json
{
  "topic": "更新第二則討論標題",
  "description": "更新第二則討論內容"
}
```
##### Error

```
{
  "error": 2002
}
```

代碼: 敘述

1: 未知的錯誤

2002: 修改失敗

3001: 輸入有空值

3002: 無效的參數

4001: 取得ID失敗

### 刪除單一主題

`DELETE /posts/{postId}`

##### 參數

無參數

##### Response

`Status: 204 No Content`

##### Error

```
{
  "error": 2003
}
```

代碼: 敘述

1: 未知的錯誤

2003: 刪除發生錯誤

3002: 無效的參數
