# Todo App
This is my submission for the BroadNet Todo App code test. It is built entirely using PHP with no JavaScript. It
is also built on top of Laravel to make a lot of things quicker. Bootstrap is here to give a pleasing (if not
overused) responsive layout. I could have done this about 30 different ways, but this was the quickest.

## Setup
1. Checkout the branch
2. Run `composer install` (visit getcomposer.org if you don't have composer)
3. Run `cp .env.example .env`
4. Edit the `.env` file with your relevant database credentials
5. Using the mysql command line (or the gui of your choice), create a `utf-8` database named `todo_list` (or the value you entered for `DB_DATABASE` in `.env`)
6. Run `php artisan migrate` (this will create the necessary DB schema)
7. Run `php artisan serve` (alternatively you can set up a vHost entry; if you do this, make sure that the entry allows for .htaccess overrides)
8. Visit `http://localhost:8000`

## Styles Generation
The minified CSS file is included in the `public/css/app.css` file. However, this file is generated via the SCSS
files located in `resources/assets/sass`. To regenerate the files:

1. Run `npm install` (make sure you have NPM installed)
2. Run `npm run dev` to regenerate the `app.css` file