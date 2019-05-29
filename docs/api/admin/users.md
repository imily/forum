# 管理員API文件

## 管理員專屬API功能

 0. [取得所有使用者](#取得使用者)
 0. [修改使用者密碼](#修改使用者密碼)
 0. [修改使用者頭像類型](#修改使用者頭像類型)
 0. [批量刪除使用者](#批量刪除使用者)

### 取得使用者

#### 取得所有使用者

`GET /admin/users`

##### Response

`Status: 200 OK`

```
[
  {
    "id": 1,
    "username": "admin"
  },
  {
    "id": 2,
    "username": "foo"
  },
  {
    "id": 3,
    "username": "bar"
  }
]
```

### 修改使用者密碼

`PATCH /admin/users/{user_id}/password`

##### 參數

名稱 | 型別 | 敘述
--- | --- | ---
new_password | string | 新密碼
confirm_password	 | string | 確認新密碼

##### Example

```
{
  "new_password": "EMHi8OKhO5MSBraS",
  "confirm_password": "EMHi8OKhO5MSBraS"
}
```

##### Response

`Status: 204 No Content`

##### Error

代碼: 敘述

1: 未知的錯誤

1008: 使用者 id 無效

2002: 修改失敗

3001: 輸入有空值

3002: 無效的參數

### 修改使用者頭像類型

`PATCH /admin/users/{user_id}/sticker_type`

##### 參數

名稱 | 型別 | 敘述
--- | --- | ---
sticker_type | int | 頭像類型

##### Example

```
{
  "sticker_type": 2,
}
```

##### Response

`Status: 204 No Content`

##### Error

代碼: 敘述

1: 未知的錯誤

1008: 使用者 id 無效

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
