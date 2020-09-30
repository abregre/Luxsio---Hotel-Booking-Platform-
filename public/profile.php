<?php
  require __DIR__.'/../boot/boot.php';

  use Hotel\Favorite;
  use Hotel\Review;
  use Hotel\User;
  use Hotel\Booking;



  $userId= User::getCurrentUserId();
  
  //Check if user logged
  if(empty($userId))
  {
    header('Location: index.php');
    return;
  }

  //Get all favorites
  $favorite = new Favorite();
  $userFavorites = $favorite->getByUser($userId);

  //Get all reviews
  $review = new Review();
  $userReviews = $review->getByUser($userId);
  
  //Get all bookings
  $booking = new Booking();
  $userBookings = $booking->getByUser($userId);


?>
<?php include('inc/header.php'); ?>
    <main>
      <div class="main-container">
        <div id="overlay"></div> 
        <div class="profile-page-container">
          <div class="profile-nav">
            <div class="profile-img-container">
              <img src="images/profile.jpg" id="profilePhoto" />
            </div>
            <ul class="profile-links">
              <li><span class="profile-link" id="bookingHistory">Booking History</span></li>
              <li ><span class="profile-link" id="reviewHistory">Reviews</span></li>            
              <li><span class="profile-link" id="logout">Logout</span></li>
            </ul>
            <div class="profile-favorites">
              <p>Favorites</p>
              <?php if (count($userFavorites)>0): ?>
                <ol>
                  <?php foreach($userFavorites as $favorite): ?>
                    <li><a href="/room.php?room_id=<?php echo $favorite['room_id'] ?>"><?php echo $favorite['name'] ?></a>
                    <br>
                   
                    </li>
                    <?php endforeach ?>
                </ol>
              <?php else: ?>
              <div class="no-favs">You don't have any favorite hotel</div>
              <?php endif; ?>
            </div>
          </div>
          <div class="profile-content" id="profileBookings">
            <div class="profile-header">
              <h1>Bookings</h1>
            </div>
            <?php if (count($userBookings)>0): ?>
              <?php foreach($userBookings as $booking): ;?>
            <div class="profile-result">
              <div class="result-img">
                <img src="images/rooms/<?php echo $booking['photo_url'] ?>">
              </div>
              <div class="profile-result-info">
                <h2><?php echo $booking['name'] ?></h2>
                <h3><?php echo $booking['city'] ?>, <?php echo $booking['area'] ?></h3>
                <p><?php echo $booking['description_short'] ?></p>
                <a href="/room.php?room_id=<?php echo $booking['room_id']?>" class="btn">Go to room page</a>
              </div>
              <div class="result-details-profile">
                <p class="total-cost">Total Cost: <?php echo $booking['total_price'] ?>€</p>
                <p class="check-in">Check-in Date : <?php echo $booking['check_in_date'] ?></p>
                <p class="check-out">Check-out Date : <?php echo $booking['check_out_date'] ?></p>
                <p class="room-type">Type of Room: <?php echo $booking['room_type'] ?></p>
              </div>
            </div>
              <?php endforeach; ?>
               <?php else: ?>
              <div class="no-bookings">You don't have any bookings</div>
                <?php endif; ?>
          </div>
          <div class="profile-content secret" id="profileReviews">
            <div class="profile-header">
              <h1>Reviews</h1>
            </div>
            <div class="profile-reviews">
               <?php if (count($userReviews)>0): ?>
                <ol>
                  <?php foreach($userReviews as $review): ?>
                    <li><a href="/room.php?room_id=<?php echo $review['room_id'] ?>"><?php echo $review['name'] ?></a>
                    <span>
                      <?php 
                          $roomAvgReview = $roomInfo['avg_reviews'] ; 
                          for ($i = 1; $i<=5 ; $i++){
                            if($review['rate']>= $i): ?>
                            <i class="fa fa-star checked"></i>
                            <?php else: ?>
                              <i class="fa fa-star"></i>
                            <?php endif; 
                          } ?>
                          </span>
                    <br>
                    <p><?php echo $review['comment'];?></p>
                    </li>
                    <?php endforeach ?>
                </ol>
              <?php else: ?>
              <div class="no-reviews">You don't have any reviews</div>
              <?php endif; ?>
            </div>
            </div>           
          </div>
        </div>
      </div>
    </main>
      <?php include('inc/footer.php'); ?>