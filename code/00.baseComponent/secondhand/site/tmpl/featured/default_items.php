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

/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $this->document->getWebAssetManager();
$wa->useScript('core')->useScript('searchtools');

$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn  = $this->escape($this->state->get('list.direction'));
?>
<div class="com-secondhand-featured__items">
	<?php if (empty($this->items)) : ?>
		<p class="com-secondhand-featured__message"> <?php echo Text::_('COM_SECONDHAND_NO_BOOKS'); ?>	 </p>
	<?php else : ?>
	<form action="<?php echo htmlspecialchars(Uri::getInstance()->toString()); ?>" method="post" name="adminForm" id="adminForm">
		<table class="com-secondhand-featured__table table">
			<thead class="thead-default">
				<tr>
					<th class="item-num">
						<?php echo Text::_('JGLOBAL_NUM'); ?>
					</th>

					<th class="item-title">
						<?php echo HTMLHelper::_('grid.sort', 'COM_SECONDHAND_BOOK_TITLE_LABEL', 'a.title', $listDirn, $listOrder); ?>
					</th>
				</tr>
			</thead>

			<tbody>
				<?php foreach ($this->items as $i => $item) : ?>
					<tr class="<?php echo ($i % 2) ? 'odd' : 'even'; ?>">
						<td class="item-num">
							<?php echo $i; ?>
						</td>

						<td class="item-title">
                            <a href="<?php echo Route::_(RouteHelper::getBookRoute($item->slug)); ?>">
                                <?php echo $item->title; ?>
                            </a>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
        <input type="hidden" name="filter_order" value="">
		<input type="hidden" name="filter_order_Dir" value="">
		<input type="hidden" name="task" value="">
	</form>
	<?php endif; ?>
</div>
