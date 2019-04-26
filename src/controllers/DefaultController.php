<?php
/**
 * User Initials Photo plugin for Craft CMS 3.x
 *
 * A plugin to assign profile picture of user with their name initials.
 *
 * @link      http://www.hashtagerrors.com
 * @copyright Copyright (c) 2019 Hashtag Errors
 */

namespace hashtagerrors\userinitialsphoto\controllers;

use hashtagerrors\userinitialsphoto\UserInitialsPhoto;

use Craft;
use craft\web\Controller;

/**
 * @author    Hashtag Errors
 * @package   UserInitialsPhoto
 * @since     1.1.0
 */
class DefaultController extends Controller
{

    // Protected Properties
    // =========================================================================

    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     *         The actions must be in 'kebab-case'
     * @access protected
     */
    protected $allowAnonymous = false;

    // Public Methods
    // =========================================================================

    public function actionAssignPhoto()
    {   
        $overwrite = Craft::$app->getRequest()->getParam('ui-overwrite');
        UserInitialsPhoto::$plugin->userInitialsPhotoService->assignPhotos($overwrite);
        return $this->redirectToPostedUrl();
    }
}
