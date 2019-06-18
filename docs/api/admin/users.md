# 管理員API文件

## 管理員專屬API功能

 0. [新增使用者](#新增使用者)
 0. [取得所有使用者](#取得使用者)
 0. [變更目前使用者資訊](#變更目前使用者資訊)
 0. [批量刪除使用者](#批量刪除使用者)

### 新增使用者

`POST /admin/user`

##### 參數

名稱 | 型別 | 敘述
--- | --- | ---
email    | string | 信箱
username | string | 使用者名稱
password | string | 密碼

##### Example

```
{
    "sticker_type": 1,
    "username": "foo",
    "password": "7d8VttAyeTSoyLdL"
}
```

##### Response

`Status: 201 Created`

```
{
  "id": "2"
}
```
##### Error

代碼: 敘述

1: 未知的錯誤

1003: 帳號已經存在

2001: 新增失敗

3001: 輸入有空值

3002: 無效的參數

### 取得使用者

#### 取得所有使用者

`GET /admin/users`

##### Response

`Status: 200 OK`

```
[
  {
    "id": 1,
    "sticker_type": 1,
    "username": "admin"
  },
  {
    "id": 2,
    "sticker_type": 1,
    "username": "foo"
  },
  {
    "id": 3,
    "sticker_type": 1,
    "username": "bar"
  }
]
```

### 變更目前使用者資訊

`PATCH /admin/users/{user_id}/info`

##### 參數

名稱 | 型別 | 敘述
--- | --- | ---
sticker_type     | int | 頭像類型
new_password     | string | 新密碼
confirm_password | string | 確認新密碼

##### Response

`Status: 204 No Content`

##### Error

```
{
  "error": 1007
}
```

代碼: 敘述

1: 未知的錯誤

1006: 兩次密碼不相符

1008: 使用者 id 無效

1012: 不可被修改

2002: 修改失敗

3001: 輸入有空值

3002: 無效的參數

### 批量刪除使用者

`DELETE /admin/users`

##### 參數

名稱 | 型別 | 敘述
--- | --- | ---
ids  | array | 一個或多個使用者ID

##### Example

- `ids`: `array(1,2,3)`

##### Response

`Status: 204 No Content`

##### Error

代碼: 敘述

1008: 取得 id 失敗

1010: 不可被刪除

2003: 刪除發生錯誤

3002: 無效的參數
