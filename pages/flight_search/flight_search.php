<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="flight_search.css" />
  <title>Search Flights</title>
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
        <a href="../passenger_home/passenger_home.php">Home</a>
        <a href="" class="active">Search Flights</a>

        <a href="../passenger_profile/passenger_profile.php" class="custom-button">
          <div class="button-icon">
            <img src="<?php echo $photo; ?>" alt="profile picture" />
          </div>
          <div class="button-text">
            <?php echo $name; ?>
          </div>
        </a>
      </div>
    </div>
  </header>

  <div id="profile-container">
    <table id="centered-table">
      <tr>
        <td>
          <h3>From</h3>
        </td>
        <td>
          <select name="from" id="from">
            <option value="3">Tokyo</option>
            <option value="4">Cairo</option>
            <option value="5">Los Angeles</option>
            <option value="6">Madrid</option>
            <option value="7">Dubai</option>
            <option value="8">London</option>
            <option value="9">Berlin</option>
            <option value="10">Paris</option>
          </select>
        </td>
        <td>
          <h3>To</h3>
        </td>
        <td>
          <select name="to" id="to">
            <option value="3">Tokyo</option>
            <option value="4">Cairo</option>
            <option value="5">Los Angeles</option>
            <option value="6">Madrid</option>
            <option value="7">Dubai</option>
            <option value="8">London</option>
            <option value="9">Berlin</option>
            <option value="10">Paris</option>
          </select>
        </td>
        <td style="width: 35%;">
          <button onclick="findFlights()" class="center">
            Search Flights
          </button>
        </td>
      </tr>
    </table>

    <div class="searchR">
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
    var modal = document.getElementById("myModal");
    var btn = document.getElementById("myBtn");
    var span = document.getElementsByClassName("close")[0];
    span.onclick = function () {
      modal.style.display = "none";
    };
    window.onclick = function (event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    };
    //! Search for flight button
    function findFlights() {
      var fromBtn = document.getElementById("from");
      var toBtn = document.getElementById("to");
      $.ajax({
        url: 'searchFlight.php',
        type: 'post',
        data: {
          fromBtn: fromBtn.value,
          toBtn: toBtn.value
        },
        success: function (response) {
          $('.searchR').html(response);
        }
      });
    }
    //! view flight button
    var viewFlightPopUp = document.getElementById("viewFlightPopUp");
    function viewFlightById(x) {
      $.ajax({
        url: 'viewFlight.php',
        type: 'post',
        data: { flightId: x },
        success: function (response) {
          $('.modal-body').html(response);
          viewFlightPopUp.style.display = "block";
        }
      });
    }
    //! Send message to company
    function testFunc(x) {
      var dato = document.getElementById("messageContent");
      jQuery.ajax({
        type: "POST",
        url: 'sendMessage.php',
        dataType: 'json',
        data: {
          companyName: x,
          messageContent: dato.value
        },
        success: function (obj, textstatus) {
          if (obj) {
            viewFlightPopUp.style.display = "none";
            alert("Message Sent!");
          }
          else {
            alert("A problem occurred!");
          }
        },

      });
    }
    //! Pay For flight
    function testFunc2(x) {
      jQuery.ajax({
        type: "POST",
        url: 'payForFlight.php',
        dataType: 'json',
        data: { flightId: x },
        success: function (obj, textstatus) {
          if (obj) {
            viewFlightPopUp.style.display = "none";
            alert("Ticket Bought successfully!");
          }
          else {
            alert("Insuffecient funds!");
          }
        },
      });
    }
    //! Closes the modal for view flight
    var span2 = document.getElementsByClassName("close")[0];
    span2.onclick = function () {
      viewFlightPopUp.style.display = "none";
    }
    window.onclick = function (event) {
      if (event.target == viewFlightPopUp) {
        viewFlightPopUp.style.display = "none";
      }
    }


  </script>
</body>

</html>