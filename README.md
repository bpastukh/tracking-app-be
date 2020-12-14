# TrackingAppBe

## Clone repository and install dependencies
Clone this repo (e.g. git clone git@github.com:bpastukh/tracking-app-be.git)

Install dependencies


    composer install

## Run development server

Run docker services
   
   
    docker-compose up

Create database and execute migrations
   


    docker container exec -ti php-fpm php /app/bin/console doctrine:database:create 

    docker container exec -ti php-fpm php /app/bin/console doctrine:migration:migrate -n
   

App frontend will be available on http://127.0.0.1:4000/ , backend on http://127.0.0.1:8080/ 

To override defaults copy create .env.local file

Documentation is available on http://127.0.0.1:8080/api/doc

## Run tests
    vendor/bin/phpunit tests/Unit


    vendor/bin/codecept run functional