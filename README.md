## Spencer Dant's Todo App

Hello Broadnet! 

**This application is deployed at http://broadnet-todo-sd-1.herokuapp.com/.**

I built this application using Laravel and React. To avoid unnecessary overhead, I used a SQLite database structure, but configuring a MySQL or PostgreSQL database would also work without too much effort.

## Running Locally

From the project root folder, move to the `app` directory. 

Install PHP dependencies with `composer install` and run database migrations through Artisan with `php artisan migrate`. Then start the Laravel server with `php artisan serve`.

Install Node dependencies using `npm install` or `npm i` for shorthand. When running locally, use `npm run dev` (or if you intend to make changes `npm run watch`) to start Node and render the React app.

## Code

The bulk of the code in this fork is bootstrapped code from Laravel and Node configuration. These are some important files and directories.

* **app/Http/Controllers/TodoListController.php** is the controller class for the TodoList model. It receives HTTP requests from the user and routes data appropriately for saving and retrieving from the database and presents any errors that arise from the transaction.
* **app/Models/TodoList.php** is the TodoList model, which defines what a TodoList contains for each database transaction.
* **app/database/migrations/2022_01_28_205339_create_todo_lists_table.php** is the TodoList migration, which creates the todo_lists table and schema.
* **app/routes/api.php** is the API router. Depending on the method and format of the request that the API receives from the user, this will route the request to the correct method in the correct controller to ensure that the appropraite response is returned.
* **app/routes/web.php** is the view router. Given a particular method and format of a request from a user, this router will display the appropriate view to the user.

* **app/resources/views** contains two views, one of which is shown to the user upon loading the application where they can view, update, and delete their lists and another where they can create a new list.
* **app/resources/js/components** contains each of the React components that are rendered across the application. Interacting with each of these components allows a user to create, update, delete, and see lists.
* **app/resources/sass** contains the styles applied across the UI.
