<?php


require_once __DIR__.'/../../boot/boot.php';

use Hotel\User;
use Hotel\Review; 


//Return to home page if not POST method
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
  header('Location : /');
  return;
}

//Add review
$review = new Review();
$review->addReview($roomId, User::getCurrentUserId(), $_REQUEST['rate'], $_REQUEST['comment']);

//Get all reviews
$roomReviews = $review->getReviewsByRoom($roomId);
$count = count($roomReviews);
//Load User
$user = new User();
$userInfo = $user->getByUserId(User::getCurrentUserId())
?>

  <div class="reviews-header"><h2>Reviews</h2></div>            
  <?php foreach($roomReviews as $count=>$review): ?>
  <div class="reviews-container-body" id="reviews-container-body">
    <span><?php echo sprintf('%d. %s', $count+1, $review['user_name'])?></span>
    <div class="div-reviews">
      <?php 
        for ($i = 0; $i<5 ; $i++){
          if($review['rate']> $i): ?>
          <i class="fa fa-star checked"></i>
          <?php else: ?>
            <i class="fa fa-star"></i>
          <?php endif; 
        } ?>
    </div>
    <br>
    <small>Add time: <?php echo $review['created_time']; ?></small>
    <p>
      <?php echo $review['comment']; ?>
    </p>              
  </div>
  <?php endforeach ?>