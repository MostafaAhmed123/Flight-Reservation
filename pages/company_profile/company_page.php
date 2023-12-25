<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <link rel="shortcut icon" href="https://logowik.com/content/uploads/images/my-hero-academia-tv-series7424.jpg">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  <link rel="stylesheet" href="company_page.css">
  <title>Company Profile</title>
  <script>
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
    function openEditFlightPage(index) {
      const table = document.getElementById('flights-container');
      const rows = table.querySelectorAll('tbody tr');
      //console.log(index)
      if (index >= 0 && index < rows.length) {
        const row = rows[index];
        const flightNumber = row.cells[0].textContent;
        const destination = row.cells[1].textContent;
        const departureTime = row.cells[2].textContent;
        const arrivalTime = row.cells[3].textContent;

        // Dynamically generate the URL with the flight index
        const queryParams = `?index=${index}&flightNumber=${encodeURIComponent(flightNumber)}&destination=${encodeURIComponent(destination)}&departureTime=${encodeURIComponent(departureTime)}&arrivalTime=${encodeURIComponent(arrivalTime)}`;

        // Navigate to the other page with the generated URL
        window.location.href = `edit_flight.html${queryParams}`;
      }
    }
    function editProfile() {
    location.assign("edit_company_page.php")
  }
  </script>
</head>

<body>
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
    $bio = $row['bio'];
    $address = $row['address'];
    $companyId = $row['id'];
  }
  ?>
  <header>
    <div class="header">
      <a href="" class="logo">Flight Booker</a>
      <div class="header-right">
        <a href="../company_home/company_home.php">Home</a>
        <a href="" class="active">
          <?php echo "$name"; ?>
        </a>
      </div>
    </div>
  </header>

  <div id="profile-container">
    <img src="<?php echo "$logoImg"; ?>" alt="Company Logo" class="center imgr">
    <h2>Bio</h2>
    <p class="mock-container">
      <?php echo "$bio"; ?>
    </p>
    <textarea name="" id="mock-input" cols="102" rows="6"></textarea>
    <h2>Address</h2>
    <p class="mock-container">
      <?php echo "$address"; ?>
    </p>



    <button id="edit-btn" class="center" onclick="editProfile()">Edit Profile</button>
    <button id="update-btn" onclick="updateProfile()">Update Profile</button>


    <!-- showing flights -->
    <div id="flights" class="editable">
      <h2>Flights List</h2>
      <?php
      $query1 = mysqli_prepare($conn, "SELECT * FROM flight WHERE companyName = ?");
      mysqli_stmt_bind_param($query1, "s", $name);
      mysqli_stmt_execute($query1);
      $res = mysqli_stmt_get_result($query1);
      if (mysqli_num_rows($res) > 0) {
        echo '
          <table class="center-table">
          <thead>
            <tr>
              <th>Flight Name</th>
              <th>Destination</th>
              <th>Arrival Time</th>
              <th>Departure Time</th>
            </tr>
          </thead>
        ';
        while ($row = mysqli_fetch_assoc($res)) {
          $query2 = mysqli_prepare($conn, "SELECT * FROM flight_city WHERE flightID = ? AND type = 'end'");
          mysqli_stmt_bind_param($query2, "i", $row['id']);
          mysqli_stmt_execute($query2);
          $res2 = mysqli_stmt_get_result($query2);
          $row2 = mysqli_fetch_assoc($res2);
          echo '
            <tbody id="flights-container">
              <tr>
                <td>' . $row['name'] . '</td>
                <td>' . $row2['cityName'] . '</td>
                <td>' . $row['startTime'] . '</td>
                <td>' . $row['endTime'] . '</td>
                <td><button class="edit-btn-flight" onclick="openEditFlightPage(0)">Edit</button></td>
              </tr>
            ';
        }
      }
      ?>
    </div>


    <!-- THE Bottom RIGHT MESSAGES -->
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



</body>

</html>