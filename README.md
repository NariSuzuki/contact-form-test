# contact-form-test

## 環境構築  

### Dockerビルド  
- git clone git@github.com:NariSuzuki/contact-form-test.git
- docker-compose up -d --build

### laravel環境構築 
- docker-compose exec php bash
- composer install
- cp .env.example .env ,環境変数を適宜変更
- php artisan key:generate
- php artisan migrate
- php artisan db:seed

##開発環境
- お問合せ画面：http://localhost/
- ユーザー登録：http://localhost/register
- phpMyAdmin：http://localhost:8080/

##使用技術(実行環境)
Laravel:8.83.8
PHP:8.1.33
mysql:8.0.26
nginx:1.21.1

##ER図
<img width="800" height="470" alt="Image" src="https://github.com/user-attachments/assets/76290e53-b8a9-4bf0-874f-7677eeb713b7" />

##テーブル仕様書
<img width="759" height="519" alt="Image" src="https://github.com/user-attachments/assets/36ce1e34-bb96-44f4-b4f0-218ed14c4faa" />
<img width="497" height="310" alt="Image" src="https://github.com/user-attachments/assets/7d741453-a87b-4529-a91e-f5934af7d707" />
<img width="491" height="239" alt="Image" src="https://github.com/user-attachments/assets/93cc93de-61a9-4e63-b2fa-e25044897191" />


