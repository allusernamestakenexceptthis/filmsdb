### Database

This is a draft document and may change going forward.  

Engine: mysql

### Tables:

```
users
    id
    username
    password
    name        
    role        [admin, user]
    is_active   boolean
    created_at

movies
    id
    title
    description
    thumb
    genre
    is_active   boolean
    created_at

users_movies_favorites_rel
    user_id
    movie_id
```

TODO:
move genres to tags, and add more endpoints
```
movies_tags
    tag_id
    tag_name

movies_tags_rel
    movie_id
    tag_id
    tag_value
```