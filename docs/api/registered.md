# 使用者註冊API文件

## 使用者註冊專屬API功能

 0. [使用者註冊](#使用者註冊)

### 使用者註冊

`POST /registered`

##### 參數

名稱 | 型別 | 敘述
--- | --- | ---
sticker_type | int | 頭像類型
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

```
{
  "error": 3002
}
```

代碼: 敘述

1: 未知的錯誤

1003: 帳號已經存在

2001: 新增失敗

3001: 輸入有空值

3002: 無效的參數
