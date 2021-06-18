## Laravel application: Upload XML file

### Server Requirements
* PHP >= 7.4 or
* Composer
* Docker

### Composer commands
Open Laravel project app/case-php and run composer install
```bash
cd app/case-php

composer install
```

### Start cotainers
```bash
docker-compose up -d
```


### Scripts
There is a shell script in the application container to run:
* Migrations;
* Start the queue and
* Run the tests
```bash
docker container exec -it name-or-id-container bash app.sh
```


### Routes
* Auth:
  * http://localhost:8000/login
  * http://localhost:8000/api/login
* index:
  * URL: http://localhost:8000 (GET)
* /xml-file:
  * URL: http://localhost:8000/xml-file (POST)
  * URL: http://localhost:8000/xml-file/{id} (GET)
  * URL: http://localhost:8000/xml-file (GET)
# /api/xml-file:
    * URL: http://localhost:8000/api/xml-file/{id} (GET)
    * URL: http://localhost:8000/api/xml-file (GET)
