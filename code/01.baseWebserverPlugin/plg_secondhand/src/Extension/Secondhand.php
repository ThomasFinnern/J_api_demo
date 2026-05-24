<?php

/**
 * @package     Joomla.Plugin
 * @subpackage  Webservices.Secondhand 
 *
 * @copyright  (C) 2026-2026 Steven Smith 
 * @license     GNU General Public License version 2 or later; see LICENSE.txt 
 */

namespace Bluebox\Plugin\Webservices\Secondhand\Extension;

use Joomla\CMS\Event\Application\BeforeApiRouteEvent;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Router\ApiRouter;
use Joomla\Event\SubscriberInterface;
use Joomla\Router\Route;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * Joomla! Webservices Plugin. webservice secondhand.
 *
 * @since  0.1.0
 */
final class Secondhand extends CMSPlugin implements SubscriberInterface
{
    /**
     * Returns an array of events this subscriber will listen to.
     *
     * @return  array
     *
     * @since   5.1.0
     */
    public static function getSubscribedEvents(): array
    {
        return [
            'onBeforeApiRoute' => 'onBeforeApiRoute',
        ];
    }

    /**
     * Registers com_secondhand API's routes in the application
     *
     * @param   BeforeApiRouteEvent  $event  The event object
     *
     * @return  void
     *
     * @since   4.0.0
     */
    public function onBeforeApiRoute(BeforeApiRouteEvent $event): void
    {
        $router = $event->getRouter();

        $router->createCRUDRoutes(
            'v1/secondhand/books',
            'books',
            ['component' => 'com_redirect']
        );
    }  
}
