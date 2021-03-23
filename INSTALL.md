# Installation

#### 1. Clone this repo
#### 2. Install composer package dependencies:
```
$ composer install
```
#### 3. Copy `.env.example` to `.env` and modify it to fit your local setup
#### 4. Run migrations to setup local database
```
$ php artisan migrate
```
* A Google Oauth credentials are also included
#### 5. Run php web server
```
$ php artisan serve --port=8080
```
#### 6. Have fun with this mini app
