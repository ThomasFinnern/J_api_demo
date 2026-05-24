<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_secondhand
 *
 * @copyright   Copyright (C) 2026 Steven Smith. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Bluebox\Component\Secondhand\Site\Helper;

\defined('_JEXEC') or die;

use Joomla\CMS\Language\Multilanguage;

/**
 * Secondhand Component Route Helper
 *
 * @static
 * @package     Joomla.Site
 * @subpackage  com_secondhand * @since       1.0.0
 */
abstract class RouteHelper
{
	/**
	 * Get the URL route for a book from a book ID, books category ID and language
	 *
	 * @param   integer  $id        The id of the books
	 * @param   integer  $catid     The id of the books's category
	 * @param   mixed    $language  The id of the language being used.
	 *
	 * @return  string  The link to the books
	 *
	 * @since   1.0.0
	 */
	public static function getBookRoute($id, $catid = 0, $language = 0)
	{
		// Create the link
		$link = 'index.php?option=com_secondhand&view=book&id=' . $id;
        
        
		if ($language && $language !== '*' && Multilanguage::isEnabled())
		{
			$link .= '&lang=' . $language;
		}

		return $link;
	}
}
