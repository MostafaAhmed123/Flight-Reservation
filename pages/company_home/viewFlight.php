<?php
session_start();
require_once("../../context.php");
$context = new context();
$context->connect();
$conn = $context->getConnection();
$flightId = $_POST['flightId'];
$name = $_SESSION['name'];

$stmt = "SELECT * FROM flight WHERE id = '" . $flightId . "' AND companyName = '" . $name . "'";
$res = mysqli_query($conn, $stmt);
$row = mysqli_fetch_assoc($res);


$stmt2 = "SELECT * FROM flight_city WHERE flightID = " . $flightId;
$res2 = mysqli_query($conn, $stmt2);

$stmt3 = "SELECT * FROM passenger_flight_status WHERE flightID = " . $flightId;
$res3 = mysqli_query($conn, $stmt3);
echo '

<h1 style="margin-top: 10px;">' . $row["name"] . '</h1>
<p><strong>ID: </strong>' . $row["id"] . '</p>
<p><strong>Itinerary:</strong>
';
$counter = 0;
if (mysqli_num_rows($res2) > 0) {
  while ($row2 = mysqli_fetch_assoc($res2)) {
    echo $row2["cityName"];
    if ($counter != mysqli_num_rows($res2)-1) {
      echo " -> ";
    }
    $counter++;
  }
}
$temp = $row["capacity"] - mysqli_num_rows($res3);
echo '
</p>
<p><strong> Passengers:</strong> Registered: '.mysqli_num_rows($res3).', Pending: '.$temp.'</p>
<p><strong>Fees:</strong> $' . $row["fees"] . ' per passenger</p>
<p><strong>Time:</strong> ' . $row["startTime"] . ' - ' . $row["endTime"] . '</p>
<p><strong>Completed:</strong> ' . ($row["completed"] ? 'Yes' : 'No') . '</p>
<button onclick="testFunc('.$flightId.')" class="center blueButton cancelFlight">Cancel flight</button>
';
?>