<?php
/**
 * User Initials Photo plugin for Craft CMS 3.x
 *
 * A plugin to assign profile picture of user with their name initials.
 *
 * @link      http://www.hashtagerrors.com
 * @copyright Copyright (c) 2019 Hashtag Errors
 */

namespace hashtagerrors\userinitialsphoto\jobs;

use hashtagerrors\userinitialsphoto\UserInitialsPhoto;

use Craft;
use craft\queue\BaseJob;

/**
 * @author    Hashtag Errors
 * @package   UserInitialsPhoto
 * @since     1.1.0
 */
class AssignPhotoTask extends BaseJob
{
    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $user;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function execute($queue)
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

    // Protected Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    protected function defaultDescription(): string
    {
        return Craft::t('user-initials-photo', 'Assigning photo to {name}.', [ 'name' => $this->user->name]);
    }
}
