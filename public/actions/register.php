<?php


require_once __DIR__.'/../../boot/boot.php';

use Hotel\User; 
use Hotel\BaseService;

//Return to home page if not POST method
if(strtolower($_SERVER['REQUEST_METHOD']) != 'post'){
  header('Location: /');

  return;
} else {
  $baseService = new BaseService();
  $name = $baseService->clearData($_REQUEST['name']);
  $email = $baseService->clearData($_REQUEST['email']);
}

//Create new User

$user = new User();
$user->insert($name, $email, $_REQUEST['password']);

//Retrieve user from DB
$userDb = $user->getByEmail($email);

//Generate Token
$token = $user->genToken($userDb['user_id']);

//Set Cookie

setcookie('user_token', $token, time()+ (60*60*24), '/');

//Return to homepage

header('Location: /public/index.php');