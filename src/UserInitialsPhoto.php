<?php
/**
 * User Initials Photo plugin for Craft CMS 3.x
 *
 * A plugin to assign profile picture of user with their name initials.
 *
 * @link      http://www.hashtagerrors.com
 * @copyright Copyright (c) 2019 Hashtag Errors
 */

namespace hashtagerrors\userinitialsphoto;

use hashtagerrors\userinitialsphoto\services\UserInitialsPhotoService;

use Craft;
use craft\base\Plugin;
use craft\services\Elements;
use craft\elements\User;
use craft\services\Plugins;
use craft\events\PluginEvent;

use yii\base\Event;

/**
 * Class UserInitialsPhoto
 *
 * @author    Hashtag Errors
 * @package   UserInitialsPhoto
 * @since     1.0.0
 *
 * @property  UserInitialsPhotoServiceService $userInitialsPhotoService
 */
class UserInitialsPhoto extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var UserInitialsPhoto
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $schemaVersion = '1.0.0';

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ($event->plugin === $this) {
                }
            }
        );

        Event::on(Elements::class, Elements::EVENT_AFTER_SAVE_ELEMENT, function(Event $event) {
            if ($event->element instanceof User && $event->isNew) {
                $element = $event->element;
                UserInitialsPhoto::$plugin->userInitialsPhotoService->assignPhoto($element);
            }
        });

        //
        Craft::info(
            Craft::t(
                'user-initials-photo',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================

}
