# Auth API 文件

## API功能

0. [註冊](#註冊)
0. [登入](#登入)
0. [登出](#登出)

### 註冊

`POST /registered`

#### 參數

名稱 | 型別 | 敘述
--- | --- | ---
account  | string | 帳號
password | string | 密碼

```
{
  "account": "foo",
  "password": "123456"
}
```

#### Response

`Status: 200 OK`

```
{
  "id": "2"
}
```

#### Error

```
{
  "error": 3001
}
```

代碼: 敘述

1: 未知的錯誤

1004: 名稱已經存在

2001: 新增失敗

3001: 輸入有空值

3002: 無效的參數

### 登入

`POST /login`

#### 參數

名稱 | 型別 | 敘述
--- | --- | ---
account  | string | 帳號
password | string | 密碼

#### Example

```
{
  "account": "foo",
  "password": "123456"
}
```

#### Response

`Status: 200 OK`

```
{
  "id": "2"
}
```

#### Error

```
{
  "error": 3001
}
```

代碼: 敘述

1: 未知的錯誤

1006: 密碼有誤

3001: 輸入有空值

### 登出

`POST /logout`

#### Response

`Status: 204 No Content`
