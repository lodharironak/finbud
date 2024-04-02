<?php 
/*

        Template Name: Rest API form

*/
        $url = 'https://api.eontyre.com/v4/site/calendars/1255/services';
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
          CURLOPT_HTTPHEADER => array(
            'Authorization: c349b450446d41ceb406135a0070384b',
            'Cookie: PHPSESSID=9hok4umgim1o38cdd9u9bb9s12'
          ),
        ));
        $response = curl_exec($curl);

        curl_close($curl);
        $api_data = json_decode($response);
        echo "<pre>";
        print_r($api_data);
        exit();
        // $get_data = $response->id;
        // echo "<pre>";
        // print_r($get_data);
?>