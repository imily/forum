# Message API文件

## 留言 API功能

0. [取得單一討論主題的所有留言](#取得單一討論主題的所有留言)

### 取得單一討論主題的所有留言

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

3002: 無效的參數

3003: 查無指定參數的內容
