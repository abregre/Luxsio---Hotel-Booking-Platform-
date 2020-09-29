<?php

namespace Hotel;

use Hotel\BaseService;
use DateTime;

class Room extends BaseService
{   
    public function get($roomId)
    {
        $params = [
            ':room_id' => $roomId,
          ];
          return $this->fetch('SELECT * FROM room WHERE room_id = :room_id',$params);
        
    }

    public function getCities()
    {
        $cities = [];
       
        $rows = $this->fetchAll('SELECT DISTINCT city FROM room');
        foreach ($rows as $row)
        {
            $cities[] = $row['city'];
        }
       
        return $cities;
    }

    public function getGuests()
    {

        $rows = $this->fetchAll('SELECT DISTINCT count_of_guests FROM room');

        $guests = [];
        foreach ($rows as $row)
        {
            $guests[] = $row['count_of_guests'];
        }
        return $guests;
    }

    //Room Search function
    public function search( $checkInDate , $checkOutDate , $city = '', $typeId = '', $countOfGuests ='', $minPrice= '', $maxPrice= '' )
    {
        $params = [':check_in_date' => $checkInDate->format(DateTime::ATOM), ':check_out_date' => $checkOutDate->format(DateTime::ATOM)]; 

        if(!empty($city))
        {
            $params[':city'] = $city;
        }
        if(!empty($typeId))
        {
            $params[':type_id'] = $typeId; 
        }
        if(!empty($countOfGuests))
        {
            $params[':count_of_guests'] = $countOfGuests; 
        }
        if(!empty($minPrice))
        {
            $params[':min_price'] = $minPrice; 
        }
        if(!empty($maxPrice))
        {
            $params[':max_price'] = $maxPrice; 
        }
     
        $sql = 'SELECT * FROM room WHERE ';
    
         if(!empty($city)){
        $sql .= 'city = :city AND ';
         }
         if(!empty($typeId)){
        $sql .= 'type_id = :type_id AND ';
          }
         if(!empty($countOfGuests)){
        $sql .= 'count_of_guests = :count_of_guests AND ';
          }
         if(!empty($minPrice)){
        $sql .= 'price >= :min_price AND ';
          }
         if(!empty($maxPrice)){
        $sql .= 'price <= :max_price AND ';
          }
        $sql .= 'room_id NOT IN (
                SELECT room_id 
                FROM booking 
                WHERE check_in_date <= :check_in_date AND check_out_date >= :check_out_date
                )';

        return $this->fetchAll($sql, $params);
         
    }

    public function getRoomType($roomId)
    {
      $params = [
        ':room_id' => $roomId
      ];
      return $this->fetch('SELECT DISTINCT title FROM room_type LEFT JOIN room ON room_type.type_id = room.type_id WHERE room_type.type_id = :room_id',$params);
    
    }

}