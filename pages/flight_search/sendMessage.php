<?php
header('Content-Type: application/json');
session_start();
require_once("../../context.php");
$context = new context();
$context->connect();
$conn = $context->getConnection();
$aResult = 1;

$companyName = $_POST['companyName'];
$name = $_SESSION['name'];
$messageContent = $_POST['messageContent'];

$stmt0 = "SELECT * FROM company WHERE name =\"" . $companyName."\"";
$res0 = mysqli_query($conn, $stmt0);
$row0 = mysqli_fetch_assoc($res0);
$companyId = $row0["id"];

$sql = "INSERT INTO messages (content, companyId, passengerName) 
VALUES ('$messageContent', '$companyId', '$name')";
$result = mysqli_query($conn, $sql);
echo json_encode($aResult);
?>