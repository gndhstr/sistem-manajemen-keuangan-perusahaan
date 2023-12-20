<center>
<img src="https://cdn.discordapp.com/attachments/875383813411311627/1186903941825437726/SIMAKEUP.png?ex=6594f16f&is=65827c6f&hm=f7439e637dac6e5f2a6e0fef52eed277a0b0218b77b35afc8d167551bae03590&" alt="logo" width="250px">

# SIMAKEUP

Sistem Manajemen Keuangan Perusahaan

## Kelompok 3 - MSIB Gamelab.ID
</center>

## Setup

### 1. Clone Project

#### Using Git

You can clone this repository & rename it to your project

````
git clone https://github.com/gndhstr/sistem-manajemen-keuangan-perusahaan your-project-name
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
