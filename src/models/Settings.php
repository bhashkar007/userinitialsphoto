<?php
/**
 * User Initials Photo plugin for Craft CMS 3.x
 *
 * A plugin to assign profile picture of user with their name initials.
 *
 * @link      http://www.hashtagerrors.com
 * @copyright Copyright (c) 2019 Hashtag Errors
 */

namespace hashtagerrors\userinitialsphoto\models;

use hashtagerrors\userinitialsphoto\UserInitialsPhoto;

use Craft;
use craft\base\Model;

/**
 * @author    Hashtag Errors
 * @package   UserInitialsPhoto
 * @since     1.1.0
 */
class Settings extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $newUsersOnly = '1';

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['newUsersOnly', 'string']
        ];
    }
}
