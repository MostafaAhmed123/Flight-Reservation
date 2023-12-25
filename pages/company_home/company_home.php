<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  <link rel="stylesheet" href="company_home.css">
  <title>Company Home</title>
</head>

<body>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <!---------------------------------------  Initializing the Main Page Data ---------------------------------------->
  <?php
  session_start();
  require_once("../../context.php");
  $context = new context();
  $context->connect();
  $conn = $context->getConnection();
  $stmt = mysqli_prepare($conn, "SELECT * FROM company WHERE email = ?");
  mysqli_stmt_bind_param($stmt, "s", $_SESSION['email']);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  if ($result) {
    $row = mysqli_fetch_array($result);
    $name = $row['name'];
    $logoImg = $row['logoImg'];
    $companyId = $row['id'];
  }
  ?>
  <!-------------------------------------------------  The header ------------------------------------------------->
  <header>
    <div class="header">
      <a href="" class="logo">Flight Booker</a>
      <div class="header-right">
        <a href="" class="active">Home</a>
        <a href="../company_profile/company_page.php">
          <?php echo "$name"; ?>
        </a>
      </div>
    </div>
  </header>
  <!-----------------------------------------  The body of the website -------------------------------------------->
  <div id="profile-container">
    <img src="<?php echo "$logoImg"; ?>" alt="Profile Logo" class="center imgr">
    <h2 class="center" style="text-align: center;">
      <?php echo "$name"; ?>
    </h2>
    <button id="addFlightBtn" class="center blueButton">Add Flight</button>
    <!-------------------------------------------------  Array of flights ------------------------------------------------->
    <h2 class="center" style="text-align: center;">Flights</h2>
    <div>
      <?php
      $stmt = mysqli_prepare($conn, "SELECT id, name, fees, completed FROM flight WHERE companyName = ?");
      mysqli_stmt_bind_param($stmt, "s", $name);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if ($result->num_rows > 0) {
        echo '
        <table class="center-table">
        <thead>
          <tr>
            <th style="width: 15%">Flight ID</th>
            <th style="width: 30%">Flight</th>
            <th style="width: 15%">Completed</th>
            <th style="width: 20%">Fee</th>
            <th style="width: 20%"></th>
          </tr>
        </thead>
        <tbody>
        ';
        while ($row = $result->fetch_assoc()) {
          echo '
          <tr>
            <td>' . $row["id"] . '</td>
            <td>' . $row["name"] . '</td>
            <td>' . ($row["completed"] ? 'Yes' : 'No') . '</td>
            <td>$' . $row["fees"] . '</td>
            <td><button data-id=\'' . $row["id"] . '\' class="blueButton viewFlight">View Flight</button></td>
          </tr>
          ';
        }
        echo '
        </tbody>
        </table>
        ';
      } else {
        echo '<h2 style="text-align: center; color: #084cdf;">No flights! <br> click the add flight button</h2>';
      }
      ?>
    </div>
    <!----------------------------------------  The bottom right Message bubble ---------------------------------->
    <button id="openForm" class="button-five open-button" onclick="openForm()"><i class="fa fa-comments"
        style="color: white;"></i></button>
    <div class="form-popup form-container" id="myForm">
      <?php
      $stmt = "SELECT * FROM messages WHERE companyId =" . $companyId;
      $res = mysqli_query($conn, $stmt);
      if (mysqli_num_rows($res) > 0) {
        while ($row = mysqli_fetch_assoc($res)) {
          echo '
          <div class="message-container">
            <span class="bold">From: </span>
            <span>' . $row['passengerName'] . '</span>
            <br>
            <span class="bold">Message: </span>
            <p style="margin-top: 10px;">' . $row['content'] . '</p>
          </div>
          ';
        }
      } else {
        echo '<h2 style="text-align: center; color: #084cdf; margin-top: 180px;">You have no messages!</h2>';
      }
      ?>
      <button id="closeForm" class="button-five open-button" onclick="closeForm()"><i class="fa fa-comments"
          style="color: white;"></i></button>
    </div>
  </div>

  <!------------------------------------- Pop up menu for add flight button ----------------------------------->
  <div id="addFlightPopUp" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>
      <form action="addFlight.php" method="post">
        <h1 style="margin-top: 10px;">Add Flight</h1>
        <table class="addFlight">
          <tr>
            <td><strong>ID:</strong></td>
            <td><input id="flightId" style="width:220px;" name="flightId" type="text" placeholder="ID of flight"
                required></td>
          </tr>
          <tr>
            <td><strong>Name:</strong></td>
            <td><input id="flightName" style="width:220px;" name="flightName" type="text" placeholder="Name of flight"
                required></td>
          </tr>
          <tr>
            <td><strong>Capacity:</strong></td>
            <td><input id="flightSize" style="width:220px;" name="flightSize" type="number" placeholder="size of flight"
                required></td>
          </tr>
          <tr>
            <td><strong>Fee:</strong></td>
            <td><input id="flightFee" style="width:220px;" name="flightFee" type="number"
                placeholder="Fee for flight ticket" required></td>
          </tr>
          <tr>
            <td><strong>Start Time: </strong></td>
            <td><input id="flightStart" name="flightStart" type="datetime-local" value="2023-12-23T12:00" required></td>
          </tr>
          <tr>
            <td><strong>End Time: </strong></td>
            <td><input id="flightEnd" name="flightEnd" type="datetime-local" value="2023-12-23T12:00" required></td>
          </tr>
          <tr>
            <td><strong>Cities passed: </strong></td>
            <td>
              <select name="cityNum" id="cityNum" onchange="genCity()" required>
                <option value="">None</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
              </select>
            </td>
          </tr>
        </table>
        <table class="addFlight" id="lastI">
        </table>
        <button type="submit" class="center blueButton">Add flight</button>
      </form>
    </div>
  </div>

  <!------------------------------------- Pop up menu for the view flight button ----------------------------------->
  <div id="viewFlightPopUp" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>
      <div class="modal-body">

      </div>
    </div>
  </div>


  <script>
    //! The bottom right Message bubble
    function openForm() {
      document.getElementById("myForm").style.display = "block";
      document.getElementById("openForm").style.display = "none";
      document.getElementById("closeForm").style.display = "block";
    }
    function closeForm() {
      document.getElementById("myForm").style.display = "none";
      document.getElementById("openForm").style.display = "block";
      document.getElementById("closeForm").style.display = "none";
    }
    //!Pop up menu for the add flight button 
    var addFlightPopUp = document.getElementById("addFlightPopUp");
    var addFlightBtn = document.getElementById("addFlightBtn");
    var span1 = document.getElementsByClassName("close")[0];
    addFlightBtn.onclick = function () {
      addFlightPopUp.style.display = "block";
    }
    span1.onclick = function () {
      addFlightPopUp.style.display = "none";
    }
    function genCity() {
      var cat = '';
      const cityNum = document.getElementById("cityNum");
      var node = document.getElementById("lastI");
      for (let i = 0; i < cityNum.value; i++) {
        cat += `
          <tr>
          <td><strong>City ${i + 1}: </strong></td>
          <td>
            <select name="cityNum${i}" id="cityNum${i}">
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
          </tr>
        `;
      }
      node.innerHTML = cat;
    }
    //! Pop up menu for the view flight button 
    var viewFlightPopUp = document.getElementById("viewFlightPopUp");
    var span2 = document.getElementsByClassName("close")[1];
    span2.onclick = function () {
      viewFlightPopUp.style.display = "none";
    }
    //! view flight button
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
    //! Closes the modal for both the add flight and view flight
    window.onclick = function (event) {
      if (event.target == viewFlightPopUp) {
        viewFlightPopUp.style.display = "none";
      }
      if (event.target == addFlightPopUp) {
        addFlightPopUp.style.display = "none";
      }
    }
    function testFunc(x) {
      jQuery.ajax({
        type: "POST",
        url: 'cancelFlight.php',
        dataType: 'json',
        data: { flightId: x },
        success: function (obj, textstatus) {
          if (obj) {
            viewFlightPopUp.style.display = "none";
            alert("Flight Canceled Successfully!");
            location.reload();
          }
        }
      });
    }
  </script>
</body>

</html>