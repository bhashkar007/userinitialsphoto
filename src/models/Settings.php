<?php
/**
 * User Initials Photo plugin for Craft CMS 4.x
 * A plugin to assign profile picture of user with their name initials.
 * @link      https://360adaptive.com
 * @copyright Copyright (c) 2023 360Adaptive Technologies
 */

namespace bhashkar007\userinitialsphoto\models;

use bhashkar007\userinitialsphoto\UserInitialsPhoto;

use Craft;
use craft\base\Model;

/**
 * @author    360Adaptive Technologies
 * @package   UserInitialsPhoto
 * @since     2.0.0
 */
class Settings extends Model
{
    public $newUsersOnly = '1';

    public function rules(): Array
    {
        return [
            ['newUsersOnly', 'string']
        ];
    }
}
