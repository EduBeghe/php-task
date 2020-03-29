<?php

  function getPlaceData($placeId) {

    $url = 'https://maps.googleapis.com/maps/api/place/details/json?placeid=' . $placeId . '&key=' . $GLOBALS['GOOGLE_API_KEY'];
    echo $url;
    $resp_json = file_get_contents($url);
    $resp = json_decode($resp_json, true);

    if($resp['status']=='OK'){

      return $resp;
    }
  }
