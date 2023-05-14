<p align="center"><a href="#" target="_blank"><img src="public/images/filmsdb.svg" width="400" alt="Filmsdb title"></a></p>

[English](README.md) [日本語](README-jp.md)

[![Testing Filmsdb](https://github.com/monstar-lab-technical-challenge/ml-backend-test-allusernamestakenexceptthis/actions/workflows/laravel.yml/badge.svg)](https://github.com/monstar-lab-technical-challenge/ml-backend-test-allusernamestakenexceptthis/actions/workflows/laravel.yml)

# FilmsDB (下書き)

Filmsdbは、Laravelベースの映画データベースAPIです。クライアントは映画を検索し、詳細を取得し、認証し、お気に入りを追加および取得することができます。

## インストール

指示は変更されます。

### Step 1

Clone this repository
git clone https://github.com/monstar-lab-technical-challenge/ml-backend-test-allusernamestakenexceptthis.git

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

前提条件：
システムにDockerがインストールされている必要があります
(https://docs.docker.com/engine/install/)

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

Apply database changes

```bash
./vendor/bin/sail php artisan migrate
```

### step 4

Go to localhost

localhostにアクセス

## バージョン
0.0.1 下書き

## 使い方

更新予定

## ライセンス

決定中。

Laravelフレームワークは、[MITライセンス](https://opensource.org/licenses/MIT)のもとでオープンソースソフトウェアとしてライセンスされています。
