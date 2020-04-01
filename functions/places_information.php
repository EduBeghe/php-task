<?php

  function getPlaceData($latitude, $longitude) {

    $url = 'https://api.apify.com/v2/acts/drobnikj~crawler-google-places/run-sync?token=' . $GLOBALS['APIFY_KEY'];

    $fields = [
        "searchString" => "social security administration office",
        "lat" => strval($latitude),
        "lng" => strval($longitude),
        "zoom" => 10,
        "proxyConfig" => ["useApifyProxy" => true],
        "includeHistogram" => true,
        "includeOpeningHours" => false,
        "includePeopleAlsoSearch" => false,
        "includeImages" => false,
        "includeReviews" => false,
        "maxCrawledPlaces" => 1
    ];

    $data_string = json_encode($fields);

    $ch = curl_init();

    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch,CURLOPT_POST, true);
    curl_setopt($ch,CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch,CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

    $result = curl_exec($ch);
    $resp = json_decode($result, true);

    if (!empty($resp['error'])) {
      echo '<pre> Error Type: '; print_r($resp['error']['type']); echo '</pre>';
      echo '<pre> Error Message: '; print_r($resp['error']['message']); echo '</pre>';
    } else {
      $results_url = 'https://api.apify.com/v2/acts/drobnikj~crawler-google-places/runs/last/dataset/items?token=' . $GLOBALS['APIFY_KEY'] . '&status=SUCCEEDED';
      $result = file_get_contents($results_url);
      $resp = json_decode($result, true);
      if ($resp[0]['popularTimesHistogram']) {
        return $resp[0]['popularTimesHistogram'];
      } else {
        echo '<pre> Error: There is no Popular Times information for the selected Social Security Administration office. Try another one.</pre>';
      }
    }
  }
