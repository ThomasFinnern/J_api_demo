<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_secondhand
 *
 * @copyright   Copyright (C) 2026 Steven Smith. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

\defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Router\Route;
use Bluebox\Component\Secondhand\Site\Helper\RouteHelper;

HTMLHelper::_('behavior.core');

$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn  = $this->escape($this->state->get('list.direction'));
?>
<div class="com-secondhand-list__items">
	<?php if (empty($this->items)) : ?>
		<p class="com-secondhand-items__message"> <?php echo Text::_('COM_SECONDHAND_NO_BOOKS'); ?>	 </p>
	<?php else : ?>

        <?php foreach ($this->items as $i => $item) : ?>
            <p>
                <a href="<?php echo Route::_(RouteHelper::getBookRoute($item->slug)); ?>">
                    <?php echo $item->title; ?>
                </a>
            </p>
        <?php endforeach; ?>

	<?php endif; ?>
</div>
