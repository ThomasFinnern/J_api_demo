## API route definitions created

The CRUDE definitions result in following API routes:

| Command | &nbsp;Route                     | &nbsp;Comment                              |
|:--------|:--------------------------------|:-------------------------------------------| 
| GET     | &nbsp;`v1/secondhand/books`     | &nbsp;lists all books with variables       |
| GET     | &nbsp;`v1/secondhand/books/:id` | &nbsp;lists variables of book              |
| POST    | &nbsp;`v1/secondhand/books`     | &nbsp;creates new book with data           |
| PATCH   | &nbsp;`v1/secondhand/books/:id` | &nbsp;writes parameters into selected book |
| DELETE  | &nbsp;`v1/secondhand/books/:id` | &nbsp;deletes selected book                |

---
## GET v1/secondhand/books (lists all books with variables)</h2>

**Parameters:** None

**Response:**

| http code | content-type                      | response                                                                                                            |
|-----------|-----------------------------------|---------------------------------------------------------------------------------------------------------------------|
| `200`     | `application/json; charset=UTF-8` | ```json {"type": "books","id": "2","attributes": {"id": 2,"title": "Why We Sleep","alias": "why-we-sleep",, ...}``` |

**Example CURL:**

```batch
curl -s --show-error 
  -X GET "http://127.0.0.1/web_page/api/index.php/v1/secondhand/books" 
  -H "Content-Type: application/json" -H "X-Joomla-Token:  ..."
```
**Example http:**

```http
###
GET http://127.0.0.1/web_page/api/index.php/v1/secondhand/books
Accept: application/vnd.api+json
Content-Type: application/json
X-Joomla-Token:  ...
```

---

## GET v1/secondhand/books/:id

**Parameters:**

None

**Responses:**

| http code     | content-type                      | response                                                                                                                    |
|---------------|-----------------------------------|-----------------------------------------------------------------------------------------------------------------------------|
| `200`         | `application/json;charset=UTF-8`        | ```json {"type": "books","id": "2","attributes": {"id": 2,"title": "Why We Sleep","alias": "why-we-sleep",, ... }``` |

**Example CURL:**

```batch
curl -s --show-error  
   -X GET "http://127.0.0.1/web_page/api/index.php/v1/secondhand/books/1" 
   -H "Content-Type: application/json" -H "X-Joomla-Token:  ..."
```

**Example http:**

```http
###
GET http://127.0.0.1/web_page/api/index.php/v1/secondhand/books/1
Accept: application/vnd.api+json
Content-Type: application/json
X-Joomla-Token:  ...
```

---
## POST v1/secondhand/books (part 1)

**Parameters:**

| name                | type    | data type    | description |
|---------------------|---------|--------------|-------------|
| all book parameters | %       | Json, string |             | 


**Responses:**

| http code     | content-type                      | response                                                                                                                   |
|---------------|-----------------------------------|----------------------------------------------------------------------------------------------------------------------------|
| `200`         | `application/json;charset=UTF-8`  | ```json {"type": "books", "id": "2", "attributes": { "id": 1, "asset_id": 105, "title": "Global Configuration", ... }``` |

**Example cURL:**

```shell
curl -s --show-error  
   -X POST "http://127.0.0.1/web_page/api/index.php/v1/secondhand/books" 
   -d "{\"title\":\"My book\",\"isbn\":\"12-3456-78-90\",\"author\":\"john breeze\",\"description\":\"The next book i write\",\"published\":1}"  
   -H "Content-Type: application/json" -H "X-Joomla-Token:  ..."
```

---
## POST v1/secondhand/books (part 2)

**Example http:**

```http
###
POST http://127.0.0.1/web_page/api/index.php/v1/secondhand/books
Accept: application/vnd.api+json
Content-Type: application/json
X-Joomla-Token: 

{
   "title": "My book",
   "isbn": "12-3456-78-90",
   "author": "john breeze",
   "description": "The next book i write",
   "published": 1
}
```

---
## PATCH v1/secondhand/books/:id (part 1)

**Parameters:**

| name  |  type     | data type               | description                                                           |
|-------|-----------|-------------------------|-----------------------------------------------------------------------|
| title |  %     | string   |  | 
| isbn  |  %     | string   |  | 
| ...   |  %     | string   |   |

**Responses:**

| http code     | content-type                      | response                                                            |
|---------------|-----------------------------------|---------------------------------------------------------------------|
| `200`         | `application/json;charset=UTF-8`        | ```json {"type": "books", "id": "2", "attributes": { "id": 1, "asset_id": 105, "title": "Global Configuration", ... }``` |

**Example cURL:**

```shell
curl -s --show-error  
   -X PATCH "http://127.0.0.1/web_page/api/index.php/v1/secondhand/1/books" 
   -d "{\"published\":-2,\"isbn\":\"1234-4567-8890\"} "  
   -H "Content-Type: application/json" -H "X-Joomla-Token:  ..."
```

---
## PATCH v1/secondhand/books/:id (part 2)

**Example http:**

```http
###
PATCH http://127.0.0.1/web_page/api/index.php/v1/secondhand/books/1
Accept: application/vnd.api+json
Content-Type: application/json
X-Joomla-Token: 

{
    "published": -2,
    "isbn": "1234-4567-8890",
}
```
---
## DELETE secondhand/books/:id

Just a reminder: Delete needs trash state before. Please use patch with "published": -2, (see above)

**Parameters:**

None

**Responses:**

None

**Example cURL:**

```shell
curl -s --show-error  
  -X DELETE  "http://127.0.0.1/web_page/api/index.php/v1/secondhand/books/2"
  -H "Content-Type: application/json" -H "X-Joomla-Token:  ..."
```

**Example http:**

```http
###
DELETE http://127.0.0.1/web_page/api/index.php/v1/secondhand/books/2
Accept: application/vnd.api+json
Content-Type: application/json
X-Joomla-Token: 
```
