# 使用者註冊API文件

## 使用者註冊專屬API功能

 0. [使用者註冊](#使用者註冊)

### 使用者註冊

`POST /registered`

##### 參數

名稱 | 型別 | 敘述
--- | --- | ---
username | string | 使用者名稱
password | string | 密碼

##### Example

```
 {
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

1004: 名稱已經存在

2001: 新增失敗

3001: 輸入有空值

3002: 無效的參數
