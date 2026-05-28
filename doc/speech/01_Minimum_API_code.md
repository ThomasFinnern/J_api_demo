# Bare minimum component / webservice API
Following is a description of a bare minimum component with matching minimum webservice API. 
## Component "com_secondhand"
Imagine a second hand books component with just the one books table and matching view. 

Table items
*  id
* name
* author
* isbn
* Standard items like publish, created, ...

The idea is to use an external scan the ISBN of the book, fetch book data by other web API and use a J! web API to fill this table.
## Web Services API plg_webservices_secondhand

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
The general folder structure is similar to each other plugin bse structure.
The file src->Extension->Secondhand.php will hold the API definition, whereas all other folders and files support the API event interception.

### Manifest file
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
### services/provider.php 
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
### Extension Class

Overview (All code), details will follow
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
Here the function onBeforeApiRoute is asigned to the API event list

**function onBeforeApiRoute**
Here the magic happens with call to createCRUDERoutes. This is a function provided by Joomla which supports 'CRUD' (Create, Read, Update; Delete) API routes to call over HTTP

The first parameter ```php  'v1/secondhand/books' ``` tell the route which can be used in the call to the web page. 'v1' is used as the version, 'secondhand' is the component and 'books' are the items.
The second parameter is the controller to be used. The last is the internal config parameter which defines the actual component to be used and  and how 'public' the API is reachable.

To be moved:
Now you may have an inkling how 
A more detailed description will follow

## Component "com_secondhand" API additons






. . . . . .. 