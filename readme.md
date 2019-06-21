# 專案說明文件

laravel 5.5

### 系統需求

 - PHP >= 7.2
 
 - Nginx

 - MySQL >= 5.6.4

### 安裝 composer.json 所設定的檔案

```
composer install --prefer-dist
```

### 建立 .env 環境檔案

```
cp .env.example .env
```

### 產生應用程式金鑰

```
php artisan key:generate
```

### 設定環境變數

`.env` 環境檔案設定資訊如下

#### 設定資料庫資訊

```
DB_DATABASE=DB_Name
DB_USERNAME=username
DB_PASSWORD=password
```

### 產生資料表結構

```
php artisan migrate
```

### 開啟 bootstrap cache 目錄權限

```
chmod -R 777 bootstrap/cache/
```

### 開啟 storage 目錄權限

```
chmod -R 777 storage/
```
