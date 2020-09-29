<?php

require_once __DIR__.'/../../boot/boot.php';

use Hotel\User;
use Hotel\Favorite; 


//Return to home page if not GET method
if(strtolower($_SERVER['REQUEST_METHOD']) != 'post'){
  die;
}
//Check if user logged
if (empty(User::getCurrentUserId())){
  die;
}

//Check if room id given
$roomId = $_REQUEST['room_id'];
if(empty($roomId)){
  die;
}

//Set  room to favs

$favorite = new Favorite();
//Add or remove room from favs
$isFavorite = $_REQUEST['is_favorite'];
if(!$isFavorite){
  $status = $favorite->addFavorite($roomId, User::getCurrentUserId());
} else{ 
  $status = $favorite->removeFavorite($roomId, User::getCurrentUserId());
}

//Return op status
header('Content-Type: application/json');
echo json_encode([
  'status'=> $status,
  'is_favorite'=> !$isFavorite
]);


