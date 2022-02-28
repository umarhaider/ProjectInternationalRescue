<!DOCTYPE html>
<html lang="en">
<head>
  <title>Geo Rescue</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
  
  <!-- JavaScript -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>

  <!-- mdb -->
  <link rel="stylesheet" href="mdb.min.css" />
  
  <!-- JQuery -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" ></script>


  <!-- Leafly-->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
   integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
   crossorigin=""/>

  <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
   integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
   crossorigin="">
  </script>

  <link rel="stylesheet" href="style.css">
</head>
<body>


<!-- NAVIGATION BAR -->
<div class="navigationbar">
<nav class="navbar navbar-expand-lg navbar navbar-custom">
  <img src="finance-logo.png" class="rounded float-left img" alt="Logo">
  <blockquote class="blockquote text-center navbar-brand">
  <p class="mb-0">Geo Rescue</p>
  <footer class="blockquote-footer"><cite title="Source Title"></cite></footer>
  </blockquote>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
      </li>
      <li class="nav-item">
      </li>
    </ul>
    <span class="navbar-text">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="privacypolicy.html">About</a>
      </li>
    </ul>
    </span>
  </div>
</nav>
</div>

<?php
/*
  // Server login details
  $host = 'localhost';
  $dbname = 'database';
  $username = 'root';
  $password = '';
    
  $dsn = "mysql:host=$host;dbname=$dbname"; 
  // SQL Get all users
  $sql = "SELECT * FROM employees";
   
  // try to connect and send SQL query with details
  // if unable return error 
  try{
   $pdo = new PDO($dsn, $username, $password);
   $stmt = $pdo->query($sql);
   if($stmt === false){
    die("Error");
   }
   
  }catch (PDOException $e){
    echo $e->getMessage();
  }
*/
?>

<div id="map"></div>


<!-- MAIN CONTENT - TABLE -->
<div class="container">
  <div class="row">
    <div class="col">
    <h2 style="text-align: center; margin-top: 20px;">Pinpoints</h2>
    <table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
      <thead>
        <tr>
          <th class="th-sm">Longitude
          </th>

          <th class="th-sm">Latitude
          </th>
          <th class="th-sm">Text
          </th>
          <th class="th-sm">user
          </th>
          </th>
          <th class="th-sm">Priority
          </th>
          <th class="th-sm">Status
          </th>
        </tr>
      </thead>
      <tbody>
      
      <tr>
         <td>1</td>
         <td>2</td>
         <td>3</td>
         <td>4</td>
      </tr>
     </tbody>
    </table>
      <div class="text-center"  style="margin-top: 25px;">
      <a href="adduser.html"><button type="button"class="btn btn-secondary">View on map</button></a>
      <a href="adduser.html"><button type="button"class="btn btn-secondary">Mark as complete</button></a>
      <a href="adduser.html"><button type="button"class="btn btn-secondary">Delete</button></a>
      </div>
    </div>
    <div class="col form" style="margin-top: 25px;">
        <!-- form login -->
        <form class="" method="post" action="login-auth.php">
            <!-- Send Screen Details -->
            <span class="h4 mb-4 today" title="Today"></span>
            <p class="h4 mb-4">Enter Pinpoint details </i></p>

            <!-- Location -->
            <input type="text" name="location" value="" class="form-control mb-4" placeholder="Location" id="location" required >

            <!-- name -->
            <input type="text" name="name" class="form-control mb-4" placeholder="Name" id="name" required maxlength="40">

            <!-- Description -->
            <input type="text" name="details" class="form-control mb-4" placeholder="Details" id="name" required>

            <!-- Submit button -->
            <button class="btn btn-info btn-block my-4" style="background-color: #4723D9;"type="submit">Submit</button>

        </form>
        <!--form login -->
    </div>

  </div>




<!-- Enables datatable -->
<script type="text/javascript">
$(document).ready(function () {
  $('#dtBasicExample').DataTable();
  $('.dataTables_length').addClass('bs-select');
});
</script>


<script type="text/javascript">
var map = L.map('map').setView([51.505, -0.09], 13);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

L.marker([51.5, -0.09]).addTo(map)
    .bindPopup('A pretty CSS3 popup.<br> Easily customizable.')
    .openPopup();


var popup = L.popup();

function onMapClick(e) {
    popup
        .setLatLng(e.latlng)
        .setContent("You clicked the map at " + e.latlng.toString())
        .openOn(map);
}

function populateForm(e) {
    var outputValue = e.latlng.toString();
    document.getElementById("location").value = outputValue;
}

map.on('click', onMapClick);
map.on('click', populateForm);
</script>


<!-- FOOTER -->
<div class="footer-copyright text-center py-3">© 2022 Copyright 
  <a href="https://github.com/umarhaider/ProjectInternationalRescue" target="blank_"> Nathan Hannah, Umar Haider, Harriet Brooke</a>
</div>

</body>
</html>