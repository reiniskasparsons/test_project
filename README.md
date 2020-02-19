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

Laravel mix relies on node and npm. 
#####Installing Node
Before triggering Mix, you must first ensure that Node.js and NPM are installed on your machine.
```
node -v
npm -v
```
By default, Laravel Homestead includes everything you need; however, if you aren't using Vagrant, then you can easily install the latest version of Node and NPM using simple graphical installers from their [download page](https://nodejs.org/en/download/).
 
If you successfully installed everything please run the following command
``` npm install ``` from root directory of this project.

After the installation process run ```npm run production```
