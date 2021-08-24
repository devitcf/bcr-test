## Bcr-test

###### _This project is created with Laravel 8 which requires PHP 7.3_

1. Get and install the latest composer into web directory

   http://getcomposer.org/


2. Run Composer update to update and check if any uninstalled PHP modules

   `php composer.phar update`


3. Run Composer install to install dependencies

   `php composer.phar install`


4. Copy .env.example to .env and edit it to fit needs

   `cp .env.example .env`

   `nano .env`


5. Generate a unique key in config/app.php for the project

   `php artisan key:generate`


6. Edit config/app.php to fit needs

   `nano config/app.php`


7. Insert TABLES into DB

   `php artisan migrate`


8. Insert records into DB

   `php artisan db:seed`
