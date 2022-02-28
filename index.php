<?php
   // Start the session
   session_start();

   $_SESSION['name'] = $_POST['name'];
   $_SESSION['email'] = $_POST['email'];
   $_SESSION['age']  = $_POST['age'];

   // check if strings are empty
   if (empty($_POST["email"]) || empty($_POST["password"]) || empty($_POST["name"]) || empty($_POST["age"])) {
      $_SESSION['errMessage'] = 'Please enter all fileds';
      header('location: index.php');
   } 

   // post data from signup form
   $email      = checkData($_POST['email']);
   $password   = checkData($_POST['password']);
   $HashedPass = hash('sha512', $password.SALT_STRING);
   $name       = checkData($_POST['name']);
   $age        = checkData($_POST['age']);

   $nameCheck  = checkName($name);
   $ageCheck   = validateAge($age);

   if ($nameCheck == True) {
      $_SESSION['errMessage'] = 'Only Alphabetic chararcters for the name field';
      header('location: index.php');
      exit();
   } elseif ($ageCheck == False) {
      $_SESSION['errMessage'] = 'Invalid Age';
      header('location: index.php');
      exit();
   }

   // calls function to input to DB  
   processData($name, $email, $age, $HashedPass);

   // sanitises and returns data
   function checkData($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
   }
   
   // checks name input for alphabetic chars
   function checkName($data){
   if (!preg_match("/^[a-zA-Z ]*$/",$data)) {  
      return True;
      }  
   return False;
   }
   
   // validates user age, numerical, max and min age
   function validateAge($age) {
    if (preg_match("/^[0-9]+$/", $age)) {
        return true;  
    } else if ($age >= 120){
        return false;
    } else if ($age < 1){
      return false;
    }
    return false;
   }

   // inputs values into database
   // params - name, email, age and SHA 512 hashed password
   // when successful redirects user to success message
   function processData($name, $email, $age, $HashedPass) {
      include 'db-conn.php';
      try{
          $sql = "INSERT INTO customer (name, email, age, password) VALUES (:username, :useremail, :userage, :userpassword)";
          // Prepare statement.
          $pdo = new PDO($dsn, $username, $passwordDb);
          $statement = $pdo->prepare($sql);

          // Bind values to the parameter.
          $statement->bindValue(':username', $name);
          $statement->bindValue(':useremail', $email);
          $statement->bindValue(':userage', $age);
          $statement->bindValue(':userpassword', $HashedPass);
          // Execute the statement and insertvalues.
          $inserted = $statement->execute();
          header('location: success.php');
      // Catch errors
      } catch (PDOException $e) {
          echo $e->getMessage();
      }
   }



?>