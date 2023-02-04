<?php
/**
 * User Initials Photo plugin for Craft CMS 4.x
 * A plugin to assign profile picture of user with their name initials.
 * @link      https://360adaptive.com
 * @copyright Copyright (c) 2023 360Adaptive Technologies
 */

namespace bhashkar007\userinitialsphoto\jobs;

use bhashkar007\userinitialsphoto\UserInitialsPhoto;

use Craft;
use craft\queue\BaseJob;

/**
 * @author    360Adaptive Technologies
 * @package   UserInitialsPhoto
 * @since     2.0.0
 */
class AssignPhotoTask extends BaseJob
{
    public $user;

    public function execute($queue): void
    {
        $errors = [];

        try {
            $users = Craft::$app->getUsers();
            $user = $this->user;
            $id = $user->id;
            $imageUrl = UserInitialsPhoto::$plugin->userInitialsPhotoService->generatePhoto($user);
            $email = $user->email;
            $filename = strstr($email, '@', true).'.png';
            $fileLocation = Craft::$app->getPath()->getTempPath() . DIRECTORY_SEPARATOR . $filename;
            $fileContents = file_get_contents($imageUrl);
            file_put_contents($fileLocation, $fileContents);
            if (!$users->saveUserPhoto($fileLocation, $user, $filename)) {
                Craft::error('Error assigning photo to ' . $user->name);
            }
        } catch (\Throwable $e) {
            Craft::error('Entry assigning photo: ' . $e->getMessage());
        }
    }

    protected function defaultDescription(): string
    {
        return Craft::t('user-initials-photo', 'Assigning photo to {name}.', [ 'name' => $this->user->name]);
    }
}
