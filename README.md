# TrackingAppBe


## Development server

1. Run docker-compose up
2. Create database and do migrations:
   


    docker container exec -ti php-fpm php /app/bin/console doctrine:database:create 

    docker container exec -ti php-fpm php /app/bin/console doctrine:migration:migrate -n
   

3. App frontend will be available on http://127.0.0.1:4000/ , backend on http://127.0.0.1:8080/ 

## Run tests
    pin/phpunit tests/Unit