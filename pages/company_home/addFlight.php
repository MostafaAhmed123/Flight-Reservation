<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  session_start();
  require_once("../../context.php");
  $context = new context();
  $context->connect();
  $conn = $context->getConnection();
  $flightId = $_POST["flightId"];
  $flightName = $_POST['flightName'];
  $flightFee = $_POST['flightFee'];
  $flightStart = $_POST['flightStart'];
  $flightEnd = $_POST['flightEnd'];
  $flightSize = $_POST['flightSize'];
  $name = $_SESSION['name'];
  $cityNum = $_POST['cityNum'];

  $sql = "INSERT INTO flight (id, name, fees, startTime, endTime,companyName, capacity) 
                    VALUES ('$flightId', '$flightName', '$flightFee', '$flightStart', '$flightEnd','$name','$flightSize')";
  $result = mysqli_query($conn, $sql);
  if (!$result) {
    throw new Exception("Error Processing Query", 1);
  } else {
    $stmt = mysqli_prepare($conn, "SELECT id FROM flight WHERE name = ? AND companyName = ?");
    mysqli_stmt_bind_param($stmt, "ss", $flightName, $name);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($res);
    $flightId = $row['id'];
    for ($x = 0; $x < $cityNum; $x++) {
      $temp = $_POST['cityNum' . $x];
      $citySql = "SELECT name FROM city WHERE id=" . $temp;
      $cityResult = mysqli_query($conn, $citySql);
      $rowCity = mysqli_fetch_assoc($cityResult);
      $cityTemp = $rowCity["name"];
      if ($x == 0) {

        $sql = "INSERT INTO flight_city (flightID, cityID,cityName, type) 
                    VALUES ('$flightId', '$temp', '$cityTemp' , 'start')";
        $result = mysqli_query($conn, $sql);

      } elseif ($x == $cityNum - 1) {
        $sql = "INSERT INTO flight_city (flightID, cityID,cityName, type) 
                    VALUES ('$flightId', '$temp','$cityTemp' , 'end')";
        $result = mysqli_query($conn, $sql);
      } else {
        $sql = "INSERT INTO flight_city (flightID, cityID,cityName, type) 
        VALUES ('$flightId', '$temp','$cityTemp', 'mid')";
        $result = mysqli_query($conn, $sql);
      }
    }
  }
  header('Location: /flight-booker/pages/company_home/company_home.php');
}
?>