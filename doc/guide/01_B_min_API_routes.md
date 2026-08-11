## API route definitions created

We are not much wiser now so what can be done with the code ?

The CRUDE definitions result in following API routes:

<xdetails>
 <summary><code>GET v1/secondhand/books</code> <code><b>/</b></code> <code>(lists all books with variables)</code></summary>

##### Parameters

> None

##### Responses

> | http code     | content-type                      | response                                                              |
> |---------------|-----------------------------------|-----------------------------------------------------------------------|
> | `200`         | `application/json;charset=UTF-8`  | ```json {"type": "books","id": "2","attributes": {"id": 2,"title": "Why We Sleep","alias": "why-we-sleep",, ...}``` |

##### Example CURL

> ```batch
> curl -s --show-error  -X GET "http://127.0.0.1/web_page/api/index.php/v1/secondhand/books" -H "Content-Type: application/json" -H "X-Joomla-Token:  ..."
> ```

##### Example http

> ```http
> ###
> GET http://127.0.0.1/web_page/api/index.php/v1/secondhand/books
> Accept: application/vnd.api+json
> Content-Type: application/json
> X-Joomla-Token:  ...
> ```

</xdetails>

<xdetails>
 <summary><code>GET v1/secondhand/books/:id</code> <code><b>/</b></code> <code>(lists variables of book)</code></summary>

##### Parameters

> None

##### Responses

> | http code     | content-type                      | response                                                                                                                    |
> |---------------|-----------------------------------|-----------------------------------------------------------------------------------------------------------------------------|
> | `200`         | `application/json;charset=UTF-8`        | ```json {"type": "books","id": "2","attributes": {"id": 2,"title": "Why We Sleep","alias": "why-we-sleep",, ... }``` |

##### Example CURL

> ```batch
> curl -s --show-error  -X GET "http://127.0.0.1/web_page/api/index.php/v1/secondhand/books/1" -H "Content-Type: application/json" -H "X-Joomla-Token:  ..."
> ```

##### Example http

> ```http
> ###
> GET http://127.0.0.1/web_page/api/index.php/v1/secondhand/books/1
> Accept: application/vnd.api+json
> Content-Type: application/json
> X-Joomla-Token:  ...
> ```
</xdetails>

<xdetails>
 <summary><code>POST secondhand/books</code> <code><b>/</b></code> <code>(creates new book with data)</code></summary>

##### Parameters

> | name                | type    | data type    | description |
> |---------------------|---------|--------------|-------------|
> | all book parameters | %       | Json, string |             | 


##### Responses

> | http code     | content-type                      | response                                                                                                                   |
> |---------------|-----------------------------------|----------------------------------------------------------------------------------------------------------------------------|
> | `200`         | `application/json;charset=UTF-8`  | ```json {"type": "books", "id": "2", "attributes": { "id": 1, "asset_id": 105, "title": "Global Configuration", ... }``` |

##### Example cURL

> ```shell
> curl -s --show-error  -X POST "http://127.0.0.1/web_page/api/index.php/v1/secondhand/books" -d "{\"title\":\"My book\",\"isbn\":\"12-3456-78-90\",\"author\":\"john breeze\",\"description\":\"The next book i write\",\"published\":1}"  -H "Content-Type: application/json" -H "X-Joomla-Token:  ..."
> ```

##### Example http

> ```http
> ###
> POST http://127.0.0.1/web_page/api/index.php/v1/secondhand/books
> Accept: application/vnd.api+json
> Content-Type: application/json
> X-Joomla-Token: 
> 
> {
>    "title": "My book",
>    "isbn": "12-3456-78-90",
>    "author": "john breeze",
>    "description": "The next book i write",
>    "published": 1
> }
> ```

</xdetails>

<xdetails>
 <summary><code>PATCH secondhand/books/:id</code> <code><b>/</b></code> <code>(writes parameters into selected book)</code></summary>

##### Parameters

> | name  |  type     | data type               | description                                                           |
> |-------|-----------|-------------------------|-----------------------------------------------------------------------|
> | title |  %     | string   |  | 
> | isbn  |  %     | string   |  | 
> | ...   |  %     | string   |   |

##### Responses

> | http code     | content-type                      | response                                                            |
> |---------------|-----------------------------------|---------------------------------------------------------------------|
> | `200`         | `application/json;charset=UTF-8`        | ```json {"type": "books", "id": "2", "attributes": { "id": 1, "asset_id": 105, "title": "Global Configuration", ... }``` |

##### Example cURL

> ```shell
> curl -s --show-error  -X PATCH "http://127.0.0.1/web_page/api/index.php/v1/secondhand/1/books" -d "{\"published\":-2,\"isbn\":\"1234-4567-8890\"} "  -H "Content-Type: application/json" -H "X-Joomla-Token:  ..."
> ```

##### Example http

> ```http
> ###
> PATCH http://127.0.0.1/web_page/api/index.php/v1/secondhand/books/1
> Accept: application/vnd.api+json
> Content-Type: application/json
> X-Joomla-Token: 
> 
> {
>     "published": -2,
>     "isbn": "1234-4567-8890",
> }
> ```
</xdetails>

<xdetails>
 <summary><code>DELETE secondhand/books/:id</code> <code><b>/</b></code> <code>(deletes selected book)</code></summary>

Just a reminder: Delete needs trash state before. use patch with "published": -2, (see above)

##### Parameters

> None

##### Responses

> None

##### Example cURL

> ```shell
> curl -s --show-error  -X DELETE  "http://127.0.0.1/web_page/api/index.php/v1/secondhand/books/2" -H "Content-Type: application/json" -H "X-Joomla-Token:  ..."
> ```

##### Example http

> ```http
> ###
> DELETE http://127.0.0.1/web_page/api/index.php/v1/secondhand/books/2
> Accept: application/vnd.api+json
> Content-Type: application/json
> X-Joomla-Token: 
> ```
</xdetails>


### Calling API routes results

The results are json style and contain the links to actual call and next, previous and last page

#### get book

```json
{
  "links": {
    "self": "http://127.0.0.1/api_6x/api/index.php/v1/secondhand/books/1"
  },
  "data": {
    "type": "books",
    "id": "1",
    "attributes": {
      "id": 1,
      "title": "test 01",
      "alias": "test-01",
      "isbn": "1234567890",
      "description": "",
      "published": 1,
      "created": "2026-05-24 17:23:19",
      "created_by": 775,
      "modified": "2026-05-24 17:42:09",
      "modified_by": 775,
      "note": ""
    }
  }
}
```

#### get books

```json
{
    "links": {
        "self": "http://127.0.0.1/api_6x/api/index.php/v1/secondhand/books"
    },
    "data": [
        {
            "type": "books",
            "id": "2",
            "attributes": {
                "id": 2,
                "title": "Why We Sleep",
                "alias": "why-we-sleep",
                "isbn": "da1b2048-cec2-4127-950e-35bc4b3ee181",
                "description": "Sleep is one of the most important aspects of our life, health and longevity and yet it is increasingly neglected in twenty-first-century society, with devastating consequences- every major disease in the developed world - Alzheimer - s, cancer, obesity, diabetes - has very strong links to deficient sleep. In this book, the first of its kind written by a scientific expert, Professor Matthew Walker explores twenty years of cutting-edge research to solve the mystery of why sleep matters. Looking at creatures from across the animal kingdom as well as major human studies, Why We Sleep delves in to everything from what really happens in our brains and bodies when we dream to how caffeine and alcohol affect sleep and why our sleep patterns change across a lifetime, transforming our appreciation of the extraordinary phenomenon that safeguards our existence.",
                "published": 1,
                "created": "2026-05-27 09:53:06",
                "created_by": 776,
                "modified": "2026-05-27 09:53:06",
                "modified_by": 776,
                "note": ""
            }
        },
        {
            "type": "books",
            "id": "3",
            "attributes": {
                "id": 3,
                "title": "My book",
                "alias": "my-book",
                "isbn": "12-3456-78-90",
                "description": "The next book i write",
                "published": 1,
                "created": "2026-06-23 11:40:16",
                "created_by": 776,
                "modified": "2026-06-23 11:40:16",
                "modified_by": 776,
                "note": ""
            }
        }
    ],
    "meta": {
        "total-pages": 1
    }
}
```

#### post book

```json
{
    "links": {
        "self": "http://127.0.0.1/api_6x/api/index.php/v1/secondhand/books"
    },
    "data": {
        "type": "books",
        "id": "3",
        "attributes": {
            "id": 3,
            "title": "My book",
            "alias": "my-book",
            "isbn": "12-3456-78-90",
            "description": "The next book i write",
            "published": 1,
            "created": "2026-06-23 11:40:16",
            "created_by": 776,
            "modified": "2026-06-23 11:40:16",
            "modified_by": 776,
            "note": ""
        }
    }
}
```


#### patch book trash ("published": -2)

```json
{
    "links": {
        "self": "http://127.0.0.1/api_6x/api/index.php/v1/secondhand/books/4"
    },
    "data": {
        "type": "books",
        "id": "4",
        "attributes": {
            "id": 4,
            "title": "My book",
            "alias": "my-book-7",
            "isbn": "12-3456-78-90",
            "description": "The next book i write",
            "published": -2,
            "created": "2026-05-26 16:25:09",
            "created_by": 776,
            "modified": "2026-05-26 16:41:17",
            "modified_by": 776,
            "note": ""
        }
    }
}
```

#### Example with Joomla configuration (application) using poge offset 

Add ?page[offset]=90&page[limit]=30' to the route in the form hsown in the response. 
The response contains to the route links for called (self), first , previous and last  

```json
{
    "links": {
        "self": "http://127.0.0.1/api_6x/api/index.php/v1/config/application?page%5Boffset%5D=30&page%5Blimit%5D=30",
        "first": "http://127.0.0.1/api_6x/api/index.php/v1/config/application?page%5Boffset%5D=0&page%5Blimit%5D=30",
        "previous": "http://127.0.0.1/api_6x/api/index.php/v1/config/application?page%5Boffset%5D=0&page%5Blimit%5D=30",
        "next": "http://127.0.0.1/api_6x/api/index.php/v1/config/application?page%5Boffset%5D=60&page%5Blimit%5D=30",
        "last": "http://127.0.0.1/api_6x/api/index.php/v1/config/application?page%5Boffset%5D=90&page%5Blimit%5D=30"
    },
    "data": [
        {
            "type": "application",
            "id": "247",
            "attributes": {
                "helpurl": "https://help.joomla.org/proxy?keyref=Help{major}{minor}:{keyref}&lang={langcode}",
                "id": 247
            }
        },
        {
            "type": "application",
            "id": "247",
            "attributes": {
                "offset": "UTC",
                "id": 247
            }
        },
        {
            "type": "application",
            "id": "247",
            "attributes": {
                "cors": false,
                "id": 247
            }
        },
        {
            "type": "application",
            "id": "247",
            "attributes": {
                "mailer": "mail",
                "id": 247
            }
        },
        {
            "type": "application",
            "id": "247",
            "attributes": {
                "sendmail": "/usr/sbin/sendmail",
                "id": 247
            }
        },
        {
            "type": "application",
            "id": "247",
            "attributes": {
                "smtpauth": false,
                "id": 247
            }
        },
        
        ...............        
        
    ],
    "meta": {
        "total-pages": 4
    }
}
```
