<?php

  function getPlaceData($placeId, $latitude, $longitude) {

    $url = 'https://api.apify.com/v2/acts/drobnikj~crawler-google-places/runs?token=' . $GLOBALS['APIFY_KEY'];

    $fields = [
        'searchString' => 'place_id:'. $placeId,
        'proxyConfig' => array('useApifyProxy' => true),
        'maxCrawledPlaces' => 5,
        "includeHistogram" => true,
    ];

    $data_string = json_encode($fields);

    $ch = curl_init();

    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch,CURLOPT_POST, true);
    curl_setopt($ch,CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch,CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec($ch);
    $resp = json_decode($result, true);

    echo '<pre>'; print_r($resp); echo '</pre>';

    return $resp;
  }
