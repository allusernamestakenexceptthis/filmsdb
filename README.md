<p align="center"><a href="#" target="_blank"><img src="public/images/filmsdb.svg" width="400" alt="Filmsdb title"></a></p>

[English](README.md) [日本語](README-jp.md) 

[![Testing Filmsdb](https://github.com/allusernamestakenexceptthis/filmsdb/actions/workflows/laravel.yml/badge.svg)](https://github.com/allusernamestakenexceptthis/filmsdb/actions/workflows/laravel.yml)

# FilmsDB

Demonstration project to show implementation of a REST api with openAPI standard using laravel.

Filmsdb is a laravel based films database api.  It allows clients to search for films, getting details, authenticate, add and get favorites. 

## Installation

### Step 1

Clone this repository
```
git clone https://github.com/allusernamestakenexceptthis/filmsdb.git
```

Copy .env.testing to .env

Unix/Mac
```bash
cp .env.testing .env
```

Windows:
```cmd
copy .env.testing .env
```

### Step 2

#### Install via docker (easy)

Prerequisites: 
You need docker to be installed on your system
https://docs.docker.com/engine/install/

Make sure docker service is running

cd into repo root

Start docker from docker compose file 

```bash
docker-compose up -d
```

Install dependencies

```bash
docker-compose exec filmsdb-app composer install --prefer-dist
```

Generate laravel key

```bash
docker-compose exec filmsdb-app php artisan key:generate
```

Restart docker container

```bash
docker-compose down
docker-compose up -d
```

#### Manual install:
You should ensure that your local machine has PHP 8.1 or 8.2 and Composer installed.
If you are using macOS, PHP and Composer can be installed via [Homebrew](https://brew.sh/). 
PHP installations instructions can be found here:

https://www.php.net/manual/en/install.php

Make sure to install php extensions see this:
https://stackoverflow.com/a/40816033/766985

Composer instructions:
https://getcomposer.org/doc/00-intro.md

```bash
composer install --prefer-dist

php artisan serve
```

Or run sail which needs docker running

Unix/Mac:

```bash
./vendor/bin/sail up
```

Windows:

```cmd
vendor\bin\sail up
```

Or install a web server such as nginx and point it to laravel

### Step 3

Generate Key, apply database migration and seed database with samples

```bash
./vendor/bin/sail php artisan key:generate
./vendor/bin/sail php artisan migrate
./vendor/bin/sail php artisan db:seed
```

### step 4

Go to http://localhost

## Version
1.0.0

## Usage

[See api documentation](docs/openapi.md)

When doing:

```
php artisan db:seed
```

You'll have a testing account with following credentials:
```
email: testuser@example.com
password: testpassword
```

No admin account is generated via seeding

Curl commands for convenience:
```
curl -X POST "localhost/get/token" -H "Accept: application/json; " -d '{"email":"testuser@example.com", "password":"testpassword"}'
curl -X GET "localhost/favorites" -H "Authorization: Bearer YOUR_TOKEN" -H "Accept:application/json"
curl -X POST "localhost/favorites/1" -H "Authorization: Bearer YOUR_TOKEN" -H "Accept:application/json"
curl -X DELETE "localhost/favorites/1" -H "Authorization: Bearer YOUR_TOKEN" -H "Accept:application/json"

curl "localhost/movies?search=genre:a&limit=3&page=2" -H "Accept:application/json"
curl "localhost/movies/1" -H "Accept:application/json"
curl "localhost/movies" -H "Accept:application/json"
```

curl commands for convenience:
```
curl -X POST "localhost/get/token" -H "Accept: application/json; " -d '{"email":"testuser@example.com", "password":"testpassword"}'
curl -X GET "localhost/favorites" -H "Authorization: Bearer YOUR_TOKEN" -H "Accept:application/json"
curl -X GET "localhost/favorites?search=genre:action" -H "Authorization: Bearer YOUR_TOKEN" -H "Accept:application/json"
curl -X POST "localhost/favorites/1" -H "Authorization: Bearer YOUR_TOKEN" -H "Accept:application/json"
curl -X DELETE "localhost/favorites/1" -H "Authorization: Bearer YOUR_TOKEN" -H "Accept:application/json"

curl "localhost/movies?search=genre:romance&limit=3&page=2" -H "Accept:application/json"
curl "localhost/movies/1" -H "Accept:application/json"
curl "localhost/movies" -H "Accept:application/json"
```

There is a rate limiting on getting token. 1 attempt per minute and 5 per hour for same email

## Suggestion
- Instead of using query string for search, it's better to use json request body. it can accomodate more request
- Might be better to add v1/ as url prefix for api endpoints.  In future we might completely rework the api and to avoid mixing with public web.

## TODO
- Move genre to new relational table that acts as tag for movies, so we can add more keys like director, year of release:
```
    movies_tags
        tag_id
        tag_name

    movies_tags_rel
        movie_id
        tag_id
        tag_value
```

## License

To be determined.

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
