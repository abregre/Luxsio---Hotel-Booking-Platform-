
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
