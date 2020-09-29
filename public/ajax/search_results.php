<?php 

    require __DIR__.'/../../boot/boot.php';

    use Hotel\Room;
    use Hotel\RoomType;
    
   

    //Get cities
    $room = new Room();
    $cities = $room->getCities();
    $guests = $room->getGuests();
 

    //Get rooms
    $type = new RoomType();
    $types = $type->getRoomTypes();
    
    
    //Get page params
    $selectedCity = $_REQUEST['city'];
    $selected_type_id = $_REQUEST['room'];
    $selectedCheckInDate = $_REQUEST['checkin'];
    $selectedCheckOutDate = $_REQUEST['checkout'];
    $countOfGuests = $_REQUEST['guestsCount'];
    $minPrice = $_REQUEST['min'];
    $maxPrice = $_REQUEST['max'];

    
        
    $avail_rooms = $room->search(new DateTime($selectedCheckInDate), new DateTime($selectedCheckOutDate), $selectedCity, $selected_type_id, $countOfGuests, $minPrice, $maxPrice);

?>

      <div class="results-header">
        <h1>Search Results</h1>
      </div>
      <?php foreach($avail_rooms as $avail_room): ?>
        <div class="result">
          <div class="result-img">
            <img src="images/rooms/<?php echo $avail_room['photo_url'] ?>">
          </div>
          <div class="result-info">
            <h2><?php echo $avail_room['name'] ?></h2>
            <h3><?php echo $avail_room['city'] ?>, <?php echo $avail_room['area'] ?></h3>
            <p><?php echo $avail_room['description_short'] ?></p>
            <a href="/public/room.php?room_id=<?php echo $avail_room['room_id']?>&check_in_date=<?php echo $selectedCheckInDate ?>&check_out_date=<?php echo $selectedCheckOutDate ?>" class="btn">Go to room page</a>
          </div>
          <div class="result-details">
            <p class="price-night">Per Night: <?php echo $avail_room['price'] ?>€</p>
            <p class="guest-number">Count of Guests:<?php echo $avail_room['count_of_guests'] ?></p>
            <p class="room-type">Type of Room:   <?php echo $room->getRoomType($avail_room['type_id'])['title']; ?></p>
          </div>
        </div>
      <?php endforeach ?>
      <?php if(count($avail_rooms)==0): ?>
      <div class="no-rooms">
        <h3>There are no rooms matching your criteria</h3>
      </div>
      <?php endif ?>
  