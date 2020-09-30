<?php

require_once __DIR__.'/../../boot/boot.php';

use Hotel\User;
use Hotel\Favorite; 


//Return to home page if not GET method
if(strtolower($_SERVER['REQUEST_METHOD']) != 'post'){
  header('Location: /');
  return;
}
//Check if user logged
if (empty(User::getCurrentUserId())){
  header('Location: /');
  return;
}

//Check if room id given
$roomId = $_REQUEST['room_id'];
if(empty($roomId)){
  header('Location: /');
  return;
}

//Set  room to favs

$favorite = new Favorite();
//Add or remove room from favs
$isFavorite = $_REQUEST['is_favorite'];

if(!$isFavorite){
  $favorite->addFavorite($roomId, User::getCurrentUserId());
} else{ 
  $favorite->removeFavorite($roomId, User::getCurrentUserId());
}

//Return room to favs
header(sprintf('Location: /room.php?room_id=%s', $roomId));


