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

Here the magic happens with call to createCRUDERoutes. This is a function provided by Joomla which supports 'CRUD' (Create, Read, Update; Delete) 
API routes to call over HTTP

The first parameter ```php  'v1/secondhand/books' ``` tell the route which can be used in the call to the web page. 'v1' 
is used as the version, 'secondhand' is the component and 'books' are the items.
The second parameter is the controller to be used. The last is the internal config parameter 
which defines the actual component to be used and how 'public' the API is reachable.

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

