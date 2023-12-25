<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="passenger_edit.css">
  <title>Passenger Edit</title>
</head>

<body>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <?php
  session_start();
  require_once("../../context.php");
  $context = new context();
  $context->connect();
  $conn = $context->getConnection();
  $stmt = mysqli_prepare($conn, "SELECT * FROM passenger WHERE id = ?");
  mysqli_stmt_bind_param($stmt, "s", $_SESSION['id']);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  if ($result) {
    $row = mysqli_fetch_array($result);
    $passengerId = $row['id'];
    $name = $row['name'];
    $photo = $row['photo'];
    $photo = $row['photo'];
    $email = $row['email'];
    $tel = $row['tel'];
    $passportImg = $row['passportImg'];
  }
  ?>
  <header>
    <div class="header">
      <a href="" class="logo">Flight Booker</a>
      <div class="header-right">
        <a href="../passenger_home/passenger_home.php">Home</a>
        <a href="../flight_search/flight_search.php">Search Flights</a>
        <a href="" class="custom-button active">
          <div class="button-icon">
            <img src="<?php echo $photo; ?>" alt="profile picture">
          </div>
          <div class="button-text">
            <?php echo $name; ?>
          </div>
        </a>
      </div>
    </div>
  </header>

  <div id="profile-container">
    <form action="edit_info.php" method="POST" enctype="multipart/form-data">
      <img src="<?php echo $photo; ?>" alt="Profile Logo" class="center imgr">
      <input type="file" id="myFile1" name="filename1" class="center" style="width: 250px; margin-top: 10px;">

      <h2>Name</h2>
      <input type="text" name="name" placeholder="Enter New Name" style="width: 200px;">

      <h2>Email</h2>
      <input type="text" name="email" placeholder="Enter New Email" style="width: 200px;">

      <h2>Password</h2>
      <input type="password" name="password" placeholder="Enter new password" style="width: 200px;">

      <h2>Telephone</h2>
      <input type="text" name="tel" placeholder="Enter New Number" style="width: 200px;">

      <h2>Passport Image</h2>
      <input type="file" id="myFile2" name="filename2" style="width: 250px; margin-bottom: 10px;">
      <br>
      <img src="<?php echo $passportImg; ?>" alt="Profile Logo" class="imgr">

      <button onclick="editProfile()" class="center apply-btn">Apply Changes</button>
    </form>
  </div>
</body>

</html>