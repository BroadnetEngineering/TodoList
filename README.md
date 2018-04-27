## Todo App by Chris Pitchford

Creating a "to-do" list application is a great way to guage facility in development. I've created several, from Backbone.js to iOS using UIKit and CoreData.

##### What To Expect

* This todo app requires PHP 7.1+ and MySQL/MariaDB with utf8mb4 support character set (gotta have those emojis).
  * I use composer installed globally to manage the dependencies. Download and install composer.phar into this directory and run `composer install -o`
  * I also use XAMPP but you can terminal in to this directory and run `php -S localhost:8080`
* A simple single-page application using Twig templates with clients-side MVC written in Backbone.js makes up the front end.
* The composer.json in this repo will copy a configuration file before running an install script that will import the schema. The configuration file will need DB credentials for creating the `todos` database and item table.
* There's a link for online help! 

##### Installation

* Clone this repository, and run `composer install -o`

##### How to Tell You Are Done

* If you have questions, please feel free to ask!
* I look forward to hearing from you.
