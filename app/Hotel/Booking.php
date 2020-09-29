<?php

namespace Hotel;


use Hotel\BaseService;
use DateTime;



class Booking extends BaseService
{
  public function isBooked($roomId,$fromDate,$toDate)
  {
    //Prepare
    $params=[
      ':room_id' => $roomId,
      ':check_in_date' => $fromDate,
      ':check_out_date' => $toDate,
    ];
  
    $rows = $this->fetchAll('SELECT room_id FROM booking WHERE room_id = :room_id AND check_in_date = :check_in_date AND check_out_date >= :check_out_date', $params);
    

    return count($rows) >0;
    
  }

  public function insert($roomId,$userId,$fromDate,$toDate)
  {
    //Transaction init
    $this->getPdo()->beginTransaction();

    //Get room info
    $params = [
      ':room_id' => $roomId,
    ];
    $roomInfo = $this->fetch('SELECT * FROM room WHERE room_id = :room_id',$params);
    $price =$roomInfo['price'];
  
    //Calc final price
    $checkInDateTime = new DateTime($fromDate);
    $checkOutDateTime = new DateTime($toDate);

    $days = $checkOutDateTime->diff($checkInDateTime)->days;
    $totalPrice = $price * $days;
    //Create Booking
     //Prepare
     $params = [
      ':room_id'=>$roomId,
      ':user_id'=>$userId,
      ':total_price'=>$totalPrice,
      ':check_in_date'=>$fromDate,
      ':check_out_date'=>$toDate,

    ];

     $this->execute('INSERT IGNORE INTO booking (room_id, user_id, total_price,check_in_date, check_out_date) VALUES (:room_id, :user_id, :total_price, :check_in_date, :check_out_date)',$params);
     //Commit transaction
     return $this->getPdo()->commit();
  }

    public function getByUser($userId)
  {
    $params = [
      ':user_id' => $userId
    ];
    return $this->fetchAll('SELECT booking.*, room.*,room_type.title AS room_type
    FROM booking
    INNER JOIN room ON booking.room_id = room.room_id 
    INNER JOIN room_type ON room.type_id =room_type.type_id
    WHERE user_id = :user_id',$params);
  }

}