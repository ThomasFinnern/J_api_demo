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
We defined what the json response should contain for list and item. 

```php
protected $fieldsToRenderList = ['id', 'title', 'alias', 'isbn', 'description', ....
protected $fieldsToRenderItem = ['id', 'title', 'alias', 'isbn', 'description', ....
```

This is it !  
The plugin and two wo files (`BooksController.php`, `JsonapiView.php`) enables CRUD ACCESS over the API of joomla
The joomla api base classes support is all what is needed to handle basic table data.

