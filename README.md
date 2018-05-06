# slim3-starter : A fullstack repository for Slim 3

A Slim 3 starter with a clean directory structure, inspired from Laravel. 
This source code provides the most essential setup & libraries to help deal with most of the needs any web application has : 
- MVC architecture
- Clean dependency injection & autowiring system with the php-DI bridge for Slim 3
- Full form validation features with custom rules and errors
- Data persistance via ORM (Eloquent)
- Pagination
- Events and listeners/handlers based on the SPL library
- Twig as a template engine
- Email delivery system using the popular Swiftmailer library
- CSRF protection for web routes
- 403/404 errors catching with custom views
- Assets management with Webpack
- Handy debug() function using the symfony/vardumper library
- Application settings into a .env file
- Separate API routes & apidoc integration/documentation examples
- Caching with Redis
- Database seeding and migrations with Phinx 

### After cloning the project, type the following commands to build all the dependencies 

      composer install
     
### Recommended dev environnement : 
- PhpStorm + Vagrant homestead 

If you use homestead's Redis server, edit /etc/redis/redis.conf and fill the requirepass line with your own password.


### Upcoming :

Assets management with Webpack and npm libraries