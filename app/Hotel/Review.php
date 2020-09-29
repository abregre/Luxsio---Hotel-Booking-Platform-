<?php

namespace Hotel;

use Hotel\BaseService;
use PDO;

class Review extends BaseService
{
  public function addReview($roomId, $userId, $rate, $comment)
  {
    //Start Transaction
    $this->getPdo()->beginTransaction();
     //Prepare
     $params=[
      ':room_id' => $roomId,
      ':user_id' => $userId,
      ':rate' => $rate,
      ':comment' => $comment,
    ];
    //Execute
    $this->execute('INSERT INTO review(room_id, user_id, rate,comment) VALUES (:room_id, :user_id,:rate,:comment)', $params);
    //Update room average reviews
    $params = [
      ':room_id' => $roomId,
    ];
    $roomAvg = $this->fetch('SELECT avg(rate) AS avg_reviews,count(*) AS count FROM review WHERE room_id = :room_id', $params);

    $params = [
      ':room_id' => $roomId,
      ':avg_reviews' => $roomAvg['avg_reviews'],
      ':count_reviews' => $roomId['count']
    ];
    $this->execute('UPDATE room SET avg_reviews = :avg_reviews, count_reviews = :count_reviews WHERE room_id = :room_id',$params);
    //Commit Transaction
    return $this->getPdo()->commit();
  }
  public function getByUser($userId)
  {
    $params = [
      ':user_id' => $userId
    ];

    return $this->fetchAll('SELECT review.*, room.name FROM review
    INNER JOIN room ON review.room_id = room.room_id 
    WHERE user_id = :user_id',$params);
  }

  public function getReviewsByRoom($roomId)
  {
      $params = [
      ':room_id' => $roomId
    ];

    return $this->fetchAll('SELECT review.*,user.name AS user_name FROM review 
INNER JOIN user ON review.user_id = user.user_id
WHERE room_id = :room_id',$params);
  }
}