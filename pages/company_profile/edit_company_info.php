<?php
function debug_to_console($data)
{
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $mysqli = new mysqli("localhost", "root", "", "flightcompany");
    session_start();
    require_once("../../context.php");
    $context = new context();
    $context->connect();
    $conn = $context->getConnection();
    $username = $_POST["username"];
    $password = $_POST['password'];
    $companyName = $_POST['companyName'];
    $bio = $_POST['bio'];
    $address = $_POST['address'];
    $filename = $_FILES['filename'];
    $updateWithThisName = $_SESSION['name'];

    $sql =" ";
    if (!empty($username)) {
        $sql .= "UPDATE company SET username = \"" . $username . "\" where name = \"" . $updateWithThisName. "\"; ";
        
        debug_to_console($sql);
        // $res1 = mysqli_query($conn, $sql1);
    }
    if (!empty($bio)) {
        $sql .= "UPDATE company SET bio = \"" . $bio . "\" where name = \"" . $updateWithThisName. "\"; ";
        debug_to_console($bio);
        // $res2 = mysqli_query($conn, $sql2);
    }
    if (!empty($address)) {
        $sql .= "UPDATE company SET address = \"" . $address . "\" where name = \"" . $updateWithThisName. "\"; ";
        debug_to_console($address);
        // $res3 = mysqli_query($conn, $sql3);
    }
    if (!empty($password)) {
        $sql .= "UPDATE company SET password = \"" . $password . "\" where name = \"" . $updateWithThisName. "\"; ";
        debug_to_console($password);
        // $res4 = mysqli_query($conn, $sql4);
    }
    if (!empty($companyName)) {
        $_SESSION['name'] = $companyName;
        debug_to_console($companyName);
        $sql .= "UPDATE company SET name = \"" . $companyName . "\" where name = \"" . $updateWithThisName. "\"; ";
        // $res5 = mysqli_query($conn, $sql5);
    }
    if (!empty($filename['name'])) {
        $uploadDirectory = '../../assets/images/';
        $destinationLogoPath = $uploadDirectory . basename($filename['name']);
        if (!move_uploaded_file($filename['tmp_name'], $destinationLogoPath)) {
            throw new Exception("Failed to move logo file. Error: " . json_encode($_FILES['$filename']), 1);
        }
        $sql .= "UPDATE company SET logoImg = \"" . $destinationLogoPath . "\" where name = \"" . $updateWithThisName. "\"; ";
        
    }
    if(!empty($sql)){
        debug_to_console($sql);
        $mysqli->multi_query($sql);
    }
}
header('Location: /flight-booker/pages/company_profile/company_page.php');
?>