
<center>JoomGallery API Documentation</center>
<center>Version 2026.06.22</center><br>

## Joomgallery API (ready parts)

[//]: # (!INCLUDE "tableOfContent.md")
[//]: # (---)

# Bare minimum component / webservice API
Following is a description of a bare minimum component with matching minimum webservice API. 

## Component "com_secondhand"

Imagine a second hand books component with just the one books table and matching view. 

Table items
* id
* name
* author
* isbn
* Standard items like publish, created, ...

The idea is to use an external scan the ISBN of the book, fetch book data by other web API and use a J! web API to fill this table.
## Web Services API plugin plg_webservices_secondhand

### The general folder structure:

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
The file src->Extension->Secondhand.php will hold the API definition, whereas all other folders and files support the API event interception.

### Manifest file

```secondhand.xml```

```
You probably know the structure of a manifest file so following is a excerpt.
```xml
<?xml version="1.0" encoding="utf-8"?>
<extension type="plugin" group="webservices" method="upgrade">
  <name>plg_webservices_secondhand</name>
  <creationDate>2026.05.26</creationDate>
  ...
  <license>GNU General Public License version 2 or later; see LICENSE.txt</license>
  <description>PLG_WEBSERVICES_SECONDHAND_XML_DESCRIPTION</description>
  <namespace path="src">Bluebox\Plugin\WebServices\Secondhand</namespace>
  <files>
    <folder plugin="secondhand">services</folder>
    <folder>language</folder>
    <folder>services</folder>
    <folder>src</folder>
    <file>secondhand.xml</file>
  </files>
  
  ...
  <updateservers>...</updateservers>
</extension>
```
The group is 'webservices'.
Attention: the namespace contains 'WebSpaces' with an uppercase 'S' in te middle

### Language constants
In language->en_GB folder the usual two files are expected: 
- plg_webservices_secondhand.ini
- plg_webservices_secondhand.sys.ini
Which contains:
```ini
PLG_WEBSERVICES_SECONDHAND="webservice secondhand"
PLG_WEBSERVICES_SECONDHAND_XML_DESCRIPTION="webservice for component secondhand"
```
Please prefix 'PLG_WEBSERVICES' to the constant name SECONDHAND.
### service provider 

```services/provider.php```

Here the secondhand API definition class is instantiated and listed as a service provider.
```php
/**
 * @package   ....
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Extension\PluginInterface;  
use Joomla\CMS\Factory;  
use Joomla\CMS\Plugin\PluginHelper;  
use Joomla\DI\Container;  
use Joomla\DI\ServiceProviderInterface;  
use Bluebox\Plugin\WebServices\Secondhand\Extension\Secondhand;  
  
return new class () implements ServiceProviderInterface{  
    /**  
     * Registers the service provider with a DI container.    
     * @param   Container  $container  The DI container.  
     * @return  void  
     * @since   0.1.0     */    
    public function register(Container $container): void  
    {  
        $container->set(  
            PluginInterface::class,  
            $container->lazy(Secondhand::class, function (Container $container) {  
                $plugin     = new Secondhand(  
                    (array) PluginHelper::getPlugin('webservices', 'secondhand')  
                );  
                $plugin->setApplication(Factory::getApplication());  
  
                return $plugin;  
            })  
        );  
    }  
};
```
### Route extension class

```src\Extension\Secondhand.php```

```php
/**  
 * @package ... */  
namespace Bluebox\Plugin\WebServices\Secondhand\Extension;  
  
use Joomla\CMS\Event\Application\BeforeApiRouteEvent;  
use Joomla\CMS\Plugin\CMSPlugin;  
use Joomla\Event\SubscriberInterface;  
  
\defined('_JEXEC') or die;  
/**  
 * Joomla! Webservices Plugin webservice secondhand. 
 * @since  0.1.0 */
final class Secondhand extends CMSPlugin implements SubscriberInterface  
{  
    /**  
     * Returns an array of events this subscriber will listen to.     
     * @return  array  
     * @since   5.1.0     */    
    public static function getSubscribedEvents(): array  
    {  
        return ['onBeforeApiRoute' => 'onBeforeApiRoute',];  
    }  
  
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

**function getSubscribedEvents**
Here the function onBeforeApiRoute is assigned to the API event list

**function onBeforeApiRoute**
Here the magic happens with call to createCRUDERoutes. This is a function provided by Joomla which supports 'CRUD' (Create, Read, Update; Delete) API routes to call over HTTP

The first parameter ```php  'v1/secondhand/books' ``` tell the route which can be used in the call to the web page. 'v1' is used as the version, 'secondhand' is the component and 'books' are the items.
The second parameter is the controller to be used. The last is the internal config parameter which defines the actual component to be used and  and how 'public' the API is reachable.

This does not look like much but the matching 'controller', 'model' and view are supported in the component.

## Component "com_secondhand" API additions

We have to add code into the joomla root API folder. 
### Manifest

Section 'API' is added as separate branch parallel to ```<administrator>```

```xml
  <api>
    <files folder="api">
      <folder>src</folder>
    </files>
  </api>
```
It follows the standard form sections are handled. It just tells where to find the root of files ...
### The API sub folder structure:

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
Attention the API folder structure is similar to other component structures with the exception that the controller folder keeps all ```nnnController.php``` files without further subdirectories
The view code is always kept in a JsonapiView.php file in a named folder 

### Controller in API part

 ```BooksController.php```

```php
/**
 * @package   ....
 */

namespace Bluebox\Component\Secondhand\Api\Controller;

use Joomla\CMS\Filter\InputFilter;
use Joomla\CMS\Helper\TagsHelper;
use Joomla\CMS\MVC\Controller\ApiController;
use Joomla\Component\Fields\Administrator\Helper\FieldsHelper;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * The books controller
 *
 * @since  4.0.0
 */
class BooksController extends ApiController
{
    /**
     * The content type of the item.
     *
     * @var    string
     * @since  4.0.0
     */
    protected $contentType = 'books';

    /**
     * The default view for the display method.
     *
     * @var    string
     * @since  3.0
     */
    protected $default_view = 'books';


    // Implement other methods like read, update, delete as needed
}
```
Beside the namespace there is not much code.
```php
    protected $contentType = 'books';
    protected $default_view = 'books';
```

The Joomla API supporting code can live with just a with a content type and a default view. More explanation follows below. 

### View in API part

```JsonapiView.php```

```php
<?php

/**
 * @package   ....
 */

namespace Bluebox\Component\Secondhand\Api\View\Books;

use Joomla\CMS\Factory;
use Joomla\CMS\Helper\TagsHelper;
use Joomla\CMS\Language\Multilanguage;
use Joomla\CMS\MVC\View\JsonApiView as BaseApiView;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\Component\Fields\Administrator\Helper\FieldsHelper;
use Joomla\Registry\Registry;
use Secondhand\Component\Secondhand\Api\Helper\SecondhandHelper;
use Secondhand\Component\Secondhand\Api\Serializer\SecondhandSerializer;

\defined('_JEXEC') or die;

/**
 * The books view
 *
 * @since  4.0.0
 */
class JsonapiView extends BaseApiView
{
    /**
     * The fields to render item in the documents
     *
     * @var  array
     * @since  4.0.0
     */
    protected $fieldsToRenderItem = [
        'id',
        'title',
        'alias',
        'isbn',
        'description',

        'note',
        'published',
        'created', 'created_by',
        'modified', 'modified_by',
    ];

    /**
     * The fields to render items in the documents
     *
     * @var  array
     * @since  4.0.0
     */
    protected $fieldsToRenderList = [        
        'id',
        'title',
        'alias',
        'isbn',
        'description',

        'note',
        'published',
        'created', 'created_by',
        'modified', 'modified_by',
    ];

}
```

---

## API route definitions created

We are not much wiser now so what can be done with the code ?

The CRUDE definition is like following:


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
###
GET http://127.0.0.1/web_page/api/index.php/v1/secondhand/books
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

============================================================================
---

## What is going on behind the scene ?

### // Code of CRUDE 'tree' spread ??? 




Put is not available 

---

## API route definitions created

We are not much wiser now so what can be done with the code ?

The CRUDE definition is like following:


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
###
GET http://127.0.0.1/web_page/api/index.php/v1/secondhand/books
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

============================================================================
---

!INCLUDE ""
---

---

