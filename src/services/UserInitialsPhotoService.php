<?php
/**
 * User Initials Photo plugin for Craft CMS 3.x
 *
 * A plugin to assign profile picture of user with their name initials.
 *
 * @link      http://www.hashtagerrors.com
 * @copyright Copyright (c) 2019 Hashtag Errors
 */

namespace hashtagerrors\userinitialsphoto\services;

use hashtagerrors\userinitialsphoto\UserInitialsPhoto;

use Craft;
use craft\base\Component;

/**
 * @author    Hashtag Errors
 * @package   UserInitialsPhoto
 * @since     1.0.0
 */
class UserInitialsPhotoService extends Component
{
    // Public Methods
    // =========================================================================

    /*
     * @return mixed
     */

    public function assignPhoto($element)
    {
        $imageUrl = $this->generatePhoto($element);
        $id = $element->id;
        $users = Craft::$app->getUsers();
        $user = $users->getUserById($id);
        $email = $user->email;
        $filename = strstr($email, '@', true).'.png';
        $fileLocation = Craft::$app->getPath()->getTempPath() . DIRECTORY_SEPARATOR . $filename;
        $fileContents = file_get_contents($imageUrl);
        file_put_contents($fileLocation, $fileContents);
        $users->saveUserPhoto($fileLocation, $user, $filename);
        return true;
    }

    public function generatePhoto($element)
    {
        $firstName = $element->firstName;
        $lastName  = $element->lastName;
        $username  = $element->username;
        $email     = $element->email;

        $name = $email;
        $size = 128;
        $background = $this->getRandomBG();
        $color = 'fff';
        $length = 1;
        $fontSize = 0.5;
        $rounded = true;
        $uppercase = true;

        if(isset($firstName) && !empty($firstName) && isset($lastName) && !empty($lastName)){
            $name = $firstName . '+' . $lastName;
            $length = 2;
        }elseif(isset($firstName) && !empty($firstName)){
            $name = $firstName;
        }elseif(isset($lastName) && !empty($lastName)){
            $name = $lastName;
        }elseif(isset($username) && !empty($username)){
            $name = $username;
        }

        $url  = "https://ui-avatars.com/api/{$name}/{$size}/{$background}/{$color}/{$length}/{$fontSize}/{$rounded}/{$uppercase}.png" ;
        
        return $url;
    }

    public function getRandomBG(){
        $colorArr = ['006ba6','00a896','00cfc1','011627','028090','02c39a','04859b','0496ff','05668d','06d6a0','0b032d','1a535c','1be7ff','1d3557','247ba0','264653','26547c','2a9d8f','2b0504','2b2d42','2ec4b6','2ec4b6','38303f','410458','457b9d','4ecdc4','50514f','69a197','6d6875','6eeb83','70c1b3','74546a','843b62','8acb88','8d99ae','8f2d56','a8dadc','aa1911','b5838d','bbbbbb','bc5f04','bfae48','ceae88','d81159','d90429','e53d00','e5989b','e63946','e71d36','e76f51','e8aa14','e9ce2c','ef233c','ef476f','f0a202','f25f5c','f4442e','f4a261','f67e7d','fd5200','fe621d','ff1654','ff5a5f','ff6600','ff6b6b','ff9f1c','ffb4a2','ffb997','ffbc42'];
        $randKey = array_rand($colorArr);
        return $colorArr[$randKey];

    }
}
