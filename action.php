<?php
session_start();

if (isset($_GET['action']))
{
    if (isset($_GET['item']))
    {
        if ($_GET['action'] == 'updateStatus')
        {
            include 'conn.php';
            $id = $_GET['item'];

            include 'conn.php';
            // Update item to complete
            $sql = "UPDATE `georescue` SET `status`='Complete' WHERE `id`='" . $id . "'";

            // try to connect and send SQL query with details
            // if unable return error
            try
            {
                $pdo = new PDO($dsn, $username, $password);
                $stmt = $pdo->query($sql);
                if ($stmt === false)
                {
                    $_SESSION['errorMessage'] = "Failed to connect to the database.";
                    header('Location: index.php?code=error');
                }
                else
                {
                    $_SESSION['successMessage'] = "Successfully updated the status.";
                    header('Location: index.php?code=success');
                }
            }
            catch(PDOException $e)
            {
                echo $e->getMessage();
            }
        }
        if ($_GET['action'] == 'deleteItem')
        {
            include 'conn.php';
            $id = $_GET['item'];

            include 'conn.php';
            // Update item to complete
            $sql = "DELETE FROM `georescue` WHERE `id`='" . $id . "'";

            // try to connect and send SQL query with details
            // if unable return error
            try
            {
                $pdo = new PDO($dsn, $username, $password);
                $stmt = $pdo->query($sql);
                if ($stmt === false)
                {
                    $_SESSION['errorMessage'] = "Failed to connect to the database.";
                    header('Location: index.php?code=error');
                }
                else
                {
                    $_SESSION['successMessage'] = "Successfully deleted the item.";
                    header('Location: index.php?code=success');
                }
            }
            catch(PDOException $e)
            {
                echo $e->getMessage();
            }
        }
    }
}



if (empty($_POST["name"]) || empty($_POST["details"]) || empty($_POST["priority"]) 
|| empty($_POST["lat"]) || empty($_POST["long"])) {
    $_SESSION['errorMessage'] = "Please enter all fields";
    header('index.php');
} else {
    $errorMessage = "";
    $name= test_input($_POST["name"]);
    $details = test_input($_POST["details"]);
    $priority = test_input($_POST["priority"]);
    $lat= test_input($_POST["lat"]);
    $long = test_input($_POST["long"]);
    $insert = insertData($name, $details, $priority, $lat, $long);

}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;

}


function insertData($name, $details, $priority, $lat, $long) {
  include 'conn.php';
  try{
      $sql = "INSERT INTO georescue (name, details, priority, latitude, longitude) VALUES (:name, :details, :priority, :lat, :long)";
      // Prepare statement.
      $pdo = new PDO($dsn, $username, $passwordDb);
      $statement = $pdo->prepare($sql);

      // Bind values to the parameter.
      $statement->bindValue(':name', $name);
      $statement->bindValue(':details', $details);
      $statement->bindValue(':priority', $priority);
      $statement->bindValue(':lat', $lat);
      $statement->bindValue(':long', $long);
      // Execute the statement and insertvalues.
      $inserted = $statement->execute();
      header('location: index.php?success');
      $_SESSION['successMessage'] = "data added!";
      echo 'hello';
  // Catch errors
  } catch (PDOException $e) {
      echo $e->getMessage();
      header('location: index.php?error');
  }

}
?>