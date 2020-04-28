## Todo App

As a potential employee of Broadnet we would like to be able to gauge your programming skill and how you approach a development task.

##### What We Expect

* Your todo app must have a PHP server-side component.
* The frontend portion of your app is entirely freeform.
* If you use a database to store app data, it must be MySQL and you must provide a SQL script to create the schema as part of your pull request.
* Your app must support creating, reading, updating, and deleting of todo list items.

##### Tips

* Quality over quantity!
* Do what you do everyday, we want to see you're development style.
* Feel free to think outside the box!

##### What to Do When You Are Done

* Assuming you forked the repository, send us a pull request.
* Alternatively, zip up your submission and email us.


##### How to Run 
run `docker-compose up` within the root of the project directory. 

Once the containers are built the site will be accessible at http://localhost

##### What I did
* Using vanilla PHP for the backend. 
* session to store the tasks temporarily.
* alpinejs and tailwindcss for the frontend interactivity and styling.

##### How would I improve this?
* use Parcel.js and PurgeCSS to only use what we need and to get access to the @apply to create cleaner css classes using tailwind.  
* Add a Database for to allow for persisting tasks past the 2hr session limit.

