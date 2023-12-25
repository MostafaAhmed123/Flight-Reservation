<?php
header('Content-Type: application/json');
session_start();
require_once("../../context.php");
$context = new context();
$context->connect();
$conn = $context->getConnection();
$aResult = 1;
function debug_to_console($data)
{
  $output = $data;
  if (is_array($output))
    $output = implode(',', $output);

  echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}

$flightId = $_POST['flightId'];
$name = $_SESSION['name'];

$stmt0 = "SELECT * FROM flight WHERE id =" . $flightId;
$res0 = mysqli_query($conn, $stmt0);
$row0 = mysqli_fetch_assoc($res0);

$stmt = "SELECT * FROM passenger_flight_status WHERE flightID =" . $flightId;
$res = mysqli_query($conn, $stmt);
if (mysqli_num_rows($res) > 0) {
  while ($row = mysqli_fetch_assoc($res)) {
    $stmt2 = "SELECT * FROM passenger WHERE id = " . $row["passangerID"];
    $res2 = mysqli_query($conn, $stmt2);
    $row2 = mysqli_fetch_assoc($res2);
    $newSum = $row2["account"] + $row0["fees"];

    $stmt2 = "UPDATE passenger SET account = " . $newSum . " where id = " . $row["passangerID"];
    $res2 = mysqli_query($conn, $stmt2);
  }
} 
$stmt = "DELETE FROM flight WHERE id =" . $flightId;
$res = mysqli_query($conn, $stmt);
echo json_encode($aResult);
?>