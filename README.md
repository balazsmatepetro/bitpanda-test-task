# BitPanda Test Task

NOTE: I started to work on the UI earlier, that's why the project has a quite strange directory structure. Every API related code can be located under the 'api' directory. I didn't want to split up the whole project into two repositories.

### Run the following commands to install dependencies and start API:
```
cd api/
composer install
cp .env.example .env # Do not forget to provide an API key!
docker-compose up -d
```

### Run the following commands to install dependencies and run the application
at first make sure you're in the project root!
```
npm install
npm run serve
```

### Check the application
Open your favourite browser and navigate to http://localhost:8080/

### To run the API tests do the following:
```
docker exec -it api_slim_1 /bin/sh
php vendor/bin/phpunit 
```
