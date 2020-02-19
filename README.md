# README for test project

If there is a problem with setup of this project plese check the steps necessary to 
setup the project.

## Table of Contents

- [Installation](#installation)

## Installation

Download the project from GIT.

Setup the .env file, you can do it by copying the .env.example file t o .env.

In .env file it is crucial to fill these variables so that migrations can be run
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

After this be sure to run `php artisan migrate` from project root directory. If something goes wrong, check the database connection.
