<?php 
  require __DIR__.'/../boot/boot.php';
  use Hotel\Room;
  use Hotel\RoomType;
  
  //Get cities
  $room = new Room();
  $cities = $room->getCities();
  //Get rooms
  $type = new RoomType();
  $types = $type->getRoomTypes();

 
?>
<?php include('inc/header.php'); ?>
    <main>
      <div class="main-container">
        <div id="overlay"></div> 
        <form class="search-container" action='results.php' method='get'>
          <h2>Find your destination</h2>
          <div class="errorDates"></div>
          <div class="select-grp">
            <select name="city">
              <option disabled selected>City</option>
              <?php  foreach($cities as $city):?>
                <option value="<?php echo $city;?>"><?php echo $city;?></option>
                <?php endforeach ?>
              </select>
              <select name="room" >
                <option disabled selected >Room Type</option>
                <?php  foreach($types as $type):?>
                  <option value="<?php echo $type['type_id'];?>"><?php echo $type['title']; ?></option>
                  <?php endforeach ?>
                </select>
              </div>
              <div class="date-grp">
                <input placeholder="Check-in Date" class="textbox-n" type="text" onfocus="(this.type='date')" onblur="(this.type='text')" name='checkin' id='checkInDate' required/>
                <input placeholder="Check-out Date" class="textbox-n" type="text" onfocus="(this.type='date')" onblur="(this.type='text')"  name='checkout' id='checkOutDate'  required/>  
              </div>
              <button type='submit' class="btn" id='searchBtn'
              >Search <i class="fas fa-search"></i
              ></button>
            </form>
      </div>
    </main>
   
  <?php include('inc/footer.php'); ?>