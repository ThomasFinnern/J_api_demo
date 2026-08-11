### API routes responses (json)

The results are json style and contain the links to actual call and next, previous and last page

#### GET book

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

---
#### GET books

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

---
#### Post book

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

---
#### Patch book trash ("published": -2)

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


---
## Pagination Joomla example with configuration (application)

### Links part of API response 

```json
{
    "links": {
        "self":"http://127.0.0.1/api_6x/api/index.php/v1/config/application
                ?page%5Boffset%5D=30&page%5Blimit%5D=30",
        "first": "http://127.0.0.1/api_6x/api/index.php/v1/config/application
                  ?page%5Boffset%5D=0&page%5Blimit%5D=30",
        "previous": "http://127.0.0.1/api_6x/api/index.php/v1/config/application
                     ?page%5Boffset%5D=0&page%5Blimit%5D=30",
        "next": "http://127.0.0.1/api_6x/api/index.php/v1/config/application
                 ?page%5Boffset%5D=60&page%5Blimit%5D=30",
        "last": "http://127.0.0.1/api_6x/api/index.php/v1/config/application
                 ?page%5Boffset%5D=90&page%5Blimit%5D=30"
    },
   
```

Add `?page[offset]=90&page[limit]=30"` to the route in the form shown in above response.  

The response contains links for called route (self), first-, previous- and last-page 

---

### Data part of API response

```json
{
  "links": {
    "self": "...",
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
        ...............             
    ],
    "meta": {
        "total-pages": 4
    }
}
```
The 'meta' data in th end of json tells about how many pages are available with this 'limit'.

