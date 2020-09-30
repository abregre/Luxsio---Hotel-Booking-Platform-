<?php
  require __DIR__.'/../boot/boot.php';

  header('Access-Control-Allow-Origin: *');
  
  use Hotel\Room;
  use Hotel\Favorite;
  use Hotel\User;
  use Hotel\Review;
  use Hotel\Booking;


  $room = new Room();
  
  $roomId = $_REQUEST['room_id'];
  //Check if room id exists
  if(empty($roomId))
  {
    header('Location: index.php');
    return;
  }
  
  //Load room info
  $roomInfo = $room->get($roomId);
  
  if(empty($roomInfo))
  {
    header('Location: index.php');
    return;
  }

  //Check if user logged
  if (empty(User::getCurrentUserId())){
  header('Location: login.php');
  return;
}

  

  
  $userId = User::getCurrentUserId();
  
  $favorite = new Favorite();
  //Check room if favorite
  $isFavorite = $favorite->isFavorite($roomId, $userId);
  
  //Check for bookings
  $checkInDate = $_REQUEST['check_in_date'];
  $checkOutDate = $_REQUEST['check_out_date'];
  $alreadyBooked =  empty($checkInDate) || empty($checkOutDate) ;
  if(!$alreadyBooked){
    //Look for bookings
    $booking = new Booking();
    $alreadyBooked= $booking->isBooked($roomId,$checkInDate,$checkOutDate);
  }
  //Load Reviews
  $review = new Review();
  $allReviews = $review->getReviewsByRoom($roomId);
  
?>
<?php include('inc/header.php'); ?>
    <main>
      <div class="main-container">
        <div id="overlay"></div>
        <div class="room-page-container">
          <div class="room-page-header">
            <span
              ><?php echo sprintf('%s - %s, %s', $roomInfo['name'], $roomInfo['city'], $roomInfo['area']) ?> | Reviews:
              <?php 
                $roomAvgReview = $roomInfo['avg_reviews'] ; 
                for ($i = 1; $i<=5 ; $i++){
                  if($roomAvgReview>= $i): ?>
                  <i class="fa fa-star checked"></i>
                  <?php else: ?>
                    <i class="fa fa-star"></i>
                  <?php endif; 
                } ?></span>
              || 
              <form action="actions/favorite.php" name="favoriteForm" method="post" id="favoriteForm" class="favoriteForm">
                <input type="hidden" name="room_id" value="<?php echo $roomId ?>">                
                <input type="hidden" name="is_favorite" value="<?php echo $isFavorite?'1':'0'; ?>">
                <div class="search_stars">
                  <button id="fav" type="submit" class="fa fa-heart <?php echo $isFavorite?'selected':''; ?>"></button>
                </div>
              </form>
                     
            <span> Per Night: <?php echo $roomInfo['price'] ?>€</span>
          </div>
          <div class="room-page-info">
            <div class="room-page-photo">
            <img src="images/rooms/<?php echo $roomInfo['photo_url'] ?>">
            </div>
            <div class="room-page-text">
              <h2>Room Description</h2>
              <p>
              <?php echo $roomInfo['description_long'] ?>
              </p>
               <?php if ($alreadyBooked):?> 
                <div class="sold-out">Already Booked</div>
               <?php else: ?>
              <form action="actions/book.php" method="get" name="bookingForm">
                <input type="hidden" name="room_id" value="<?php echo $roomId; ?>">
                <input type="hidden" name="check_in_date" value="<?php echo $checkInDate; ?>">
                <input type="hidden" name="check_out_date" value="<?php echo $checkOutDate; ?>">
                <button type="submit" class="btn btn-lg">Book Now</button>
              </form>
              <?php endif ?>
            </div>
          </div>
          <div class="room-page-specs">
            <div class="room-page-spec" id="guestsCount">
              <i class="fas fa-users"></i><br/><?php echo $roomInfo['count_of_guests'] ?><span>COUNT OF GUESTS</span>
            </div>
            <div class="room-page-spec" id="roomType">
              <i class="fas fa-bed"></i><br /><?php echo $roomInfo['type_id'] ?><span>TYPE OF ROOM</span>
            </div>
            <div class="room-page-spec" id="parking">
              <i class="fas fa-parking"></i> <br /><?php echo $roomInfo['parking']?'Yes':'No' ?><span>PARKING</span>
            </div>
            <div class="room-page-spec" id="wifi">
              <i class="fas fa-wifi"></i> <br /><?php echo $roomInfo['wifi']?'Yes':'No'; ?><span>WIFI</span>
            </div>
            <div class="room-page-spec" id="pet">
              <i class="fas fa-dog"></i> <br /><?php echo $roomInfo['pet_friendly']?'Yes':'No'; ?><span>PET FRIENDLY</span>
            </div>
          </div>
          <div class="map-container">
           <div id="map"></div>
          </div>
          <div class="reviews-container" id="reviews-container">
            <div class="reviews-header"><h2>Reviews</h2></div>  
            <?php if (count($allReviews)>0): ?>          
            <?php foreach($allReviews as $count=>$review): ?>
            <div class="reviews-container-body" id="reviews-container-body">
              <span><?php echo sprintf('%d. %s', $count+1, $review['user_name'])?></span>
              <div class="div-reviews">
                <?php 
                  for ($i = 0; $i<5 ; $i++){
                    if($review['rate']> $i){ ?>
                    <i class="fa fa-star checked"></i>
                    <?php } else { ?>
                      <i class="fa fa-star"></i>
                    <?php }; ?>
                <?php  } ?>
              </div>
              <br>
              <small>Add time: <?php echo $review['created_time']; ?></small>
              <p>
                <?php echo htmlentities($review['comment']); ?>
              </p>              
            </div>
            <?php endforeach ?>
                <?php else: ?>
                <div class="room-no-reviews">There are not reviews for this room yet.</div>
                <?php endif; ?>
          </div>
          <div class="review-add-container">
            <h2>Add review</h2>
            <form class="review-add-body" name="reviewForm" method="post" action="actions/review.php">
              <input type="hidden" name="room_id" value="<?php echo $roomId ?>">              
              <input type="hidden" name="csrf" value="<?php echo User::getCsrf() ?>">
              <fieldset class="rating">
                <input type="radio" name="rate" id="star5" value="5" required/><label for="star5" class="full" title="Awesome - 5 stars"><i class="fa fa-star"></i></label>
                <input type="radio" name="rate" id="star4" value="4" /><label for="star4" class="full" title="Pretty good - 4 stars"><i class="fa fa-star"></i></label>
                <input type="radio" name="rate" id="star3" value="3"/><label for="star3" class="full" title="Meh - 3 stars"><i class="fa fa-star"></i></label>
                <input type="radio" name="rate" id="star2" value="2"/><label for="star2" class="full" title="Kinda bad - 2 stars"><i class="fa fa-star"></i></label>
                <input type="radio" name="rate" id="star1" value="1"/><label for="star1" class="full" title="Sucks big time - 1 star"><i class="fa fa-star"></i></label>
              </fieldset>              
              <textarea name="comment" id="reviewField" rows="5" placeholder="Review" required></textarea>             
                <div id="loadingGif" style="display:none"><img src="images/spinner.gif" width="80" height="80"></div>
              <button type="submit" class="btn btn-lg" id="reviewSubmit">Submit</button>
            </form>
          </div>
        </div>
      </div>
    </main>          
    <footer id="main-footer">
        <p>
          Copyright &copy;
          <script>
            document.write(new Date().getFullYear());
          </script>
          With
          <a href="https://digitalurban.space" target="_blank" style="text-decoration: none;"
            >❤️</a
          > by DigitalUrban
        </p>
      </footer>
      
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="js/main.js"></script>
    <script src="js/search.js"></script>
    <script src="js/room.js"></script>
    <script src="js/validations.js"></script>
    <script>    
    //Map
    function initMap() {
    var hotel = {lat: <?php echo $roomInfo['location_lat'];?>, lng: <?php echo $roomInfo['location_long'];?>};
    var map = new google.maps.Map(document.querySelector('#map'), {zoom: 18, center: hotel});  
    var marker = new google.maps.Marker({position: hotel, map: map});
    }
    </script>
    <script defer
      src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap">
    </script>
    </body>
    </html>
