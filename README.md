# To Do App (API)
## About
This is an To Do App API built with Laravel 8 (PHP Framework), Eloquent (ORM library) and MySQL.

## Features
- Laravel Passport Auth
- Middleware 
- CRUD Section
- CRUD Checklist
- Use Clean Architecture
- Use MVC Pattern
- Use Service Repository Pattern
![image](https://user-images.githubusercontent.com/67728406/179780153-a83ce4f1-9774-4d56-b973-77a890fa14ef.png)

## Database Design
![image](/database/design/TO-DO-APP%20DB.png)

## How to Run

Before you start the program, don't forget to do this on your terminal

```
composer update

composer install

move .env.example .env

Create mySQL db (ex dbname: to-do-app)

php artisan key:generate

php artisan passport:install --force

php artisan migrate:fresh --seed

php artisan serve
```

please make your .env on the root folder, you can use this example by changing on your preferences

```
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:SLuC3h/iHOt5J1TIwKs9rm7vg+ZeaEeFY4DLRhzdX/I=
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=to-do-app
DB_USERNAME=root
DB_PASSWORD= 
```

## API Documentation
https://documenter.getpostman.com/view/12534314/UzQyq38v
