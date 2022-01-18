# Broadnet Todo List
## Corey Cinkosky &bull; 01/17/2022 &bull; [Todo Demo](http://todo.redzoneassault.com/)
This is running on my own MVC Framework: **CinkoMVC**
 * CinkoMVC [Github](https://github.com/ccinkosky/CinkoMVC)
 * CinkoMVC [Demo](https://mvc.redzoneassault.com)

## Install
Load the app up and make sure that the website domain is pointing to the **public** folder.

I used a MySQL (type: "mysql") database, but you should be able to use any database supported by PDO. You can set the database credentials in the **config.json** file.

You'll need to create the table **todo_list**, SQL to create the table is in **todo_list.sql**.

Once that is setup, the app should work as expected.

## Main Scripts
The main code for this app is here:
 * **public/components/TodoList.js** : This is the React Component that makes up the user interface. It sends requests to the server to add, remove, update and complete todo list items.
 * **controllers/TodoController.php** : This is the controller that receivs the POST requests from the user interface and determines which actions should be taken on the **todo_list** table in the database.
 * **models/TodoListModel.php** : This is the model that actually communicates with the database. It has the functions to add, remove, update and complete records in the **todo_list** table.
