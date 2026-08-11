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

## empty page, should not be together with artefacts

leer ooooooooooooooooooooooooooooooooooooooo


