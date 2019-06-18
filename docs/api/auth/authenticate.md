# Auth API 文件

## API功能

0. [登入](#登入)
0. [登出](#登出)

### 登入

`POST /auth/login`

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

`POST /auth/logout`

#### Response

`Status: 204 No Content`
