# Important UPDATE:

I've published a fresher, improved version of this project under the name of [slim3-flex](https://github.com/fidanzaEPSI/slim3-flex). If you like clean, beautiful code, you certainly wanna check it out! :)

## slim3-starter : A fullstack boilerplate for Slim 3

A Slim 3 starter project with a clean directory structure, inspired from Laravel. 
This source code provides the most essential setup & libraries to help deal with most of the needs any web application has. 

## Features :

- MVC architecture
- Clean dependency injection & autowiring system with the [php-DI bridge for Slim 3](http://php-di.org/doc/frameworks/slim.html)
- Config variables laying in a simple .env file
- [Twig](https://twig.symfony.com) as a template engine
- Full form validation features with custom rules and errors (See : [respect/validation](https://github.com/Respect/Validation) library)
- Data persistance via [Eloquent ORM](https://laravel.com/docs/5.6/eloquent)
- Pagination with Eloquent's paginator
- Events and listeners/handlers classes based on the SPL library
- Mailable classes using the popular [SwiftMailer](https://swiftmailer.symfony.com) library
- CSRF protection for web routes
- Custom 403/404 errors
- Handy debug() function using the symfony/vardumper library
- SQL query caching with [Redis](https://github.com/nrk/predis)
- Integrated logging with [Monolog](https://github.com/Seldaek/monolog)
- JSON formatting with [Fractal](https://fractal.thephpleague.com/)
- Database seeding and migrations with [Phinx](https://phinx.org/) 

### Setting up : 

Once you've downloaded or cloned the project, fill the variables in the .env file.
Set APP_ENV=dev to enable debugging and disable Twig caching at the same time.
Then run :

      composer install
      ./vendor/bin/phinx migrate
      ./vendor/bin/phinx seed:run

### Using Sqlite instead of MySQL

In your .env file, set DB\_DRIVER=sqlite and DB\_NAME=<absolute\_path\_to\_sqlite> .

I recommend creating the .sqlite file within the _/storage_ directory.

### Recommended dev environment : 
- PhpStorm + Vagrant homestead 

If you are using homestead's Redis server, remember to edit /etc/redis/redis.conf and fill the _requirepass_ line with your own password.

