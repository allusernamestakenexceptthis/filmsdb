### データベース

これはドラフトドキュメントであり、今後変更される可能性があります。

エンジン：mysql

### テーブル:

```
users
    id
    username                         ユーザー名
    password                         パスワード
    name                             名前
    role        [admin, regular]     役割
    is_active   boolean              アクティブかどうか (ブール型)

movies
    id
    title                            タイトル
    description                      説明
    thumb                            サムネイル
    genres                           ジャンル
    is_active   boolean              アクティブかどうか (ブール型)

users_movies_favorites_rel
    user_id                          ユーザーID
    movie_id                         映画ID

```