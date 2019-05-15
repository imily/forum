# 管理員API文件

## 管理員專屬API功能

 0. [取得所有使用者](#取得使用者)
 0. [修改使用者密碼](#修改使用者密碼)
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
  },
]
```

### 修改使用者名稱

`PATCH /admin/users/{user_id}/username`

##### 參數

名稱 | 型別 | 敘述
--- | --- | ---
username | string | 使用者名稱

##### Example

```
{
  "username": "NCS-Foo"
}
```

##### Response

`Status: 204 No Content`

##### Error

代碼: 敘述

1: 未知的錯誤

1008: 使用者 id 無效

1009: 無修改權限

2002: 修改失敗

3001: 輸入有空值

3002: 無效的參數

### 修改使用者密碼

`PATCH /admin/users/{user_id}/password`

##### 參數

名稱 | 型別 | 敘述
--- | --- | ---
password | string | 密碼

##### Example

```
{
  "password": "EMHi8OKhO5MSBraS"
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
