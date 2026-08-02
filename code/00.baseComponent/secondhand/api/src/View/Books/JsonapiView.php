<?php

/**
 * @package        Secondhand
 * @subpackage     com_secondhand
 * @author         steven_smith@dummy.com>
 * @copyright  (c) 2005-2026 Secondhand Team
 * @license        GNU General Public License version 2 or later
 */

namespace Bluebox\Component\Secondhand\Api\View\Books;

use Joomla\CMS\Factory;
use Joomla\CMS\Helper\TagsHelper;
use Joomla\CMS\Language\Multilanguage;
use Joomla\CMS\MVC\View\JsonApiView as BaseApiView;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\Component\Fields\Administrator\Helper\FieldsHelper;
use Joomla\Registry\Registry;
use Secondhand\Component\Secondhand\Api\Helper\SecondhandHelper;
use Secondhand\Component\Secondhand\Api\Serializer\SecondhandSerializer;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * The books view
 *
 * @since  4.0.0
 */
class JsonapiView extends BaseApiView
{
    /**
     * The fields to render item in the documents
     *
     * @var  array
     * @since  4.0.0
     */
    protected $fieldsToRenderItem = [
        'id',
        'title',
        'alias',
        'isbn',
        'description',

        'note',
        'published',
        'created', 'created_by',
        'modified', 'modified_by',
    ];

    /**
     * The fields to render items in the documents
     *
     * @var  array
     * @since  4.0.0
     */
    protected $fieldsToRenderList = [
        'id',
        'title',
        'alias',
        'isbn',
        'description',

        'note',
        'published',
        'created', 'created_by',
        'modified', 'modified_by',
    ];

}
