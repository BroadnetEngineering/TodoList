## Todo App by Chris Pitchford

Creating a "to-do" list application is a great way to gauge knowledge, approaches and potential in a developer/programmer. I've created several examples, from Backbone.js to iOS using UIKit and CoreData. This is the first time I added PHP/MySQL to this particular mix, although I've primarily worked in that domain for fifteen years...

I had to pass on implementing the CSRF as well as other security measures. I've restricted the HTTP methods to just GET & POST instead of using the full suite of verbs that are available. 

##### What To Expect

* This todo app requires PHP 7.1+ and MySQL/MariaDB with utf8mb4 character set support (gotta have those emojis).
  * I use composer installed globally to manage the dependencies. 
  * If you need to, download and install composer.phar into this directory and run `php composer.phar install -o`
  * I also use XAMPP but you can terminal in to this directory and run `php -S localhost:8080`
* A simple single-page application using Twig templates with clients-side MVC written in Backbone.js makes up the front end.
* The composer.json in this repo will copy a configuration file before running an install script that will import the schema. The configuration file will need DB credentials for creating the `todos` database and item table.
* There's a link for online help! 

##### Installation

* Clone this repository, and run `composer install -o`
* Navigate to a browser and enter the URI, e.g. `http://todo.local/`

##### How to Tell You Are Done

* Credit where credit is due: 
 * Slim was the easiest way to get routes and Dependency Injection containers for PDO and logging https://www.slimframework.com
 * I took two incompatible concepts from http://todomvc.com and mashed them together in Backbone.js
* If you have questions, please feel free to ask!
* I look forward to hearing from you.
