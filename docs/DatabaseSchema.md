# Database Schema

## 命名規範

資料表名稱應該使用大駝峰式命名法(CamelCase)，每一個單字的首字母都採用大寫字母，例如：FirstName、LastName、CamelCase。

欄位名稱應該使用小駝峰式命名法(camelCase)，第一個單字以小寫字母開始；第二個單字的首字母大寫，例如：firstName、lastName。

欄位名稱在符合前綴定義的情形下應該加入前綴，以下是已經定義的前綴。

- **c** 用來計數的數字欄位
- **d** 浮點數的數字欄位
- **f** flags，並不會是固定的資料型別，大多用來代表狀態
- **dt** datetime 欄位
- **i** 整數
- **ix** 主鍵或外來鍵
- **n** 數字欄位，大多用來代表類型
- **s** 字串

----------

## 範例

### Table: Domain
Domain： 主域名資料

#### Columns

| 名稱         | 結構         | 可為空? | 描述                                                         |
| ------------ | ------------ | ------- | ------------------------------------------------------------ |
| ixDomain     | int(10)      |         | 編號 (Primary key, AutoNumber)                               |
| sDomainName  | varchar(253) |         | 主域名，僅能儲存ASCII編碼網址，UTF8編碼網址(中文網址)須經過轉換 |
| sEnv         | varchar(32)  | Yes     | 環境變數                                                     |
| sDescription | varchar(255) | Yes     | 描述                                                         |
| dtCreate     | timestamp    |         | 建立時間                                                     |
| dtUpdate     | timestamp    |         | 更新時間                                                     |


#### 索引
- **unique**: sDomainName
- **index**: sEnv,sDomainName
- **index**: sEnv

## 本專案table如下

### Table: Users
存放使用者資料

#### Columns

| 名稱         | 結構         | 是否有預設值? | 描述                                   |
| ------------ | ------------ | ------- | -------------------------------------- |
| ixUser       | int(10)      |         | 編號 (Primary key, AutoNumber)         |
| sUsername    | varchar(16)  |       | 使用者名稱                             |
| sPassword    | varchar(128) |       | 使用者密碼，經過Hash加密               |
| nStickerType | tinyint      |      | 頭像類型                               |
| fAdmin       | boolean      |      | 是否為管理員                           |
| dtCreate     | datetime     |      | 建立時間，第一次新增時自動帶入當前時間 |
| dtUpdate     | datetime     |      | 更新時間，資料修改時自動帶入當前時間   |

#### 索引
- **unique**: sUsername

### Table: Message
存放評論的資料

#### Columns

| 名稱         | 結構         | 是否有預設值? | 描述                                   |
| ------------ | ------------ | ------- | -------------------------------------- |
| ixMessage    | int(10)      |         | 編號 (Primary key, AutoNumber)|
| ixUser       | int          |         | 使用者 ID                     |
| sDescription | varchar(255) |         | 評論內容                       |
| dtCreate     | datetime     |         | 建立時間，第一次新增時自動帶入當前時間 |
| dtUpdate     | datetime     |         | 更新時間，資料修改時自動帶入當前時間   |

#### 索引
無

### Table: Post
存放留言主題資料

#### Columns

| 名稱         | 結構          | 是否有預設值? | 描述                                     |
| ------------ | ------------- | ------- | ---------------------------------------- |
| ixPost       | int(10)       |         | 編號 (Primary key, AutoNumber)           |
| ixUser       | int           |       | 使用者 ID                                |
| ixMessage    | varchar(4096) |       | 評論 ID                                  |
| sTopic       | varchar(128)  |       | 留言標題                                 |
| sDescription | varchar(255)  |       | 留言內容                                 |
| sLike        | varchar(4096) |         | 喜歡此留言的使用者，欄位裡為陣列格式內容 |
| dtCreate     | datetime      |       | 建立時間，第一次新增時自動帶入當前時間   |
| dtUpdate     | datetime      |       | 更新時間，資料修改時自動帶入當前時間     |

#### 索引
- **unique**: ixUser
