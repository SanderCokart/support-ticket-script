# Support Ticket System
## Sponsors
* [Script.nl](https://www.script.nl) - At Script, people with autism work on their IT skills. From working on your own project, to building software in a group. At Script we look at what works best for you and how you can work on your future as a software developer.
## Description
This is a simple support ticket system that allows users to create tickets and admins to respond to them.
This project is a work in progress and is not yet complete.

## Installation
### Local
```shell
composer install && pnpm install && php artisan key:generate && php artisan migrate --seed
```

### Production
```shell
composer install --no-dev --autoload-optimize && pnpm install -P && php artisan key:generate && php artisan storage:link && php artisan migrate --seed && php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan optimize
```

## Environment Variables (`.env`)
* VITE_API_URL=http://127.0.0.1:8000/api/v1

## Todo
* [ ] Forgot password
* [ ] Reset password
* [ ] Additional testing
* [ ] Prune (delete those which are not associated) categories
