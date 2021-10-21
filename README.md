After cloning this repository make sure to install packages. Before running the install scripts remove the .lock files first. To install laravel packages run:

    composer install

and for vueJs run:

    yarn install

Then run the migrations and seeds on the server folder with this command:

    php artisan migrate:refresh --seed

Before running the migrations make sure to put the credentials to your database in .env file.

After installation, you need to start the servers. 

To setup laravel server run:
    php artisan serve

to setup the websocket server:
    php artisan websockets:serve

and to build and run the NuxtJs:
    yarn serve

the domain and the ports for server are used in nuxt-config.js file. If you decide to run the server on diffrent ports or domains, you will need to change them in nuxt-config.js as well.

The credentials for the default worker is:

    email: worker@site.com
    password: 123456

 and for the admin: 
 
    email: admin@site.com
    password: 123456


