<?php 

    require __DIR__.'/../boot/boot.php';

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
<?php include('inc/header.php'); ?>
    <main>
      <div class="main-container">
        <div id="overlay"></div> 
        <div class="results-page-container">
          <form name="filters" class="filters" action='results.php' method='get'>
            <h2>Find the perfect Hotel</h2>
            <select name="guestsCount" id="guestsCount">
              <option disabled selected>Count of Guests</option>
              <?php  foreach($guests as $guest):?>
                <option value="<?php echo $guest;?>"><?php echo $guest; ?></option>
              <?php endforeach ?>
            </select>
            <select name="room" id="roomType">
              <option disabled selected>Room Type</option>
              <?php  foreach($types as $type):?>
                <option <?php echo $selected_type_id==$type['type_id']?selected:''; ?> value="<?php echo $type['type_id'];?>"><?php echo $type['title']; ?></option>
              <?php endforeach ?>
            </select>
            <select name="city">
              <option disabled selected>City</option>
              <?php  foreach($cities as $city):?>
                <option <?php echo $selectedCity==$city?selected:''; ?> value="<?php echo $city;?>"><?php echo $city;?></option>
              <?php endforeach ?>
            </select>
            <p>
              <label for="amount">Price range</label>
              <div class="inputs">
                <div class="input">
                  <label for="min">Min €</label>
                  <input type="text" id="min" name='min' readonly >
                </div>
                <div class="input">
                  <label for="max">Max €</label>
                  <input type="text" id="max" name='max' readonly >
                </div>
              </div>
            </p>
            <div id="slider-range" true></div>

            <input placeholder="Check-in Date" class="textbox-n" type="text" onfocus="(this.type='date')" onblur="(this.type='text')" id="checkin" name='checkin' value='<?php echo $selectedCheckInDate ?>'/>
            <input placeholder="Check-out Date" class="textbox-n" type="text" onfocus="(this.type='date')" onblur="(this.type='text')" id="checkout" name='checkout' value='<?php echo $selectedCheckOutDate ?>'/>
            <button class="btn" type='submit' id='findHotel'>Find Hotel</button>
          </form>
         
          <div class="results" id="results">
             
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
                  <a href="/room.php?room_id=<?php echo $avail_room['room_id']?>&check_in_date=<?php echo $selectedCheckInDate ?>&check_out_date=<?php echo $selectedCheckOutDate ?>" class="btn">Go to room page</a>
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
  
          </div>
        </div>
      </div>
    </main>
 
    <?php include('inc/footer.php'); ?>