<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $mysqli = new mysqli("localhost", "root", "", "flightcompany");
  session_start();
  require_once("../../context.php");
  $context = new context();
  $context->connect();
  $conn = $context->getConnection();

  function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}

  $name = $_POST["name"];
  $email = $_POST["email"];
  $password = $_POST['password'];
  $tel = $_POST["tel"];
  $filename1 = $_FILES['filename1'];
  $filename2 = $_FILES['filename2'];
  $id = $_SESSION['id'];
  $uploadDirectory = '../../assets/images/';
  $sql = " ";
  if (!empty($name)) {
    $sql .= "UPDATE passenger SET name = \"" . $name . "\" where id =" . $id . "; ";
  }
  if (!empty($email)) {
    $sql .= "UPDATE passenger SET email = \"" . $email . "\" where id =" . $id . "; ";
  }
  if (!empty($password)) {
    $sql .= "UPDATE passenger SET password = \"" . $password . "\" where id =" . $id . "; ";
  }
  if (!empty($tel)) {
    $sql .= "UPDATE passenger SET tel = \"" . $tel . "\" where id =" . $id . "; ";
  }
  if (!empty($filename1['name'])) {
    $destinationLogoPath = $uploadDirectory . basename($filename1['name']);
    if (!move_uploaded_file($filename1['tmp_name'], $destinationLogoPath)) {
      throw new Exception("Failed to move logo file. Error: " . json_encode($_FILES['$filename1']), 1);
    }
    $sql .= "UPDATE passenger SET photo = \"" . $destinationLogoPath . "\" where id =" . $id . "; ";
  }
  if (!empty($filename2['name'])) {
    $destinationLogoPath = $uploadDirectory . basename($filename2['name']);
    if (!move_uploaded_file($filename2['tmp_name'], $destinationLogoPath)) {
      throw new Exception("Failed to move logo file. Error: " . json_encode($_FILES['$filename2']), 1);
    }
    $sql .= "UPDATE passenger SET passportImg = \"" . $destinationLogoPath . "\" where id = " . $id . "; ";
  }
  if (!empty($sql)) {
    debug_to_console($sql);
    $mysqli->multi_query($sql);
  }
}
header('Location: /flight-booker/pages/passenger_profile/passenger_profile.php');
?>