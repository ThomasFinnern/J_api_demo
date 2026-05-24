<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_secondhand
 *
 * @copyright   Copyright (C) 2026 Steven Smith. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
namespace Bluebox\Component\Secondhand\Administrator\Controller;

\defined('_JEXEC') or die;

use Joomla\CMS\MVC\Controller\FormController;
use Joomla\CMS\MVC\Model\BaseDatabaseModel;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Versioning\VersionableControllerTrait;
use Joomla\Utilities\ArrayHelper;

/**
 * Controller for a single Book
 *
 * @since  1.0.0
 */
class BookController extends FormController
{
	use VersionableControllerTrait;
	
	/**
	 * The prefix to use with controller messages.
	 *
	 * @var    string
	 * @since  1.6
	 */
	protected $text_prefix = 'COM_SECONDHAND_BOOK';
}
