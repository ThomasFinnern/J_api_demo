<!-- h2><center>API demo with minimum component</center></h2><center>Version 2026.07.22</center -->
# Web Services API: Implementation for components

![logo10](./assets/icons/left_right.start.svg) 

## Dipping the toe into the sea of joomla webserverices API coding for components

* Minimum component API code
* Standard use of the component controller/modules
* Patch the data before reaching component controller/modules
* Prepare the JSON response




---
[//]: # (background-image: url&#40;./assets/images/backgroundStructure_02.jpg&#41;)

# Thomas Finnern InsideTheMachine.de

## 2008: First Joomla! web page  
* [Vollomondlauf-hechingen.de]() using RSGallery2 as my gallery for images 
* Full moon fun run, no race, once per month, running up the hill
![full_moon_run](./assets/images/vollmond.png "Full moon run")

## 2013: RSGallery2 Missing support in 2013 
* Founder with breakdown, rsgallery2.net URL captured for money (1000$), 
one person maintaining Forum - server and 1 Person upgrading from J! 2.5 to 3.x   

## 2014 Start of coding
* Start of transfer code from 3x to 4x 
* Learning the ropes, first code in PHP ....
* First joomla! Day / JCamp essen

---
![rsgallery2LogoText](./assets/icons/RSG2_logoText.svg "RSGallery2 logo with text")

## 2015 Transfer code to GitHub 
* 2015: First release of RSG2 J4x
* Website RSGallery2.org
* RSG2 J4 state OK in 2019

## 2019++ Transition code to J5x
* Big ideas but failed due to j code expections 
  * Gid instead of id, ignored categories ....

## 2025 First version for J5x

* **Current status**: It works "just barely"; needs still a lot of development 

## 2024++ support for JoomGallery Friends

* Code for site upload
* Code for Web services API  

![joomgalleryLogo](./assets/icons/logo-joomgalleryfriendskleiner.svg "JoomGallery Friends logo")

---
![thomasfinnern](./assets/images/finnern-thomas.jpg "Thomas Finnern")

# Hobby

![joggendielangsamen](./assets/images/joggenDieLangsamen_2.jpg "Die Langsamen")
![joggingZellerHorn](./assets/images/joggingZellerHorn.jpg "Hohenzollern Zeller Horn")
![joggensanfranzisco](./assets/images/joggingSanFranzisco.jpg "Joggen in Franzisco")

---

# Work

1999 - 2027 work at Walter Machines walter-machines.com

![erodingmachine](./assets/images/machine-raptor2.png "Walter Grinding/EDM machine")
![producedtools](./assets/images/toolsShapes.jpg "Shapes of produced tools")
![erodingmachine](./assets/images/toolInOperation.jpg "Image of the tool during the EDM process")  
EDM: Electrical Discharge Machining
---
# Bare minimum component / webservice API

![logo10](./assets/icons/left_right.start.svg)
[//]: # (??? icon / image ?)

The following pages introduce an example of a bare minimum component with matching minimum webservice API.

## Component "com_secondhand"

Imagine a second hand books component with just the one books table and matching view.

Table items
* id
* name
* author
* isbn
* Standard items like publish, created, ...

The idea is to use an external scan of the ISBN of the book, fetch book 
data by other web API and use a J! web API to fill this table.

---
## Location of code and a more detailed description

In this presentation, we are shortening the code. 
A complete version can be viewed at on my Github account:
https://github.com/ThomasFinnern/J_api_demo/tree/main/code

Also "Bare minimum" description mark down file
https://github.com/ThomasFinnern/J_api_demo/blob/main/doc/guide/01__API_min_code_doc.md

This has lead to a article ??? series in [guide.joomla.org ???](guide.joomla.org ???). 
It may be a still PR though [???](???)

.footnote[ <\> ]
---
# Web Services API plugin plg_webservices_secondhand

## The general base component folder structure:

```
plg_secondhand  
├─── language  
│      └─── en-GB  
│              ├─── plg_content_secondhand.ini  
│              └─── plg_content_secondhand.sys.ini  
├─── services  
│      └─── provider.php  
├─── src  
│      └─── Extension  
│              └─── Secondhand.php  
└─── secondhand.xml
```
The general folder structure is similar to each other API base structure.
The file src->Extension->Secondhand.php will hold the API definition, 
whereas all other folders and files support the API event interception.

---
## Manifest file 'secondhand.xml'

Following is an excerpt as structure is known.
```xml
<?xml version="1.0" encoding="utf-8"?>
<extension type="plugin" group="webservices" method="upgrade">
  <name>plg_webservices_secondhand</name>
  ...
  <description>PLG_WEBSERVICES_SECONDHAND_XML_DESCRIPTION</description>
  <namespace path="src">Bluebox\Plugin\WebServices\Secondhand</namespace>
  <files>
    <folder plugin="secondhand">services</folder>
    <folder>language</folder>
    <folder>services</folder>
    <folder>src</folder>
    <file>secondhand.xml</file>
  </files>
 
  <api>
    <files folder="api">
      <folder>src</folder>
    </files>
  </api>
  ...
</extension>
```

The group is 'webservices'.  
Attention: The namespace contains 'WebSpaces' with an uppercase 'S' in the middle
---
## API component code location

The Manifest file gets an additional section to include the component source code for the API part.  

```xml
  <api>
    <files folder="api">
      <folder>src</folder>
    </files>
  </api>
```
---
## Service provider 'services/provider.php'

Here the 'secondhand' API definition class is instantiated and listed as a service provider.

```php
use Joomla\...  

use Bluebox\Plugin\WebServices\Secondhand\Extension\Secondhand;  
  
return new class () implements ServiceProviderInterface{  
    /* Registers the service provider with a DI container.    
     * @param   Container  $container  The DI container.  
     * @return  void */    
    public function register(Container $container): void  
    {  
        $container->set(  
            PluginInterface::class,  
            $container->lazy(Secondhand::class, function (Container $container){  
                $plugin = new Secondhand(  
                    (array) PluginHelper::getPlugin('webservices', 'secondhand')  
                );  
                $plugin->setApplication(Factory::getApplication());  
    
                return $plugin;  
            })  
        );  
    }  
};
```
---
## Route extension class 'src\Extension\Secondhand.php'

### part one

```php
/* Joomla! Webservices Plugin webservice secondhand. */
final class Secondhand extends CMSPlugin implements SubscriberInterface  
{  
    /* Returns an array of events this subscriber will listen to  */    
    public static function getSubscribedEvents(): array  
    {  
        return ['onBeforeApiRoute' => 'onBeforeApiRoute',];  
    }  
  
    ....
```
**function getSubscribedEvents**

Here the function onBeforeApiRoute is assigned to the API event list

---

## Route extension class 'src\Extension\Secondhand.php'

### part two

```php
    /**  
     * Registers com_secondhand API's routes in the application     
     * @param   BeforeApiRouteEvent  $event  The event object  
     * @return  void  
     * @since   4.0.0     */    
    public function onBeforeApiRoute(BeforeApiRouteEvent $event): void  
    {  
        $router = $event->getRouter();  
  
        $defaults = ['component' => 'com_secondhand'];  
        // ToDo: Remove when tests finished, enables access without token  
        // $getDefaults = array_merge(['public' => true], $defaults);  
        $getDefaults = array_merge(['public' => false], $defaults);  
  
        $router->createCRUDRoutes(  
            'v1/secondhand/books',  
            'books',  
            $getDefaults  
        );  
    }  
}
```
**function onBeforeApiRoute**

Here the magic happens with call to createCRUDRoutes. This is a function provided by Joomla which supports 'CRUD' (Create, Read, Update; Delete)
API routes to call over HTTP
---

## Route extension class 'src\\Extension\\Secondhand.php'

### Where the magic is applied

```php
        $defaults = ['component' => 'com_secondhand'];  
        // ToDo: Remove when tests finished, enables access without token  
        // $getDefaults = array_merge(['public' => true], $defaults);  
        $getDefaults = array_merge(['public' => false], $defaults);  
  
        $router->createCRUDRoutes(  
            'v1/secondhand/books',  
            'books',  
            $getDefaults  
        );  
    }  
}
```
**createCRUDRoutes**

* The first parameter `v1/secondhand/books` tells the route which can be 
used in the call to the web page. 'v1' is used as the version, 
'secondhand' is the component and 'books' is the table.  
* The second parameter `books` is the controller file to be used.  
* The last is the internal config parameter which defines the actual component 
and how 'public' the API is reachable.

This does not look like much but with just defining the resulting component API JSON views. 
The table items can be created, read, changed and deleted.
---
# Minimum component API additions
## API part of the component 'com_secondhand'

* We have to insert section API into manifest
* We have to add code into the joomla root API folder. 

#### The API sub folder structure:

From the root of the joomla web page
```
api\components\com_secondhand\  
├─── src  
     ├─── Controller  
     │    └─── BooksController.php  
     └─── View  
          └─── Books  
               └─── JsonapiView.php  
```
Attention: The API folder structure is similar to other component 
structures with the exception that the controller folder keeps all 
`nnnController.php` files without further subdirectories.  
The view code is always kept in a JsonapiView.php file in a named folder 
---

## Controller in API part 'BooksController.php'

```php
namespace Bluebox\Component\Secondhand\Api\Controller;

use ...

class BooksController extends ApiController
{
    // The content type of the item. 
    protected $contentType = 'books';

    // The default view for the display method.
    protected $default_view = 'books';

    // Implement other methods like read, update, delete as needed
    ...
}
```

Within the minimal controller only two variables need to be defined, as the controller class inherits from ApiController.
* The `$contentType` tells which component model to use 
* The `$default_view` tells which view does render the collected data.

---

## View in API part 'JsonapiView.php'

Inside the minimum controller there are only two variables to implement as the JsonapiView class inherits from BaseApiView.
 
* The `$fieldsToRenderItem` tells which variables of the table to show for single item view
* The `$fieldsToRenderList` tells which view does render the collected data.

```php
    protected $fieldsToRenderItem = []
        'id',
        'title',
        'alias',
        'isbn',
        'description', 'note', 'published', 'created', 
        'created_by', 'modified', 'modified_by',
    ];
```
```php
   protected $fieldsToRenderList = [        
        'id',
        'title',
        'alias',
        'isbn',
        'description', 'note', 'published', 'created', 
        'created_by', 'modified', 'modified_by',
    ];
```

---

## Resumee:

We defined the API router interface.
```php
$router->createCRUDRoutes(  
    'v1/secondhand/books',  
    'books',  
    $getDefaults  
);  
```
We defined what the JSON response should contain for list and item. 

```php
protected $fieldsToRenderList = ['id', 'title', 'alias', 'isbn', 'description', ....
protected $fieldsToRenderItem = ['id', 'title', 'alias', 'isbn', 'description', ....
```

This is it !  
The plugin and two wo files (`BooksController.php`, `JsonapiView.php`) enables CRUD ACCESS over the API of joomla
The joomla api base classes support is all what is needed to handle basic table data.

---
## API route definitions created

The CRUD definitions result in following API routes:

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
---
## API routes responses (json)

The results are JSON style and contain the links to actual call and next, previous and last page

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
#### Patch book: after trash ("published": -2)

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
The 'meta' data in th end of JSON tells about how many pages are available with this 'limit'.

---
# Behind the scenes

## What is going on behind the scenes ?

**Reminder:**

We have defined the component's API router interface as follows:

```php
$router->createCRUDRoutes(  
    'v1/secondhand/books',  
    'books',  
    $getDefaults  
);  
```

* The first parameter `v1/secondhand/books` tells the route which can be
  used in the call to the web page. 'v1' is used as the version,
  'secondhand' is the component and 'books' is the table.
* The second parameter `books` is the controller file to be used.
* The last `getDefaults` is the internal config parameter which defines the actual component
  and how 'public' the API is reachable. 

The $defaults variable contains a config array and looks either like  
   `php $defaults = ['component' => 'com_secondhand', 'public' => false];`  
or  
   `php $defaults = ['component' => 'com_secondhand', 'public' => true];` 

If **'public' => true** is set, no X-Token is checked and everyone can 
access this entry. This should only be set for tests

---

## Function createCRUDRoutes 

The joomla createCRUDRoutes function organizes it as following:

```php
public function createCRUDRoutes($baseName, $controller, $defaults = [], $publicGets = false)
{
   $getDefaults = array_merge(['public' => $publicGets], $defaults);

   $routes = [
     new Route(['GET'], $baseName, $controller . '.displayList', [], $getDefaults),
     new Route(['GET'], $baseName . '/:id', $controller . '.displayItem', 
               ['id' => '(\d+)'], $getDefaults),
     new Route(['POST'], $baseName, $controller . '.add', [], $defaults),
     new Route(['PATCH'], $baseName . '/:id', $controller . '.edit', 
               ['id' => '(\d+)'], $defaults),
     new Route(['DELETE'], $baseName . '/:id', $controller . '.delete', 
               ['id' => '(\d+)'], $defaults),
   ];

   $this->addRoutes($routes);
}
```

The new Route function is given the command, the route ($baseName) and the config ($defaults).    
The last parameter for the 'createCRUDRoutes' function is a second entry for the public flag and is merged into the default config.

---

# Route functions parameters

```php
new Route(['GET'], $baseName, $controller . '.displayList', [], $getDefaults),
```
'displaylist' tells the function inside the given controller which will be called.

```php
new Route(['GET'], $baseName . '/:id', $controller . '.displayItem', 
               ['id' => '(\d+)'], $getDefaults),
```
Handling if (table) 'id'.  

Info: These route functions can be also called direct where we define the getCRUDRoutes


---

??? Additional single route description ?
---

????
## createCRUDRoutes function

The joomla API code provides now all the CRUD entries.
This leads to following API entry points

```
Get    http://127.0.0.1/web_page/api/index.php/v1/secondhand/books 
Get    http://127.0.0.1/web_page/api/index.php/v1/secondhand/books/:id 
Post   http://127.0.0.1/web_page/api/index.php/v1/secondhand/books { params }
Patch  http://127.0.0.1/web_page/api/index.php/v1/secondhand/books/:id { params }
Delete http://127.0.0.1/web_page/api/index.php/v1/secondhand/books/:id
```
Please note that the "PUT" route is unavailable and is therefore crossed out in the next graph.

---
## Internal routes created by createCRUDRoutes

The following graph shows the path of possible API route inside the joomla code.
The **webservice plugin** of the component calls the J! API function **createCRUDRoutes**
and gives it the base route definition and the component controller base.

<img src="http://localhost:8000/lecture/assets/images/mermaid/ResultUrlRequets_1.png" />  

---
## Input to 'createCRUDRoutes' 

The joomla createCRUDRoutes function organizes it as following:

```php
 public function createCRUDRoutes($baseName, $controller, $defaults = [], $publicGets = false)
    {
        $getDefaults = array_merge(['public' => $publicGets], $defaults);

        $routes = [
            new Route(['GET'], $baseName, $controller . '.displayList', [], $getDefaults),
            new Route(['GET'], $baseName . '/:id', $controller . '.displayItem', ['id' => '(\d+)'], $getDefaults),
            new Route(['POST'], $baseName, $controller . '.add', [], $defaults),
            new Route(['PATCH'], $baseName . '/:id', $controller . '.edit', ['id' => '(\d+)'], $defaults),
            new Route(['DELETE'], $baseName . '/:id', $controller . '.delete', ['id' => '(\d+)'], $defaults),
        ];

        $this->addRoutes($routes);
    }
```

The Route function is the standard function to define a route. It needs the 'task' (method), the route starting with "v1/..." and the controller.function.
Additional in the $default parameter the component name and the 'public' variables are expected.
---
That could have been written instead as

```php
new Route(['GET'],    'v1/secondhand/books',     'books.displayList', [], $getDefaults),
new Route(['GET'],    'v1/secondhand/books/:id', 'books.displayItem', ['id' => '(\d+)'], $getDefaults),
new Route(['POST'],   'v1/secondhand/books',     'books.add',         [], $defaults),
new Route(['PATCH'],  'v1/secondhand/books/:id', 'books.edit',        ['id' => '(\d+)'], $defaults),
new Route(['DELETE'], 'v1/secondhand/books/:id', 'books.delete',      ['id' => '(\d+)'], $defaults),
```
There is a named check for route 'variables' example 'v1/secondhand/books/**2**'.  
The naming had two aspects: ```['id' => '(\d+)']```
1) The name can later be accessed as standard input parameter 'name'->'value' $input->getInt('id')
2) Behind is a regex expression which shall check for valid/invalid characters
   There may be other types too: ```['component_name' => '([A-Za-z0-9_]+)']```

TIP: By the way the JSON parameters given in the request can be fetched by
```php $data = json_decode($this->input->json->getRaw(), true); ``` or ```php $srcFilename  = $this->input->json->getString('filename');```


---

## empty page, should not be together with artefacts

leer ooooooooooooooooooooooooooooooooooooooo


---

[//]: # (---)

[//]: # (!INCLUDE "0x.WhatsMissing.md")
[//]: # (---)
[//]: # (!INCLUDE "tableOfContent.md")
[//]: # (---)

background-image: url(./assets/images/backgroundStructure_02.jpg)

## Artefacts with no meaning from here on ...

<img src="http://localhost:8000/lecture/assets/icons/left_right.start.svg" width="100" height="100" alt="logo10" />  

[//]: # (![logo10](http://localhost:8000/icons/left_right.start.svg)  )    
[//]: # (![logo2]&#40;../../icons/left_right.start.svg"&#41;)  

Test 02 ============  
![logo1](./assets/icons/left_right.start.svg) (1) ![logo2](/lecture/assets/icons/left_right.start.svg) (2)  
![logo5](/assets/icons/left_right.start.svg) (5) ![logo6](lecture/assets/icons/left_right.start.svg) (6)  
![logo7](/lecture/assets/icons/left_right.start.svg) (7)  
===========
test after
===========

---

# Whaaatt ????

.left-column[
![thomasfinnern](./assets/images/finnern-thomas.jpg "Thomas Finnern")
]
.right-column[
# 1999 - 2027 work at Walter Machines
walter-machines.com
]
.left-column[
![erodingmachine](./assets/images/machine-raptor2.png "Walter Grinding/EDM machine")
EDM: Electrical Discharge Machining
]





