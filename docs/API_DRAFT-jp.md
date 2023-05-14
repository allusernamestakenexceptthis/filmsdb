APIエンドポイント:

これはドラフト文書であり、今後変更される可能性があります。
より標準的なドキュメントが提供される予定です。

### 認証

```
POST /auth
    username
    password

    戻り値:
        200 OK
        400 リクエストが不正
        403 許可されていない
```

### 公開エンドポイント

```
GET /movies
    queries (クエリ):
        search={object}
            title,          タイトル
            description,    説明
            genres,         ジャンル
        
        page    ページネーション    　,  デフォルト: 1
        limit   ページネーション制限  ,  デフォルト: 20

    戻り値 
        200 OK
            data: データベースからのmoviesオブジェクト（is_activeなし）
            total: 合計ページ数
            page: 現在のページ
            limit: 現在の制限
        400 リクエストが不正

GET /moives/:id
    戻り値 
        200 OK
            data: データベースからのmoviesオブジェクト（is_activeなし）
        404 見つかりません
```

### ユーザーエンドポイント

```
GET /favorites
    戻り値
        200 OK
            data: データベースからのmoviesオブジェクト（is_activeなし）
        403 許可されていない

POST /favorites/:id
    戻り値
        200 OK
        403 許可されていない
        404 見つかりません

DELETE /favorites/:id
    戻り値
        200 OK
        403 許可されていない
        404 見つかりません

GET /user
    戻り値
        200 OK データベースからのユーザーオブジェクト（パスワードなし）
        403 許可されていない
```

### 管理者エンドポイント

```
POST /movies
    add movie
        title           必須                    タイトル
        description     必須                    説明
        thumb           任意                    サムネイル
        genres          任意                    ジャンル
        is_active       任意 デフォルト true     有効かどうか 
    戻り値
        200 OK
        403 許可されていない
        404 見つかりません

DELETE /movies/:id
    戻り値
        200 OK
        403 許可されていない
        404 見つかりません

PATCH /movies/:id
    movies 更新
    戻り値
        200 OK
        403 許可されていない
        404 見つかりません
```