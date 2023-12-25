<?php
header('Content-Type: application/json');
session_start();
require_once("../../context.php");
$context = new context();
$context->connect();
$conn = $context->getConnection();
$aResult = 1;

$flightId = $_POST['flightId'];
$passengerId = $_SESSION['id'];

$stmt0 = "SELECT * FROM flight WHERE id =" . $flightId;
$res0 = mysqli_query($conn, $stmt0);
$row0 = mysqli_fetch_assoc($res0);

$stmt = "SELECT * FROM passenger_flight_status WHERE flightID =" . $flightId;
$res = mysqli_query($conn, $stmt);
$row = mysqli_fetch_assoc($res);

$stmt2 = "SELECT * FROM passenger WHERE id =" . $passengerId;
$res2 = mysqli_query($conn, $stmt2);
$row2 = mysqli_fetch_assoc($res2);

if ($row0["capacity"] > mysqli_num_rows($res0) && $row0["fees"] < $row2["account"]) {
  $stmt3 = "UPDATE passenger SET account = account - " . $row0["fees"] . " where id = " . $passengerId;
  $res3 = mysqli_query($conn, $stmt3);

  $stmt3 = "UPDATE company SET account = account + " . $row0["fees"] . " where name = \"" . $row0["companyName"]."\"";
  $res3 = mysqli_query($conn, $stmt3);
}
else{
  $aResult = 0;
}

echo json_encode($aResult);
?>