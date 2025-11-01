#!/bin/sh
php artisan key:generate --force
php artisan migrate --force
php artisan serve --host=0.0.0.0 --port=$PORT

git add .
git commit -m "Add Procfile and start.sh for Railway"
git push
