# User API 文件

## 使用者API功能

0. [取得目前使用者](#取得目前使用者)
0. [變更目前使用者資訊](#變更目前使用者資訊)

### 取得目前使用者

`GET /user/info`

#### Response

`Status: 200 OK`

```
{
  "id": 2,
  "sicker_type": 2,
  "username": "Imily"
}
```

### 變更目前使用者資訊

`PATCH /user/info`

#### 參數

名稱 | 型別 | 敘述
--- | --- | ---
sticker_type     | int | 頭像類型
new_password     | string | 新密碼
confirm_password | string | 確認新密碼

#### Response

`Status: 204 No Content`

#### Error

```
{
  "error": 1007
}
```

代碼: 敘述

1: 未知的錯誤

1006: 兩次密碼不相符

2002: 修改失敗

3001: 輸入有空值
