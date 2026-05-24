<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_secondhand
 *
 * @copyright   Copyright (C) 2026 Steven Smith. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
namespace Bluebox\Component\Secondhand\Administrator\View\Books;

\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Helper\ContentHelper;
use Joomla\CMS\Language\Multilanguage;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\GenericDataException;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Toolbar\Toolbar;
use Joomla\CMS\Toolbar\ToolbarHelper;

/**
 *  * View class for a list of books.
 *
 * @since  1.0.0
 */
class HtmlView extends BaseHtmlView
{
	/**
	 * An array of items
	 *
	 * @var  array
	 */
	protected $items;

	/**
	 * The pagination object
	 *
	 * @var  \Joomla\CMS\Pagination\Pagination
	 */
	protected $pagination;

	/**
	 * The model state
	 *
	 * @var  \Joomla\CMS\Object\CMSObject
	 */
	protected $state;

	/**
	 * Form object for search filters
	 *
	 * @var  \Joomla\CMS\Form\Form
	 */
	public $filterForm;

	/**
	 * The active search filters
	 *
	 * @var  array
	 */
	public $activeFilters;

	/**
	 * Is this view an Empty State
	 *
	 * @var   boolean
	 *
	 * @since 1.0.0
	 */
	private $isEmptyState = false;
	
	/**
	 * Method to display the view.
	 *
	 * @param   string  $tpl  A template file to load. [optional]
	 *
	 * @return  void
	 *
	 * @since   1.0.0
	 */
    public function display($tpl = null): void
    {
        $this->items         = $this->get('Items');
		$this->pagination    = $this->get('Pagination');
		$this->state         = $this->get('State');
		$this->filterForm    = $this->get('FilterForm');
		$this->activeFilters = $this->get('ActiveFilters'); 
        
        if (!\count($this->items) && $this->isEmptyState = $this->get('IsEmptyState'))
        {
			$this->setLayout('emptystate');
		}
        
        // We don't need toolbar in the modal window.
		if ($this->getLayout() !== 'modal')
		{
			$this->addToolbar();
        }

		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	protected function addToolbar()
	{
		$user = Factory::getApplication()->getIdentity();
		$canDo = ContentHelper::getActions('com_secondhand');
        
		ToolbarHelper::title(Text::_('COM_SECONDHAND_HEADLINE_BOOKS'), 'list com_secondhand');
        
		// Get the toolbar object instance
		$toolbar = Toolbar::getInstance('toolbar');
		if ($canDo->get('core.create'))
		{
			$toolbar->addNew('book.add');
		}
        
        if (!$this->isEmptyState && $canDo->get('core.edit.state'))
		{
            $dropdown = $toolbar->dropdownButton('status-group')
				->text('JTOOLBAR_CHANGE_STATUS')
				->toggleSplit(false)
				->icon('icon-ellipsis-h')
				->buttonClass('btn btn-action')
				->listCheck(true);

			$childBar = $dropdown->getChildToolbar();

			$childBar->publish('books.publish')->listCheck(true);

			$childBar->unpublish('books.unpublish')->listCheck(true);
            
            $childBar->archive('books.archive')->listCheck(true);
            
            if ($this->state->get('filter.published') != -2)
			{
				$childBar->trash('books.trash')->listCheck(true);
			}
        }
        
        if (!$this->isEmptyState && $this->state->get('filter.published') == -2 && $canDo->get('core.delete'))
		{
			$toolbar->delete('books.delete')
				->text('JTOOLBAR_EMPTY_TRASH')
				->message('JGLOBAL_CONFIRM_DELETE')
				->listCheck(true);
		}
		
		if ($user->authorise('core.admin', 'com_secondhand') || $user->authorise('core.options', 'com_secondhand'))
		{
			$toolbar->preferences('com_secondhand');
		}
		
		
	}
}