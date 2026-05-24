<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_secondhand
 *
 * @copyright  (C) 2026-2026 Steven Smith
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

\defined('_JEXEC') or die;


use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Language\Text;

$displayData = [
	'textPrefix' => 'COM_SECONDHAND',
	'formURL' => 'index.php?option=com_secondhand',
	'icon' => 'icon-book',
];

$user = Factory::getApplication()->getIdentity();

if ($user->authorise('core.create', 'com_secondhand') || count($user->getAuthorisedCategories('com_secondhand', 'core.create')) > 0)
{
	$displayData['createURL'] = 'index.php?option=com_secondhand&task=book.add';
}

echo LayoutHelper::render('joomla.content.emptystate', $displayData);