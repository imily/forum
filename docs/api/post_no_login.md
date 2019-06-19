# Post API文件

## 討論區 API功能

0. [取得部分討論主題](#取得部分討論主題)

### 取得部分討論主題

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
        "user_sicker_type": 2,
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
