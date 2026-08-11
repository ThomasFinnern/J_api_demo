## Web Services API plugin plg_webservices_secondhand

### The general base component folder structure:

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

Here the magic happens with call to createCRUDERoutes. This is a function provided by Joomla which supports 'CRUD' (Create, Read, Update; Delete)
API routes to call over HTTP
---

## Route extension class 'src\Extension\Secondhand.php'

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
**createCRUDERoutes**

* The first parameter ```php  'v1/secondhand/books' ``` tells the route which can be 
used in the call to the web page. 'v1' is used as the version, 
'secondhand' is the component and 'books' is the table.  
* The second parameter is the controller file to be used.  
* The last is the internal config parameter which defines the actual component 
and how 'public' the API is reachable.

This does not look like much but with just defining the resulting component API Json views
table items can be created, read, changed and deleted.   






