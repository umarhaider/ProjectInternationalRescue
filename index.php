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

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
  <img src="geoRescue.jpg" class="rounded float-left img" alt="Logo">
  <p style="margin-left: 5px;"class="mb-0">Geo Rescue</p>
</nav>
</div>

<?php
  session_start();
  // Server login details
  include 'conn.php';
  // SQL Get all users
  $sql = "SELECT * FROM georescue";
   
  // try to connect and send SQL query with details
  // if unable return error 
  try{
   $pdo = new PDO($dsn, $username, $password);
   $stmt = $pdo->query($sql);
   $stmt2 = $pdo->query($sql);
   if($stmt === false){
    die("Error");
   }
   
  }catch (PDOException $e){
    echo $e->getMessage();
  }
?>



<!-- Error Alerts -->
<?php
  // if signup process fails, output error message
  if (isset($_SESSION['errorMessage'])) {
  //echo $_SESSION['login_error_msg'];
  echo "<div id='errortext' class='alert alert-danger alert-dismissible fade show' role='alert'>";
  echo "<strong>Error! </strong>";
  echo $_SESSION['errorMessage'];
  unset($_SESSION['errorMessage']);
  echo  "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
  echo "<span aria-hidden='true'>&times;</span></div>";
  }

?>


<?php
  // if signup process fails, output error message
  if (isset($_SESSION['successMessage'])) {
  //echo $_SESSION['login_error_msg'];
  echo "<div id='successtext' class='alert alert-success alert-dismissible fade show' role='alert'>";
  echo "<strong>Success! </strong>";
  echo $_SESSION['successMessage'];
  unset($_SESSION['successMessage']);
  echo  "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
  echo "<span aria-hidden='true'>&times;</span></div>";
  }

?>
<div id="map"></div>


<!-- MAIN CONTENT - TABLE -->
<div class="container">
  <div class="row">
    <div class="col">
      <h2 style="text-align: center; margin-top: 20px;">Pinpoints</h2>
      <table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
      <div class="table-responsive">
        <thead>
          <tr>
            <th class="th-sm">Longitude
            </th>
            <th class="th-sm">Latitude
            </th>
            <th class="th-sm">Details
            </th>
            <th class="th-sm">Person
            </th>
            </th>
            <th class="th-sm">Priority
            </th>
            <th class="th-sm">Status
            </th>
            <th class="th-sm">Action
            </th>
          </tr>
        </thead>
        <tbody>
        <?php while($row = $stmt2->fetch(PDO::FETCH_ASSOC)) : ?>
        <tr>
           <td><?php echo htmlspecialchars($row['longitude']); ?></td>
           <td><?php echo htmlspecialchars($row['latitude']); ?></td>
           <td><?php echo htmlspecialchars($row['details']); ?></td>
           <td><?php echo htmlspecialchars($row['name']); ?></td>
           <td><?php echo htmlspecialchars($row['priority']); ?></td>
           <td><?php echo htmlspecialchars($row['status']); ?></td>
           <td><a href="action.php?action=updateStatus&item=<?php echo htmlspecialchars($row['id']); ?>">
            <button class="btn btn-success" <?php if($row['status'] == 'Complete'){ echo 'disabled'; } ?> >Complete</button></a><br><br>
            <a href="action.php?action=deleteItem&item=<?php echo htmlspecialchars($row['id']); ?>"><button class="btn btn-danger"><i class="fa-trash-can"></i>Delete</button></a>

            <a onclick="showMarker(<?php echo htmlspecialchars($row['latitude']);?>, <?php echo htmlspecialchars($row['longitude']);?>)" class="btn btn-secondary"><i class="icon-trash"></i>View</a>
        </tr>
        <?php endwhile; ?>
       </tbody>
        </div>
      </table>
    </div>
    <div class="col form" style="margin-top: 25px;">
        <!-- form login -->
        <form class="" method="post" action="form-action.php">
            <!-- Send Screen Details -->
            <span class="h4 mb-4 today" title="Today"></span>
            <p class="h4 mb-4">Enter Pinpoint details - click on map to select area </i></p>

            <!-- Location Latitude-->
            <input type="text" name="lat" value="" class="form-control mb-4" placeholder="Latitude" id="lat" required>

            <!-- Location Longitude -->
            <input type="text" name="long" value="" class="form-control mb-4" placeholder="Longitude" id="long" required>

            <!-- name -->
            <input type="text" name="name" class="form-control mb-4" placeholder="Name" id="name" required maxlength="40">

            <!-- Description -->
            <input type="text" name="details" class="form-control mb-4" placeholder="Details" id="details" maxlength="100" required>

            <!-- Priority -->
            <select class="form-control mb-4" name="priority" id="priority">
            <option value="low">Low</option>
            <option value="medium">Medium</option>
            <option value="high">High</option>
            </select>

            <!-- Submit button -->
            <button class="btn btn-info btn-block my-4" style="background-color: #4723D9;"type="submit">Submit</button>

        </form>
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
var map = L.map('map').setView([51.505, -0.09], 6);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);


var completeIcon = L.icon({
  markerColor: 'green'
});

</script>

<?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)) : ?>
  <script type="text/javascript">
  var lat = "<?php echo htmlspecialchars($row['latitude']); ?>";
  var long = "<?php echo htmlspecialchars($row['longitude']); ?>";
  var text = "<?php echo htmlspecialchars($row['details']); ?>";
    L.marker([lat, long]).addTo(map)
      .bindPopup(text)
      .openPopup();
  var popup = L.popup();
  </script>
<?php endwhile; ?>


<script type="text/javascript">

function showMarker(lat, long) {
  console.log(lat, long);
  map.setView([lat, long], 16);
}


function onMapClick(e) {
    popup
        .setLatLng(e.latlng)
        .setContent("You clicked the map at " + e.latlng.toString())
        .openOn(map);
}

function populateForm(e) {
    var outputValueLat = e.latlng.lat;
    document.getElementById("lat").value = outputValueLat;
    var outputValueLong = e.latlng.lng;
    document.getElementById("long").value = outputValueLong;
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