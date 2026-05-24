<?php

/**
 * @package     Joomla.Plugin
 * @subpackage  Webservices.Secondhand
 * @author      Steven Smith
 * @copyright   Copyright (C) 2026 Steven Smith. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

use Joomla\CMS\Extension\PluginInterface;
use Joomla\CMS\Factory;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use Joomla\Event\DispatcherInterface;
use Bluebox\Plugin\WebServices\Secondhand\Extension\Secondhand;

return new class () implements ServiceProviderInterface{
    public function register(Container $container)
    {
        $container->set(
            PluginInterface::class,
            function (Container $container) {

                $plugin     = PluginHelper::getPlugin('webservices', 'secondhand');
                $dispatcher = $container->get(DispatcherInterface::class);

                /** @var CMSPlugin $plugin */
                $plugin = new Secondhand($dispatcher, (array) $plugin);
                $plugin->setApplication(Factory::getApplication());

                return $plugin;
            }
        );
    }
};
