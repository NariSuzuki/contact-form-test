# contact-form-test

## 環境構築  

### Dockerビルド  
-git clone git@github.com:NariSuzuki/contact-form-test.git
-docker-compose up -d --build

### laravel環境構築  
-docker-compose exec php bash
-composer install
-cp .env.example .env ,環境変数を適宜変更
-php artisan key:generate
-php artisan migrate
-php artisan db:seed

##使用技術(実行環境)

##ER図
