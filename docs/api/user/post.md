# Post API文件

## 討論區 API功能

0. [取得單一討論主題](#取得單一討論主題)
0. [取得單一使用者的部分討論主題](#取得單一使用者的部分討論主題)
0. [新增單一討論主題](#新增單一討論主題)
0. [修改單一討論主題](#修改單一討論主題)
0. [批量刪除討論主題](#批量刪除討論主題)
0. [新增喜歡單一討論主題](#新增喜歡單一討論主題)

### 取得單一討論主題

`GET /posts/{postId}`

#### 參數

| 名稱       | 型別   | 敘述                     |
| ---------- | ------ | ------------------------ |
| message_offset    | int | 非必要，留言偏移量  |
| message_limit     | int | 非必要，留言主題數量 |

##### Response

`Status: 200 OK`

```json
{
    "id": 1,
    "user_name": "Imily",
    "user_sicker_type": 1,      
    "messages": {
        "total_amount": 2,
        "data":[
            {
                "user_name": "John",
                "description" : "留言內容"
            },
            {
                "user_name": "Tom",
                "description" : "留言內容"
            }
    ]},
    "topic": "討論標題",
    "description": "討論內容",
    "likes": [
         {
             "user_name": "John"
         },
         {
             "user_name": "Tom"
         }
     ],
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

3002: 無效的參數

3003: 查無指定參數的內容

### 取得單一使用者的部分討論主題

`GET /users/{userId}/posts`

#### 參數

| 名稱       | 型別   | 敘述                     |
| ---------- | ------ | ------------------------ |
| offset    | int | 非必要，主題偏移量  |
| limit     | int | 非必要，限制主題數量 |
| message_offset    | int | 非必要，留言偏移量  |
| message_limit     | int | 非必要，留言主題數量 |

##### Response

`Status: 200 OK`

```json
{
    "total_amount": 2,
    "data":[
      {
        "id": 1,
        "user_name": "Imily",
        "user_sicker_type": 1,        
        "messages": {
            "total_amount": 2,
            "data":[
                {
                    "user_name": "John",
                    "description" : "留言內容"
                },
                {
                    "user_name": "Tom",
                    "description" : "留言內容"
                }
        ]},
        "topic": "討論標題",
        "description": "討論內容",
        "likes": [
             {
                 "user_name": "John"
             },
             {
                 "user_name": "Tom"
             }
         ],
        "create_time": "2018-12-19 08:00:00",
        "update_time": "2018-12-20 08:00:00"
      },
      {
        "id": 2,
        "user_name": "Jessie",
        "user_sicker_type": 1,      
        "messages": {
            "total_amount": 2,
            "data":[
                {
                    "user_name": "John",
                    "description" : "留言內容"
                },
                {
                    "user_name": "Tom",
                    "description" : "留言內容"
                }
        ]},
        "topic": "討論標題",
        "description": "討論內容",
        "likes": [
             {
                 "user_name": "John"
             },
             {
                 "user_name": "Tom"
             }
         ],
        "create_time": "2019-03-01 08:00:00",
        "update_time": "2019-03-10 08:00:00"
      }
  ]
}
```

### 新增單一討論主題

`POST /post`

##### 參數

| 名稱          | 型別    | 敘述 |
| ---          | ---     | --- |
| user_id    | int     | 發表主題的人 |
| topic        | string | 標題 |
| description  | string     | 敘述 |

##### Response

`Status: 201 OK`

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

### 修改單一討論主題

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

### 批量刪除討論主題

`DELETE /posts/postIds`

##### 參數

名稱 | 型別 | 敘述
--- | --- | ---
ids  | array | 一個或多個討論主題ID

##### Example

 `ids`: `array(1,2,3)`

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

### 新增喜歡單一討論主題

`POST /posts/{postId}/like`

##### 參數

| 名稱          | 型別    | 敘述 |
| ---          | ---     | --- |
| user_id    | int     | 喜歡此討論主題的使用者 |

##### Response

`Status: 201 OK`

##### Example

```json
{
  "user_id": 1
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
