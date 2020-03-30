<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <title>PHP Task</title>
      <style>
        <?php include 'css/main.css'; ?>
      </style>
  </head>
  <body>
      <?php include("functions/addresses_manipulation.php");?>
      <?php include("functions/config.php");?>
      <?php include("functions/address_geolocation.php");?>
      <?php include("functions/places_information.php");?>
      <h1>PHP Task</h1>
      <br>
      <label>Please select one of the following US Social Security Administration Offices Address</label>
      <br>
      <br>
      <form method="post" action="">
          <select name="addressSelect" onChange="this.form.submit()" id="addressSelect">
              <option value="">Choose one</option>
              <?php
                foreach($ADDRESSES as $address) { ?>
                    <option value="<?= $address ?>" <?php if ($_POST["addressSelect"] === $address) echo 'selected'; ?>><?= $address ?></option>
                    <?php
                }
              ?>
          </select>
      </form>
      <br>
      <?php
        if (!empty($_POST['addressSelect'])) {
          $data_arr = getGeocodedData();
          if($data_arr){
          $latitude = $data_arr[0];
          $longitude = $data_arr[1];
          $placeId = $data_arr[2];

          ?>
              <div id="map"></div>

              <?php echo '<script async defer type="text/javascript" src="https://maps.google.com/maps/api/js?key='.$GLOBALS['GOOGLE_API_KEY'].'&callback=initMap"></script>'; ?>
              <script type="text/javascript">
                  function initMap() {
                      var centerLocation = {lat: <?php echo $latitude?>, lng: <?php echo $longitude?>};
                      var map = new google.maps.Map(
                          document.getElementById('map'), {zoom: 18, center: centerLocation});

                      var marker = new google.maps.Marker({position: centerLocation, map: map});
                  }
              </script>

                <h3>Popular Times</h3>

                <br>
                <br>

            <?php

                $placesData = getPlaceData($placeId, $latitude, $longitude);

          } else {
            echo "No map found.";
          }

        } else {
            ?>
                <label>Please select an address to see the map.</label>
            <?php
        }
      ?>
  </body>
</html>