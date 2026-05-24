<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_secondhand
 *
 * @copyright  (C) 2026-2026 Steven Smith
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Bluebox\Component\Secondhand\Administrator\Table;

\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Application\ApplicationHelper;
use Joomla\CMS\Table\Table;
use Joomla\CMS\Tag\TaggableTableInterface;
use Joomla\CMS\Tag\TaggableTableTrait;
use Joomla\CMS\Versioning\VersionableTableInterface;
use Joomla\Database\DatabaseDriver;
use Joomla\CMS\Language\Text;
use Joomla\Registry\Registry;

/**
 * Book Table class.
 *
 * @since  0.1.0
 */
class BookTable extends Table implements VersionableTableInterface, TaggableTableInterface
{   
    use TaggableTableTrait;
    
    /**
	 * Indicates that columns fully support the NULL value in the database
	 *
	 * @var    boolean
	 * @since  0.1.0
	 */
	protected $_supportNullValue = true;

	/**
	 * Ensure the params and metadata in json encoded in the bind method
	 *
	 * @var    array
	 * @since  0.1.0
	 */
	//protected $_jsonEncode = array('params', 'metadata');
    
    /**
	 * Constructor
	 *
	 * @param   DatabaseDriver  $db  Database connector object
	 *
	 * @since   0.1.0

	 */
	public function __construct(DatabaseDriver $db)
	{
		$this->typeAlias = 'com_secondhand.book';

		parent::__construct('#__secondhand_books', 'id', $db);
	}

	/**
	 * Overloaded check function
	 *
	 * @return  boolean  True on success, false on failure
	 *
	 * @see     \JTable::check
	 * @since   0.1.0
	 */
	public function check()
	{
		try
		{
			parent::check();
		}
		catch (\Exception $e)
		{
			$this->setError($e->getMessage());

			return false;
		}
        
		// Add your checks here

        
        // Generate a valid alias
		$this->generateAlias();

        if (!$this->modified)
		{
			$this->modified = $this->created;
		}

		if (empty($this->modified_by))
		{
			$this->modified_by = $this->created_by;
		}

		return true;
	}

	/**
	 * Method to store a row
	 *
	 * @param   boolean  $updateNulls  True to update fields even if they are null.
	 *
	 * @return  boolean  True on success, false on failure.
	 */
	public function store($updateNulls = false)
	{
		$date   = Factory::getDate()->toSql();
		$userId = Factory::getApplication()->getIdentity()->id;
        
        $db     = $this->getDbo();

		// Set created date if not set.
		if (!(int) $this->created)
		{
			$this->created = $date;
		}

		if ($this->id)
		{
			// Existing item
			$this->modified_by = $userId;
			$this->modified    = $date;
		}
		else
		{
			// Field created_by field can be set by the user, so we don't touch it if it's set.
			if (empty($this->created_by))
			{
				$this->created_by = $userId;
			}

			if (!(int) $this->modified)
			{
				$this->modified = $date;
			}

			if (empty($this->modified_by))
			{
				$this->modified_by = $userId;
			}
		}
        
        // Verify that the alias is unique
		$table = Table::getInstance('BookTable', __NAMESPACE__ . '\\', array('dbo' => $db));
        if ($table->load(array('alias' => $this->alias)) && ($table->id != $this->id || $this->id == 0))

		{
			$this->setError(Text::_('COM_SECONDHAND_ERROR_UNIQUE_ALIAS'));

			return false;
		}
        return parent::store($updateNulls);
	}
    
	/**
	 * Generate a valid alias from title / date.
	 * Remains public to be able to check for duplicated alias before saving
	 *
	 * @return  string
	 */
	public function generateAlias()
	{
		if (empty($this->alias))
		{
			$this->alias = $this->title;
		}

		$this->alias = ApplicationHelper::stringURLSafe($this->alias, $this->language);

		if (trim(str_replace('-', '', $this->alias)) == '')
		{
			$this->alias = Factory::getDate()->format('Y-m-d-H-i-s');
		}

		return $this->alias;
	}


	/**
	 * Get the type alias for the history table
	 *
	 * @return  string  The alias as described above
	 *
	 * @since   0.1.0
	 */
	public function getTypeAlias()
	{
		return $this->typeAlias;
	}

}
