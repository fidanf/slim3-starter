# slim3-starter : A fullstack repository for Slim 3

A Slim 3 starter with a clean directory structure, inspired from Laravel. 
This source code provides the most essential setup & libraries to help deal with most of the needs any web application has : 
- MVC architecture
- Full form validation features with custom rules and errors
- Events and listeners/handlers based on the SPL library
- Data persistance via ORM (Eloquent)
- Pagination using Eloquent
- Email delivery system using the popular Swiftmailer library
- CSRF protection for web routes
- 403/404 errors catching with custom views
- Assets management with Bower & Gulp
- Handy debug() function using symfony/vardumper library
- Clean dependency injection & autowiring system with the php-DI bridge for Slim 3
- Application settings into a .env file
- Separate API routes & apidoc integration/documentation examples
- Caching with Redis

### After cloning the project, type the following commands to build all the dependencies 

      composer install
      npm install
      bower install
      gulp
     
### Recommended dev environnement : 
- PhpStorm + Vagrant homestead or Wampserver
- Mailtrap.io 

If you use homestead's Redis server, edit /etc/redis/redis.conf and fill the requirepass line with your own password.

Feel free to use the dump.sql file in the root directory to try out the form on the homepage and the api routes.
