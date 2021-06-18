#!/bin/bash

cd /var/www/html/case-php
php artisan migrate
php artisan queue:work
php artisan test
