<!DOCTYPE html>
<html lang="en">
<head>
  <title>Geo Rescue</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="shortcut icon" type="image/png" href="assets/favicon-32x32.png"/>

  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
  
  <!-- JavaScript -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
  
  <!-- JQuery -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
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

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol/dist/L.Control.Locate.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol/dist/L.Control.Locate.min.js" charset="utf-8"></script>
</head>
<body onload="resetMap()">

<!-- NAVIGATION BAR -->
<div class="navigationbar">
<nav id="header" class="navbar-expand-lg navbar navbar-custom">
  <img src="assets/geoRescue.jpg" class="rounded float-left img" alt="Logo">
  <p style="margin-left: 5px;"class="mb-0">Geo Rescue</p>
  <div class="ml-auto"><a><button id="resetbtn"class="btn btn-secondary btn-block " onclick="resetMap();">Reset Map View</button></a></div>
  <div class="ml-auto" id="time"><p><i>Last updated:</i></p></div>
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
  echo "<div id='errortext' class='alert-text alert alert-danger alert-dismissible fade show' role='alert'>";
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
  echo "<div id='successtext' class='alert-text alert alert-success alert-dismissible fade show' role='alert'>";
  echo "<strong>Success! </strong>";
  echo $_SESSION['successMessage'];
  unset($_SESSION['successMessage']);
  echo  "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
  echo "<span aria-hidden='true'>&times;</span></div>";
  }

?>

<script type="text/javascript">
  function onMapClick(e) {
    popup
        .setLatLng(e.latlng)
        .setContent("At " + e.latlng.toString())
        .openOn(map);
}

</script>

<!-- MAIN CONTENT - TABLE -->
<div class="container-fluid" width="100%">
  <div class="row">
    <div class="col-8">
      <div id="map"></div>
      <div id="location"></div>
    </div>
    <div class="col-4 form">
        <!-- form login -->
        <form class="form" method="post" action="form-action.php">
            <p class="h4 mb-4">Create new Pinpoint - Select Location on map </i></p>

            <!-- Location Latitude-->
            <input type="text" name="lat" value="" class="form-control mb-4" placeholder="Latitude" id="lat" readonly required>

            <!-- Location Longitude -->
            <input type="text" name="long" value="" class="form-control mb-4" placeholder="Longitude" id="long" readonly required>

            <!-- name -->
            <input type="text" name="name" class="form-control mb-4" placeholder="Your Name" id="name" required maxlength="40">

            <!-- Description -->
            <textarea type="text" name="details" class="form-control mb-4 textarea" placeholder="Details" id="details" maxlength="100" rows="2" required></textarea>

            <!-- Priority -->
            <select class="form-control mb-4" name="priority" id="priority">
            <option value="low">Priority Low</option>
            <option value="medium">Priority Medium</option>
            <option value="high">Priority High</option>
            </select>
            <div class="question1">
            <p>What are priority levels?</p>
            </div>
             <div class="answer1">
              Priority Low - No urgency required, this could be general information <br>
              Priority Medium - Attention required but no immidiate danger<br>
              Priority high - A severe risk, action should be taken immidiately</div>
            <!-- Submit button -->
            <button class="btn btn-secondary btn-block my-4" type="submit">Submit</button>
        </form>
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <h2 style="text-align: center; margin-top: 20px;">All Pinpoints</h2>
      <table id="dtBasicExample" width="100%" class="table table-hover" cellspacing="0" >
        <thead>
          <tr>
            <th class="th-sm">Longitude
            </th>
            <th class="th-sm">Latitude
            </th>
            <th class="th-sm">Details
            </th>
            <th class="th-sm">User Created
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
           <td class="output"><?php echo htmlspecialchars($row['longitude']); ?></td>
           <td class="output"><?php echo htmlspecialchars($row['latitude']); ?></td>
           <td class="output"><?php echo htmlspecialchars($row['details']); ?></td>
           <td class="output"><?php echo htmlspecialchars($row['name']); ?></td>
           <td class="output"> <?php if ($row['priority'] == 'low') {
              echo '<span class="low">' . htmlspecialchars($row['priority']) . '<span>'; 
            } else if ($row['priority'] == 'medium') {
              echo '<span class="medium">' . htmlspecialchars($row['priority']) . '<span>'; 
            } else {
              echo '<span class="high">' . htmlspecialchars($row['priority']) . '<span>'; 
            } ?>
            </td>
           <td><?php echo htmlspecialchars($row['status']); ?></td>
           <td><a href="action.php?action=updateStatus&item=<?php echo htmlspecialchars($row['id']); ?>">
            <button class="btn btn-success" <?php if($row['status'] == 'Complete'){ echo 'disabled'; } ?> >Complete</button></a><br><br>
            <a href="action.php?action=deleteItem&item=<?php echo htmlspecialchars($row['id']); ?>"><button class="btn btn-danger"><i class="fa-trash-can"></i>Delete</button><i class="fa-solid fa-trash-can"></i></a>

            <a onclick="showMarker(<?php echo htmlspecialchars($row['latitude']);?>, <?php echo htmlspecialchars($row['longitude']);?>)" class="btn btn-secondary"></i>View</a> 

        </tr>
        <?php endwhile; ?>
        </tbody>
        </div>
      </table>
    </div>
  </div>


<script type="text/javascript">

  // get a new date (locale machine date time)
  var date = new Date();
  // get the date as a string
  var n = date.toDateString();
  // get the time as a string
  var time = date.toLocaleTimeString();

  // find the html element with the id of time
  // set the innerHTML of that element to the date a space the time
  document.getElementById('time').innerHTML = 'Map Last updated: ' + n + ' ' + time;
  var x = document.getElementById("location");
  function getLocation() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(showPosition);
    } else {
      x.innerHTML = "Geolocation is not supported by this browser.";
    }
  }

  function showPosition(position) {
    map.setView([position.coords.latitude, position.coords.longitude], 16)
    var popup = L.popup()
    .setLatLng([position.coords.latitude, position.coords.longitude])
    .setContent("You are here")
    .openOn(map);
    var outputValueLat = position.coords.latitude;
    document.getElementById("lat").value = outputValueLat;
    var outputValueLong = position.coords.longitude;
    document.getElementById("long").value = outputValueLong;
    
  }
</script>


<!-- Enables datatable -->
<script type="text/javascript">

$(document).ready(function() {
    $('#dtBasicExample').DataTable( {
        "scrollY":        "50vh",
        "scrollCollapse": true,
        "paging":         true
    } );
    $('.dataTables_length').addClass('bs-select');
} );

</script>


<script type="text/javascript">
var map = L.map('map').setView([51.505, -0.01], 5);


function resetMap() {
  map.setView([51.505, -0.01], 5);
}


L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 15,
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

//need license to use
googleStreets = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}',{
    maxZoom: 20,
    subdomains:['mt0','mt1','mt2','mt3']
});

//googleStreets.addTo(map);
L.control.locate().addTo(map);


</script>

<?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)) : ?>
  <script type="text/javascript">

  var LeafIcon = L.Icon.extend({
      options: {
         iconSize:     [38, 95],
         shadowSize:   [50, 64],
         iconAnchor:   [22, 94],
         shadowAnchor: [4, 62],
         popupAnchor:  [-3, -76]
      }
  });

  var greenIcon = new LeafIcon({
      iconUrl: '123',
      shadowUrl: '123'
  })

  var lat = "<?php echo htmlspecialchars($row['latitude']); ?>";
  var long = "<?php echo htmlspecialchars($row['longitude']); ?>";
  var text = "<?php echo htmlspecialchars($row['details']); ?>";
  var user = "<?php echo htmlspecialchars($row['name']); ?>";
  var priority = "<?php echo htmlspecialchars($row['priority']); ?>";
    L.marker([lat, long], {icon: greenIcon}).addTo(map)
      .bindPopup(text + '<br> user-' + user + '<br>Priority-' + priority)
      .openPopup();
  var popup = L.popup();
  </script>
<?php endwhile; ?>


<script type="text/javascript">

function showMarker(lat, long) {
  map.setView([lat, long], 16);
  window.scrollTo(0, 0);
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
<div class="footer-copyright text-center py-3">© 2022 Copyright Project GeoRescue -
  <a href="https://github.com/nathanhannah122/Project-GeoRescue" target="blank_"> Nathan Hannah, Umar Haider, Harriet Brooke</a>
</div>

</body>
</html>