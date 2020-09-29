<?php

namespace Hotel;


use Hotel\BaseService;


class Favorite extends BaseService
{
  public function getByUser($userId)
  {
    $params = [
      ':user_id' => $userId
    ];
    return $this->fetchAll('SELECT favorite.*, room.name FROM favorite
    INNER JOIN room ON favorite.room_id = room.room_id 
    WHERE user_id = :user_id',$params);
  }

  public function isFavorite($roomId,$userId)
  {
    $params = [
      ':room_id' => $roomId,
      ':user_id' => $userId
    ];
    $favorite = $this->fetch('SELECT * FROM favorite WHERE room_id = :room_id AND user_id = :user_id',$params);
    return !empty($favorite);
  }
  public function addFavorite($roomId,$userId)
  {
    //Prepare
    $params=[
      ':room_id' => $roomId,
      ':user_id' => $userId
    ];
    //Execute
    return $this->execute('INSERT IGNORE INTO favorite (room_id, user_id) VALUES (:room_id, :user_id)', $params);

  }
  public function removeFavorite($roomId,$userId)
  {
    //Prepare
    $params=[
      ':room_id' => $roomId,
      ':user_id' => $userId
    ];
    
    //Execute
    return $this->execute('DELETE FROM favorite WHERE room_id=:room_id AND user_id= :user_id', $params);
     
  }
}