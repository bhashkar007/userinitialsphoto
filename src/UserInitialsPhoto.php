<?php
/**
 * User Initials Photo plugin for Craft CMS 4.x
 * A plugin to assign profile picture of user with their name initials.
 * @link      https://360adaptive.com
 * @copyright Copyright (c) 2023 360Adaptive Technologies
 */

namespace bhashkar007\userinitialsphoto;

use bhashkar007\userinitialsphoto\services\UserInitialsPhotoService;
use bhashkar007\userinitialsphoto\models\Settings;

use Craft;
use craft\base\Plugin;
use craft\services\Elements;
use craft\elements\User;
use craft\web\UrlManager;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\events\RegisterUrlRulesEvent;
use yii\base\Event;

/**
 * Class UserInitialsPhoto
 *
 * @author    360Adaptive Technologies
 * @package   UserInitialsPhoto
 * @since     2.0.0
 *
 * @property  UserInitialsPhotoServiceService $userInitialsPhotoService
 */
class UserInitialsPhoto extends Plugin
{
    public static $plugin;

    public string $schemaVersion = '2.0.0';

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

        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_CP_URL_RULES,
            function (RegisterUrlRulesEvent $event) {
                $event->rules['cpActionTrigger'] = 'user-initials-photo/default/assign-photo';
            }
        );

        Event::on(Elements::class, Elements::EVENT_AFTER_SAVE_ELEMENT, function(Event $event) {
            if($event->element instanceof User){
                $forNewUsersOnly = UserInitialsPhoto::$plugin->getSettings()->newUsersOnly;
                $element = $event->element;
                $isNew = $event->isNew;
                if (!$forNewUsersOnly){ $isNew = 1; }
                    if($isNew){
                        $element = $event->element;
                        UserInitialsPhoto::$plugin->userInitialsPhotoService->assignPhoto($element);
                    }
                }
        });

        Craft::info(
            Craft::t(
                'user-initials-photo',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    protected function createSettingsModel(): ?\craft\base\Model
    {
        return new Settings();
    }

    protected function settingsHtml(): string
    {
        return Craft::$app->view->renderTemplate(
            'user-initials-photo/settings',
            [
                'settings' => $this->getSettings()
            ]
        );
    }
}