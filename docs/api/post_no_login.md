# Post API文件

## 討論區 API功能

0. [取得所有討論主題](#取得所有討論主題)

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
