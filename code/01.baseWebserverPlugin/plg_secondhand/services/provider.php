<?php

/**
 * @package     Joomla.Plugin
 * @subpackage  Webservices.Secondhand
 * @author      Steven Smith
 * @copyright  (C) 2026-2026 Steven Smith
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

use Joomla\CMS\Extension\PluginInterface;
use Joomla\CMS\Factory;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use Bluebox\Plugin\WebServices\Secondhand\Extension\Secondhand;

return new class () implements ServiceProviderInterface{
    /**
     * Registers the service provider with a DI container.
     *
     * @param   Container  $container  The DI container.
     *
     * @return  void
     *
     * @since   0.1.0
     */
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
