<?php
session_start();
require_once("../../context.php");
$context = new context();
$context->connect();
$conn = $context->getConnection();

$fromBtn = $_POST['fromBtn'];
$toBtn = $_POST['toBtn'];
$name = $_SESSION['name'];

$stmt = "SELECT DISTINCT flightID FROM flight_city";
$res = mysqli_query($conn, $stmt);
$isFlight = FALSE;
$isThisFlight = FALSE;
$counter = 0;
if (mysqli_num_rows($res) > 0) {
  while ($row = mysqli_fetch_assoc($res)) {
    $stmt2 = "SELECT * FROM flight_city WHERE flightID =" . $row["flightID"] . " AND type = \"start\" AND cityID = " . $fromBtn;
    $res2 = mysqli_query($conn, $stmt2);

    $stmt3 = "SELECT * FROM flight_city WHERE flightID =" . $row["flightID"] . " AND type = \"end\" AND cityID = " . $toBtn;
    $res3 = mysqli_query($conn, $stmt3);

    if (mysqli_num_rows($res2) > 0 && mysqli_num_rows($res3) > 0) {
      $isFlight = TRUE;
      $isThisFlight = TRUE;
    }
    if ($isFlight && $counter == 0) {
      echo '
      <table id="centered-table">
        <thead>
          <tr>
            <th style="width: 30%">Flight ID</th>
            <th style="width: 30%">Flight</th>
            <th style="width: 15%">Price</th>
            <th style="width: 25%"></th>
          </tr>
        </thead>
      <tbody>
      ';
    }
    if ($isThisFlight) {
      $stmt4 = "SELECT * FROM flight WHERE id = ".$row["flightID"];
      $res4 = mysqli_query($conn, $stmt4);
      $row4 = mysqli_fetch_assoc($res4);

      echo '
      <tr>
        <td>'.$row4["id"].'</td>
        <td>'.$row4["name"].'</td>
        <td>$'.$row4["fees"].'</td>
        <td><button onclick="viewFlightById(' . $row4["id"] . ')" class="blueButton viewFlight">View Flight</button></td>
      </tr>
      ';
    }
    if ($isFlight && $counter == mysqli_num_rows($res2)) {
      echo '
      </tbody>
      </table>
      ';
    }
    $counter++;
    $isThisFlight = FALSE;
  }

  if (!$isFlight) {
    echo '<h2 style="text-align: center; color: #084cdf; margin-top: 120px;">No flights availabe with selected cities!</h2>';
  }

} else {
  echo '<h2 style="text-align: center; color: #084cdf; margin-top: 120px;">No flights availabe with selected cities!</h2>';
}

?>