<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="passenger_home.css">
  <title>Passenger Home</title>
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
  }
  ?>
  <header>
    <div class="header">
      <a href="" class="logo">Flight Booker</a>
      <div class="header-right">
        <a href="" class="active">Home</a>
        <a href="../flight_search/flight_search.php">Search Flights</a>
        <a href="../passenger_profile/passenger_profile.php" class="custom-button">
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
    <img src="<?php echo $photo; ?>" alt="Profile Logo" class="center imgr">
    <h2 class="center" style="text-align: center;">
      <?php echo $name; ?>
    </h2>
    <h2>Current Flights</h2>
    <div>
      <?php
      $query1 = "SELECT * FROM passenger_flight_status WHERE passangerID = " . $passengerId . " AND 	status = 0";
      $res = mysqli_query($conn, $query1);
      if (mysqli_num_rows($res) > 0) {
        echo '
        <table class="centered-table">
        <thead>
          <tr>
            <th style="width: 20%">Flight ID</th>
            <th style="width: 20%">Flight Name</th>
            <th style="width: 20%">Arrival Time</th>
            <th style="width: 20%">Departure Time</th>
            <th style="width: 20%"></th>
          </tr>
        </thead>
        <tbody>
        ';
        while ($row = mysqli_fetch_assoc($res)) {
          $query2 = "SELECT * FROM flight WHERE id = " . $row['flightID'];
          $res2 = mysqli_query($conn, $query2);
          $row2 = mysqli_fetch_assoc($res2);
          echo '
          <tr>
            <td>' . $row2["id"] . '</td>
            <td>' . $row2["name"] . '</td>
            <td>' . $row2["startTime"] . '</td>
            <td>' . $row2["endTime"] . '</td>
            <td><button data-id=\'' . $row2["id"] . '\' class="blueButton viewFlight">View Flight</button></td>
          </tr>
          ';
        }
        echo '
        </tbody>
        </table>
        ';
      } else {
        echo '<h2 style="text-align: center; color: #084cdf;">No flights!</h2>';
      }
      ?>
    </div>
    <h2>Completed Flights</h2>
    <div>
      <?php
      $query1 = "SELECT * FROM passenger_flight_status WHERE passangerID = " . $passengerId . " AND 	status = 1";
      $res = mysqli_query($conn, $query1);
      if (mysqli_num_rows($res) > 0) {
        echo '
        <table class="centered-table">
        <thead>
          <tr>
            <th style="width: 20%">Flight ID</th>
            <th style="width: 20%">Flight Name</th>
            <th style="width: 20%">Arrival Time</th>
            <th style="width: 20%">Departure Time</th>
            <th style="width: 20%"></th>
          </tr>
        </thead>
        <tbody>
        ';
        while ($row = mysqli_fetch_assoc($res)) {
          $query2 = "SELECT * FROM flight WHERE id = " . $row['flightID'];
          $res2 = mysqli_query($conn, $query2);
          $row2 = mysqli_fetch_assoc($res2);
          echo '
          <tr>
            <td>' . $row2["id"] . '</td>
            <td>' . $row2["name"] . '</td>
            <td>' . $row2["startTime"] . '</td>
            <td>$' . $row2["endTime"] . '</td>
            <td><button data-id=\'' . $row2["id"] . '\' class="blueButton viewFlight">View Flight</button></td>
          </tr>
          ';
        }
        echo '
        </tbody>
        </table>
        ';
      } else {
        echo '<h2 style="text-align: center; color: #084cdf;">No flights!</h2>';
      }
      ?>
    </div>
  </div>

  <div id="viewFlightPopUp" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>
      <div class="modal-body">

      </div>
    </div>
  </div>

  <script>
    var viewFlightPopUp = document.getElementById("viewFlightPopUp");
    var btn = document.getElementById("myBtn");
    var span2 = document.getElementsByClassName("close")[0];
    span2.onclick = function () {
      viewFlightPopUp.style.display = "none";
    }
    window.onclick = function (event) {
      if (event.target == viewFlightPopUp) {
        viewFlightPopUp.style.display = "none";
      }
    }
    //! View flight
    $(document).ready(function () {
      $('.viewFlight').click(function () {
        var userid = $(this).data('id');
        $.ajax({
          url: 'viewFlight.php',
          type: 'post',
          data: { flightId: userid },
          success: function (response) {
            $('.modal-body').html(response);
            viewFlightPopUp.style.display = "block";
          }
        });
      });
    });
    
  </script>
</body>

</html>