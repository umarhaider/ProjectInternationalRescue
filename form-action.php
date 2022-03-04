<?php
   // Start the session
   session_start();

   $_SESSION['name'] = $_POST['name'];
   $_SESSION['email'] = $_POST['email'];
   $_SESSION['age']  = $_POST['age'];

   // check if strings are empty
if (empty($_POST["name"]) || empty($_POST["details"]) || empty($_POST["priority"]) 
|| empty($_POST["lat"]) || empty($_POST["long"])) {
      $_SESSION['errorMessage'] = "Please enter all fields";
      header('location: index.php');
      exit();
} 

   // post data from signup form
   $name     = checkData($_POST["name"]);
   $details  = checkData($_POST["details"]);
   $priority = checkData($_POST["priority"]);
   $lat      = checkData($_POST["lat"]);
   $long     = checkData($_POST["long"]);


   // calls function to input to DB  
   processData($name, $details, $priority, $lat, $long);

   // sanitises and returns data
   function checkData($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
   }
   
   // inputs values into database
   // params - name, email, age and SHA 512 hashed password
   // when successful redirects user to success message
   function processData($name, $details, $priority, $lat, $long) {
      include 'conn.php';

      //if $priority == '1'
      try{
         $sql = "INSERT INTO georescue (name, details, priority, latitude, longitude, status) VALUES (:name, :details, :priority, :lat, :long, :status)";
         // Prepare statement.
         $pdo = new PDO($dsn, $username, $password);
         $statement = $pdo->prepare($sql);

         // Bind values to the parameter.
         $statement->bindValue(':name', $name);
         $statement->bindValue(':details', $details);
         $statement->bindValue(':priority', $priority);
         $statement->bindValue(':lat', $lat);
         $statement->bindValue(':long', $long);
         $statement->bindValue(':status', 'incomplete');
         // Execute the statement and insertvalues.
         $inserted = $statement->execute();
         $_SESSION['successMessage'] = 'New Pinpoint Added!';
         header('location: index.php');
      // Catch errors
      } catch (PDOException $e) {
          echo $e->getMessage();
          $_SESSION['errorMessage'] = 'database issue';
      }
   }



?>