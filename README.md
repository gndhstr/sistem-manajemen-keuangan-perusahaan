# Laravel AdminLTE

This is a ready to use AdminLTE template for Laravel 5.8

## What's Inside

1. AdminLTE v3.0.0-beta

    Only /dist folder is included. You can find the templates in view/layouts and view/auth.

2. Laravel 5.8

    Default from laravel, with changes:

    - route /starter -> to preview how the dashboard looks like (disable it when in productions)
    - disabled Auth route /verify & /reset and no blade template applied for them
    - change /home to /dashboard (the controller too)

## Setup

### 1. Clone Project

#### Using Git

You can clone this repository & rename it to your project

````
git clone https://github.com/rpahlevy/laravel-adminlte3 your-project-name
````

#### Without Git

Click that green button on right top corner (Clone or download) -> Download ZIP
Extract it and rename to your project name

### 2. Install Dependencies

Change composer.json to your liking first (detail of your project). Make sure you have composer installed, then cd to the project folder and do the following

````
composer install
````

### 3. Setup .env

Clone .env.example or just rename it to .env then fill in the details & don't forget to setup your DB.

Then generate app key by running:

````
php artisan key:generate
````

### 4. Migrate DB

If your web needs Auth (who don't?) migrate the default DB from Laravel. Still on the project, run:

````
php artisan migrate
````

### 5. Serve Your Web

Serve locally using php built in and visit localhost:8000/starter

````
php artisan serve
````

To get into the dashboard go to /register first.