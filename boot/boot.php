<?php

error_reporting(E_ERROR);
ini_set('display_errors',1);
// autoload_register
spl_autoload_register(function ($class) {
    $class = str_replace("\\", "/", $class);
    require_once __DIR__.'/../app/'.$class.'.php';
});

use Hotel\User;

$user = new User();

//Check for token in the request

$userToken = $_COOKIE['user_token'];


if($userToken) {
    //Verify User
  
    if ($user->verifyToken($userToken))

        {
            //Set User in mem
            $userDb = $user->getTokenPayload($userToken);

            User::setCurrentUserId($userDb['user_id']);
           
        }

    
}