<?php


require_once __DIR__.'/../../boot/boot.php';
use Hotel\User;
use Hotel\Review; 
use Hotel\BaseService;

//Return to home page if not POST method
if(strtolower($_SERVER['REQUEST_METHOD']) != 'post'){
  header('Location: /');
  return;
} else {
  $baseService = new BaseService();
  $roomId = $baseService->clearData($_REQUEST['room_id']);
  $name = $baseService->clearData($_REQUEST['name']);
  $email = $baseService->clearData($_REQUEST['email']);
}

//Check if room id given
if(empty($roomId)){
  header('Location: /');
  return;
}
//Verify Csrf
$csrf = $_REQUEST['csrf'];
if (!$csrf || !User::verifyCsrf($csrf)){
  header('Location: /');
  return;
}

//Add review
$review = new Review();
$test = $review->addReview($roomId, User::getCurrentUserId(), $_REQUEST['rate'], $_REQUEST['comment']);


//Return to room 
header(sprintf('Location: /public/room.php?room_id=%s', $roomId));

