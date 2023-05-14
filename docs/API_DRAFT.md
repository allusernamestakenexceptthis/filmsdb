Endpoints:

This is a draft document and may change going forward.  
Better standard documentation will be supplied

### Authentication

```
POST /auth
    email
    password

    returns:
        200 OK
        400 bad request
        403 unauthorized
```

### Public endpoints

```
GET /movies
    queries:
        search={object}
            title,
            description,
            genre,
        
        page    pagination      ,  default: 1
        limit   pagination limit,  default: 20

    returns 
        200 OK
            data: movie object from database without is_active
            total: total pages
            page: current page
            limit: current limit
        400 bad request

GET /moives/:id
    returns 
        200 OK
            data: movie object from database without is_active
        404 not found
```

### User endpoints

```
GET /favorites
    returns
        200 OK
            data: movie object from database without is_active
        401 unauthorized

POST /favorites/:id
    returns
        200 OK
        401 unauthorized
        404 not found

DELETE /favorites/:id
    returns
        200 OK
        401 unauthorized
        404 not found

GET /user
    returns
        200 OK user object from database without password
        401 unauthorized
```

### Admin endpoints

```
POST /movies
    add movie
        title           required
        description     required
        thumb           optional
        genres          optional
        is_active       optional default true
    returns
        200 OK
        401 unauthorized
        404 not found

DELETE /movies/:id
    returns
        200 OK
        401 unauthorized
        404 not found

PATCH /movies/:id
    updates movie
    returns
        200 OK
        401 unauthorized
        404 not found
```