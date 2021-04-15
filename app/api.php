<?php
require_once './key.php';

function reverseGeocoding($lat, $long)
{
  $apikey = $_ENV['APIKEY'];
  $url = "https://api.opencagedata.com/geocode/v1/json?q={$lat}+{$long}&key={$apikey}";

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

function geocoding($location)
{
  //  encode url
  if (!preg_match("/^[a-zA-Z0-9 ]*$/", $location) || !$location) {
    return 'unauthorized';
  }
  $apikey = $_ENV['APIKEY'];
  $location = urlencode($location);
  $url = "https://api.opencagedata.com/geocode/v1/json?q={$location}&key={$apikey}";

  $json = file_get_contents($url);
  $res = json_decode($json, true);
  // var_dump($res);

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

function check_status($res)
{
  if ($res['status']['code'] == 200) {
    return true;
  }
  return false;
}


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
