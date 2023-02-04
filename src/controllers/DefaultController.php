<?php
/**
 * User Initials Photo plugin for Craft CMS 4.x
 * A plugin to assign profile picture of user with their name initials.
 * @link      https://360adaptive.com
 * @copyright Copyright (c) 2023 360Adaptive Technologies
 */

namespace bhashkar007\userinitialsphoto\controllers;

use bhashkar007\userinitialsphoto\UserInitialsPhoto;

use Craft;
use craft\web\Controller;

/**
 * @author    360Adaptive Technologies
 * @package   UserInitialsPhoto
 * @since     2.0.0
 */
class DefaultController extends Controller
{

    protected array|int|bool $allowAnonymous = false;

    public function actionAssignPhoto()
    {   
        $overwrite = Craft::$app->getRequest()->getParam('ui-overwrite');
        UserInitialsPhoto::$plugin->userInitialsPhotoService->assignPhotos($overwrite);
        return $this->redirectToPostedUrl();
    }
}