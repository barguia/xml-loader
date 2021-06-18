## Laravel application: Upload XML file

### Composer commands
```bash
composer install
```

### Artisan commands
```bash
php artisan migrate

# Start worker for Jobs
php artisan queue:work
```

### Tests
```bash
php artisan test
```

### Rotas
* index:
  * URL: http://localhost (GET)
* /xml-file:
  * URL: http://localhost/xml-file (POST)
  * URL: http://localhost/xml-file/{id} (GET)
  * URL: http://localhost/xml-file (GET)
