## 1. Get and install the latest composer into web directory
http://getcomposer.org/

## 2. Run Composer install to install dependencies
`php composer.phar install`

## 3. Copy .env.example to .env and edit it to fit needs
`cp .env.example .env`

`nano .env`

## 4. Generate a unique key in config/app.php for the project
`php artisan key:generate`

## 5. Edit config/app.php to fit needs
`nano config/app.php`

## 6. Insert TABLES into DB
`php artisan migrate`

## 7. Insert records into DB
`php artisan db:seed`
