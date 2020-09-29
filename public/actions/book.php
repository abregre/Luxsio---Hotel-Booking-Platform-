<?php

require_once __DIR__.'/../../boot/boot.php';

use Hotel\User;
use Hotel\Booking; 


//Return to home page if not GET method
if(strtolower($_SERVER['REQUEST_METHOD']) != 'get'){
  header('Location: /');
  return;
}
//Check if user logged
if (empty(User::getCurrentUserId())){
  header('Location: /public/login.php');
  return;
}

//Check if room id given
$roomId = $_REQUEST['room_id'];
if(empty($roomId)){
  header('Location: /');
  return;
}

//Create Booking

$booking = new Booking();
$checkInDate = $_REQUEST['check_in_date'];
$checkOutDate = $_REQUEST['check_out_date'];
$validBooking = $booking->insert($roomId, User::getCurrentUserId(), $checkInDate,$checkOutDate);

//Return room to favs
if($validBooking){

  header(sprintf('Location: /public/room.php?room_id=%s', $roomId));
  return;
}

