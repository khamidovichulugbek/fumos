## Production use

Copy contents of the .env.example to the .env
```
cp .env.example .env
```

Create the necessary configuration files of php-fpm under directory - _docker/php-fpm/config_
```
nano docker/php-fpm/config/php.ini // put contents and save
nano docker/php-fpm/config/www.conf // put contents and save
```

Start php-fpm and redis containers 
```
docker compose -f prod.docker-compose.yml up -d --build
```
Note that you have to run command above each time when source code is updated.

