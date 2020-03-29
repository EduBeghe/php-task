<?php

    function getGeocodedData() {
        $addressData = explode (",", $_POST['addressSelect']);
        $formattedAddress = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($addressData[0].','.$addressData[2].','.$addressData[4]) . '&key=' . $GLOBALS['GOOGLE_API_KEY'];
        $resp_json = file_get_contents($formattedAddress);
        $resp = json_decode($resp_json, true);

        if($resp['status']=='OK'){

            $lati = isset($resp['results'][0]['geometry']['location']['lat']) ? $resp['results'][0]['geometry']['location']['lat'] : "";
            $longi = isset($resp['results'][0]['geometry']['location']['lng']) ? $resp['results'][0]['geometry']['location']['lng'] : "";
            $placeId = isset($resp['results'][0]['place_id']) ? $resp['results'][0]['place_id'] : "";

            if($lati && $longi){

                $data_arr = array();

                array_push(
                    $data_arr,
                    $lati,
                    $longi,
                    $placeId
                );

              return $data_arr;

            }

        }
    }