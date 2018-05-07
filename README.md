# slim3-starter : A fullstack repository for Slim 3

A Slim 3 starter with a clean directory structure, inspired from Laravel. 
This source code provides the most essential setup & libraries to help deal with most of the needs any web application has : 

- MVC architecture
- Clean dependency injection & autowiring system with the [php-DI bridge for Slim 3](http://php-di.org/doc/frameworks/slim.html)
- Full form validation features with custom rules and errors (respect/validation library)
- Data persistance via [Eloquent ORM](https://laravel.com/docs/5.6/eloquent)
- Pagination with Eloquent's paginator
- Events and listeners/handlers system based on the SPL library
- [Twig](https://twig.symfony.com) as a template engine
- Mailable classes using the popular [SwiftMailer](https://swiftmailer.symfony.com) library
- CSRF protection for web routes
- Custom 403/404 errors
- Handy debug() function using the symfony/vardumper library
- Config variables laying in a simple .env file
- Caching with Redis (predis/predis)
- Integrated logging with [Monolog](https://github.com/Seldaek/monolog)
- JSON formatting with [Fractal](https://fractal.thephpleague.com/)
- Database seeding and migrations with [Phinx](https://phinx.org/) 

### Once you have downloaded the project, enter the following commands : 

Fill in the .env file with your own variables. Set APP_ENV=dev to enable debugging and disable Twig caching.

      composer install
      ./vendor/bin/phinx migrate
      ./vendor/bin/phinx seed:run

### Using SQLITE instead of mysql

In your .env file, set DB\_DRIVER=sqlite and DB\_NAME=<absolute\_path\_to\_sqlite> .

I recommend creating the .sqlite file within the /storage directory.

### Recommended dev environnement : 
- PhpStorm + Vagrant homestead 

If you are using homestead's Redis server, remember to edit /etc/redis/redis.conf and fill the _requirepass_ line with your own password.

### Upcoming :

Assets management with Webpack and npm libraries

Custom console commands