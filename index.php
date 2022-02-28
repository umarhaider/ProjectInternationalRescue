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
?>


<!-- MAIN CONTENT - TABLE -->
<div class="container">
  <div class="row">
    <div class="col-sm-2">
    </div>
    <div class="col-sm-8">
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
      <?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)) : ?>
      <tr>
         <td><?php echo htmlspecialchars($row['id']); ?></td>
         <td><?php echo htmlspecialchars($row['name']); ?></td>
         <td><?php echo htmlspecialchars($row['email']); ?></td>
         <td><?php echo htmlspecialchars($row['phone']); ?></td>
      </tr>
      <?php endwhile; ?>
     </tbody>
    </table>
      <div class="text-center"  style="margin-top: 25px;">
      <a href="adduser.html"><button type="button"class="btn btn-secondary">View on map</button></a>
      <a href="adduser.html"><button type="button"class="btn btn-secondary">Mark as complete</button></a>
      <a href="adduser.html"><button type="button"class="btn btn-secondary">Delete</button></a>
      </div>
    </div>
    <div class="col-sm-2">
    </div>
  </div>
</div>


<!-- Enables datatable -->
<script type="text/javascript">
$(document).ready(function () {
  $('#dtBasicExample').DataTable();
  $('.dataTables_length').addClass('bs-select');
});
</script>


<!-- FOOTER -->
<div class="footer-copyright text-center py-3">© 2022 Copyright 
  <a href="https://nathan-hannah.uk/" target="blank_"> Nathan Hannah</a>
</div>

</body>
</html>