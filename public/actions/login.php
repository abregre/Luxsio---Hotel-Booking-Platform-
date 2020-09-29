<?php


require_once __DIR__.'/../../boot/boot.php';

use Hotel\User; 
use Hotel\BaseService;

//Return to home page if not POST method
if(strtolower($_SERVER['REQUEST_METHOD']) != 'post'){
  header('Location: /');
  return;
} else{
  $baseService = new BaseService();
  $email = $baseService->clearData($_REQUEST['email']);
}


//Check if user logged
if (!empty(User::getCurrentUserId())){
  header('Location: /');
  return;
}

//Create new User

$user = new User();

$verifedUser = $user->verifyPass($email, $_REQUEST['password']);

if($verifedUser){
//Get user
$userDb = $user->getByEmail($email);

//Generate Token
$token = $user->genToken($userDb['user_id']);

//Set Cookie

setcookie('user_token', $token, time()+ (60*60*24), '/');

//Return to homepage

header('Location: /public/index.php');
}