<?php

  function postal_range($locate, $range){
    // Set account + address parameters
    $auth_key = "TUkJZiXnb3LAL2qf";

    // Get this amount of results back (up to 1000)
    $per_page = 30;

    // Optionally, set a timeout (in ms)
    $timeout = 150000;

    $url = "https://api.pro6pp.nl/v1/range?auth_key=" . $auth_key .
        "&nl_fourpp=" . urlencode($locate) .
        "&per_page=" . urlencode($per_page) .
        "&range=" . urlencode($range);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_TIMEOUT_MS, $timeout);

    $result = curl_exec($ch);
    curl_close($ch);

    if ($result)
    {
    $output = json_decode($result);
    $status = $output->{"status"};
    $postal = array();

    if ($status === "ok")
    {
        foreach($output->{'results'} as $value)
            array_push($postal, $value->nl_fourpp);
        return $postal;
    }
    else
    {
        // Error.
        $message = $output->{"error"}->{"message"};
        print("Error message: " . $message);
    }
    } else {
        // Timeout occured. Either the service is down or you should
        // increase the timeout to at least 150000ms.
        print("Pro6PP is unavailable at this time");
    }

    return 0;
    } 
    

    function postal_locator($locate){
      // Set account + address parameters
      $auth_key = "TUkJZiXnb3LAL2qf";

      // Get this amount of results back (up to 1000)
      $per_page = 30;

      // Optionally, set a timeout (in ms)
      $timeout = 150000;

      $url = "https://api.pro6pp.nl/v1/locator?auth_key=" . $auth_key .
          "&nl_fourpp=" . urlencode($locate) .
          "&target_nl_fourpps=" . urlencode($locate);

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_TIMEOUT_MS, $timeout);

      $result = curl_exec($ch);
      curl_close($ch);

      if ($result)
      {
      $output = json_decode($result);
      $status = $output->{"status"};
      $postal = array();

      if ($status === "ok")
      {
        return $output->{'results'};
      }
      else
      {
          // Error.
          $message = $output->{"error"}->{"message"};
          print("Error message: " . $message);
      }
      } else {
          // Timeout occured. Either the service is down or you should
          // increase the timeout to at least 150000ms.
          print("Pro6PP is unavailable at this time");
      }

      return 0;
    } 
?>