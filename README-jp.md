<p align="center"><a href="#" target="_blank"><img src="public/images/filmsdb.svg" width="400" alt="Filmsdb title"></a></p>

[English](README.md) [日本語](README-jp.md)

[![Testing Filmsdb](https://github.com/monstar-lab-technical-challenge/ml-backend-test-allusernamestakenexceptthis/actions/workflows/laravel.yml/badge.svg)](https://github.com/monstar-lab-technical-challenge/ml-backend-test-allusernamestakenexceptthis/actions/workflows/laravel.yml)

# FilmsDB

Filmsdbは、Laravelベースの映画データベースAPIです。クライアントは映画を検索し、詳細を取得し、認証し、お気に入りを追加および取得することができます。

## インストール

### Step 1

このリポジトリをクローンします。
```
git clone https://github.com/monstar-lab-technical-challenge/ml-backend-test-allusernamestakenexceptthis.git
```

.env.testingを.envにコピーします。

Unix/Mac
```bash
cp .env.testing .env
```

Windows:
```cmd
copy .env.testing .env
```

### Step 2

#### Dockerを使用してインストール（簡単）

前提条件：
システムにDockerがインストールされている必要があります
https://docs.docker.com/engine/install/

Dockerサービスが稼働していることを確認してください

リポジトリのルートに移動します

Docker ComposeファイルからDockerを起動します

```bash
docker-compose up -d
```

依存関係のインストール

```bash
docker-compose exec filmsdb-app composer install --prefer-dist
```

Laravelキーを生成する

```bash
docker-compose exec filmsdb-app php artisan key:generate
```

Dockerコンテナーを再起動する

```bash
docker-compose down
docker-compose up -d
```

#### 手動でのインストール：
ローカルマシンにPHP 8.1または8.2とComposerがインストールされていることを確認してください。
macOSを使用している場合、PHPとComposerは[Homebrew](https://brew.sh/)を経由してインストールできます。
PHPのインストール手順はこちらで見つけることができます：

https://www.php.net/manual/en/install.php

PHPの拡張機能のインストールを忘れないでください。参考までにこちらを見てください：
https://stackoverflow.com/a/40816033/766985

Composerの指示：
https://getcomposer.org/doc/00-intro.md

```bash
composer install --prefer-dist

php artisan serve
```

または、Dockerが動作している必要があるsailを実行します

Unix/Mac:

```bash
./vendor/bin/sail up
```

Windows:

```cmd
vendor\bin\sail up
```

または、nginxのようなWebサーバーをインストールし、それをLaravelに向けて設定します

### Step 3

キーを生成し、データベースのマイグレーションを適用し、サンプルデータでデータベースをシードします

```bash
./vendor/bin/sail php artisan key:generate
./vendor/bin/sail php artisan migrate
./vendor/bin/sail php artisan db:seed
```

### step 4

以下のURLにアクセスしてください：http://localhost

## Version
1.0.0

## Usage

[See api documentation](docs/openapi.md)

以下のシーディングを実行すると:

```
php artisan db:seed
```

次の認証情報を持つテストアカウントが作成されます：
```
email: testuser@example.com
password: testpassword
```

シーディングによる管理者アカウントは生成されません

便宜上のCurlコマンド：
```
curl -X POST "localhost/get/token" -H "Accept: application/json; " -d '{"email":"testuser@example.com", "password":"testpassword"}'
curl -X GET "localhost/favorites" -H "Authorization: Bearer YOUR_TOKEN" -H "Accept:application/json"
curl -X POST "localhost/favorites/1" -H "Authorization: Bearer YOUR_TOKEN" -H "Accept:application/json"
curl -X DELETE "localhost/favorites/1" -H "Authorization: Bearer YOUR_TOKEN" -H "Accept:application/json"

curl "localhost/movies?search=genre:a&limit=3&page=2" -H "Accept:application/json"
curl "localhost/movies/1" -H "Accept:application/json"
curl "localhost/movies" -H "Accept:application/json"
```

ウェブ上で、このアプリはこちらでバージョン1.0.0として公開されました：
[https://filmsdb.japanji.pro/](https://filmsdb.japanji.pro/)

curl commands for convenience:
```
curl -X POST "localhost/get/token" -H "Accept: application/json; " -d '{"email":"testuser@example.com", "password":"testpassword"}'
curl -X GET "localhost/favorites" -H "Authorization: Bearer YOUR_TOKEN" -H "Accept:application/json"
curl -X POST "localhost/favorites/1" -H "Authorization: Bearer YOUR_TOKEN" -H "Accept:application/json"
curl -X GET "localhost/favorites?search=genre:action" -H "Authorization: Bearer YOUR_TOKEN" -H "Accept:application/json"
curl -X DELETE "localhost/favorites/1" -H "Authorization: Bearer YOUR_TOKEN" -H "Accept:application/json"

curl "localhost/movies?search=genre:a&limit=3&page=2" -H "Accept:application/json"
curl "localhost/movies/1" -H "Accept:application/json"
curl "localhost/movies" -H "Accept:application/json"
```

トークンの取得にはレート制限があります。同じメールアドレスでは、1分に1回、1時間に5回までの試行です。

## 提案
- 検索にクエリ文字列を使用する代わりに、JSONリクエストボディを使用する方が良いでしょう。これにより、より多くのリクエストに対応することができます。
- APIエンドポイントのURLプレフィックスとしてv1/を追加すると良いかもしれません。将来的にAPIを完全に再設計する可能性があり、パブリックWebと混在させないためです。

## TODO
- ジャンルを新しいリレーショナルテーブルに移動し、それを映画のタグとして機能させる。これにより、監督や公開年などのキーを追加することができます：
```
    movies_tags
        tag_id
        tag_name

    movies_tags_rel
        movie_id
        tag_id
        tag_value
```

## Thanks

プロジェクトを見て評価していただき、ありがとうございます


## ライセンス

決定中。

Laravelフレームワークは、[MITライセンス](https://opensource.org/licenses/MIT)のもとでオープンソースソフトウェアとしてライセンスされています。
