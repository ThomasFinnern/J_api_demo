<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_secondhand
 *
 * @copyright   Copyright (C) 2026 Steven Smith. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Bluebox\Component\Secondhand\Site\Dispatcher;

\defined('_JEXEC') or die;

use Joomla\CMS\Dispatcher\ComponentDispatcher;
use Joomla\CMS\Language\Text;

/**
 * ComponentDispatcher class for com_secondhand *
 * @since  4.0.0
 */
class Dispatcher extends ComponentDispatcher
{
	/**
	 * Dispatch a controller task. Redirecting the user if appropriate.
	 *
	 * @return  void
	 *
	 * @since   4.0.0
	 */
	public function dispatch()
	{
		if ($this->input->get('view') === 'books' && $this->input->get('layout') === 'modal')
		{
			if (!$this->app->getIdentity()->authorise('core.create', 'com_secondhand'))
			{
				$this->app->enqueueMessage(Text::_('JERROR_ALERTNOAUTHOR'), 'warning');

				return;
			}

			$this->app->getLanguage()->load('com_secondhand', JPATH_ADMINISTRATOR);
		}

		parent::dispatch();
	}
}
