## Hi Broadnet!
#### This is Timur, and it was fun building this project! I have some additional notes below that I would like you to be aware of. 
- Here I attempted to recreate a simple MVC model for handling requests with purpose of showing evidence of understanding the concept
- A basic idea of a core, where most of the framework lives and bootstrap of the application is initiated
- Implementation of the interfaces with possible scalability in mind and keeping uniform shape for all future models if this is to grow
- Configuration file to make changing credentials depending on the environment easy
- Here I am utilizing PHP PDO object which provides security against SQL injections if implemented correctly
- You may need to install it on your server, if that's the case hope it will not be too much trouble 
- Note that this project does not account for error handling due to limitations in time
- For the project to work correctly you need to setup your server webroot to the 'public' directory of the project
- Since you guys are using Bootstrap I implemented front-end using this framework
- Please update Core/Config.php file with your database credentials
- Please import db.sql into your database. This is mysqldump
- MySQL dump contains additional information on the SQL version and Ubuntu versions. (Both latest version as of today 05/05/2020)