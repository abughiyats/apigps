<?php
require_once "api.php";
$json = file_get_contents("./data.json");
$data = json_decode($json, true);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <script src="json-viewer.js"></script>
  <link rel="stylesheet" href="json-viewer.css">
  <style>
    #app {
      padding: 20px 100px;
    }

    html,
    body {
      height: 100%;
      margin: 0;
      padding: 0;
    }
  </style>
  <title>Maps API</title>
</head>

<body>
  <div id="app">
    <h4 style="text-align: center;">Eureka Test Code</h4>
    <div class="row my-3">
      <div class="col">
        <div class="card">
          <div class="card-body">
            <form method="POST"">
              <label for="">Search Coordinate</label><br>
              <input type=" text" name="latitude" placeholder="Enter latitude">
              <input type="text" name="longitude" placeholder="Enter longitude">
              <input type="submit" name="search">
            </form>

            <form method="POST" class="my-3">
              <label for="">Search location</label><br>
              <form method="POST">
                <input type="text" name="location" placeholder="Enter location">
                <input type="submit" name="search">
              </form>
            </form>
          </div>
        </div>
      </div>

      <div class="col">
        <div class="card">
          <div class=" card-body">
            <h5 class="card-title">JSON Formatted</h5>
            <samp>
              <div id="json"><?= $json ?></div>
            </samp>
          </div>
        </div>
      </div>
    </div>

  </div>

</body>

</html>