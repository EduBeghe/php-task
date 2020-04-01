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

                $placesData = getPlaceData($latitude, $longitude);

                if (!empty($placesData)) {
                  ?>
                  <select onchange="refreshChart()" id="weekdaySelect">
                    <option value="Mo">Monday</option>
                    <option value="Tu">Tuesday</option>
                    <option value="We">Wednesday</option>
                    <option value="Th">Thursday</option>
                    <option value="Fr">Friday</option>
                    <option value="Sa">Saturday</option>
                    <option value="Su">Sunday</option>
                  </select>

                  <script>
                      var rawData = <?php echo json_encode($placesData, JSON_NUMERIC_CHECK); ?>

                      window.onload = function () {
                          refreshChart()
                      };

                      function refreshChart() {
                          let data = getSelectedDayData();
                          handleWeekdayChange(data);
                      }

                      function getSelectedDayData() {
                          let select = document.getElementById("weekdaySelect");
                          let selectedDayValue = select.value;
                          let selectedDayText = select.options[select.selectedIndex].text;
                          let data = [];
                          for (let step = 0; step < 24; step++) {
                              data[step] = {};
                              if (window.rawData[selectedDayValue][step]) {
                                  data[step]['x'] = window.rawData[selectedDayValue][step]['hour'];
                                  data[step]['y'] = window.rawData[selectedDayValue][step]['occupancyPercent'];
                              }
                          }
                          return data;
                      }

                      function handleWeekdayChange(data) {
                          let select = document.getElementById("weekdaySelect");
                          let selectedDayText = select.options[select.selectedIndex].text;
                          var chart = new CanvasJS.Chart("chartContainer", {
                              animationEnabled: true,
                              exportEnabled: true,
                              theme: "light1", // "light1", "light2", "dark1", "dark2"
                              title:{
                                  text: "Popular Times for " + selectedDayText
                              },
                              data: [{
                                  type: "column", //change type to bar, line, area, pie, etc
                                  //indexLabel: "{y}", //Shows y value on all Data Points
                                  indexLabelFontColor: "#5A5757",
                                  indexLabelPlacement: "outside",
                                  dataPoints: data
                              }]
                          });
                          chart.render();
                      }
                  </script>


                  <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                  <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
                  <?php
                }

          } else {
            echo "No map found.";
          }

        } else {
            ?>
                <label>Please select an address to see the map. Normal requests take about 1-2 minutes.</label>
            <?php
        }
      ?>
  </body>
</html>