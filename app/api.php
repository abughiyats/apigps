<?php
require_once './key.php';

// reverse geocoding function
function reverseGeocoding($lat, $long)
{
  //get apikey from .env
  $apikey = $_ENV['APIKEY'];
  // opencage api
  $url = "https://api.opencagedata.com/geocode/v1/json?q={$lat}+{$long}&key={$apikey}";
  //get json response
  $json = file_get_contents($url);
  //decode the json
  $res = json_decode($json, true);
  //if unable to geocode given address
  if (!check_status($res)) {
    return $data = [
      'status' => '400',
      'data' => result($res)
    ];
  }
  //geocode response "OK"
  $data = [
    'status' => check_status($res) ? '200' : '400',
    'data' => result($res)
  ];
  // encode data
  $data = json_encode($data, JSON_PRETTY_PRINT);
  //create data.json file 
  file_put_contents('data.json', $data);
  return $data;
}

// forward geocoding function
function geocoding($location)
{
  // remove non-alphanumeric character or field can't be empty
  if (!preg_match("/^[a-zA-Z0-9 ]*$/", $location) || !$location) {
    return 'unauthorized';
  }
  $apikey = $_ENV['APIKEY'];
  $location = urlencode($location);
  $url = "https://api.opencagedata.com/geocode/v1/json?q={$location}&key={$apikey}";
  $json = file_get_contents($url);
  $res = json_decode($json, true);

  if (!check_status($res)) {
    return $data = [
      'status' => '400',
      'data' => result($res)
    ];
  }

  $data = [
    'status' => check_status($res) ? '200' : '400',
    'data' => result($res)
  ];
  $data = json_encode($data, JSON_PRETTY_PRINT);
  file_put_contents('data.json', $data);
  return $data;
}

// function to create data[coordinate and district]
function result($res)
{
  $data = [];
  $latitude = isset($res['results'][0]['geometry']['lat']) ? $res['results'][0]['geometry']['lat'] : "";
  $longitude = isset($res['results'][0]['geometry']['lng']) ? $res['results'][0]['geometry']['lng'] : "";
  $formatted = isset($res['results'][0]['formatted']) ? $res['results'][0]['formatted'] : "";

  if ($latitude && $longitude && $formatted) {
    $data = [
      'latitude'  => $latitude,
      'longitude' => $longitude,
      'district' => $formatted
    ];
    return $data;
  }
  return $data;
}

// check status code api
function check_status($res)
{
  if ($res['status']['code'] == 200) {
    return true;
  }
  return false;
}

// submit statement
if (isset($_POST['search'])) {
  if (!empty($_POST["location"])) {
    $location = $_POST["location"];
    geocoding($location);
  } else {
    $lat = $_POST["latitude"];
    $long = $_POST["longitude"];
    reverseGeocoding($lat, $long);
  }
}
