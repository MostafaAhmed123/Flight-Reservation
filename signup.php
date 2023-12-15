<?php
require_once("context.php");
$context = new context();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the data from POST request
    $context->connect();
    $conn = $context->getConnection();

    try {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $type = $_POST['type'];
        $password = $_POST['password'];
        $tel = $_POST['tel'];

        if ($type == "campany") {
            $bio = $_POST['bio'];
            $address = $_POST['address'];
            $location = $_POST['location'];
            $username = $_POST['username'];
            $logo = $_FILES['logo'];

            $uploadDirectory = './assets/images/Logos/';
            $destinationLogoPath = $uploadDirectory . basename($logo['name']);

            if (!move_uploaded_file($logo['tmp_name'], $destinationLogoPath)) {
                throw new Exception("Failed to move logo file. Error: " . json_encode($_FILES['logo']), 1);
            }
            $tmpRes = mysqli_query($conn, "SELECT * FROM passenger");
            if($tmpRes){
                while($row=mysqli_fetch_assoc($tmpRes)){
                    if($row["Email"] == $email){
                        unlink($destinationLogoPath);
                        throw new Exception("Email already Exists", 1);
                    }
                }
            }
            $sql = "INSERT INTO company (Name, email, username, password, Bio, Address, Location, tel, LogoImg) 
                    VALUES ('$name', '$email', '$username', '$password', '$bio', '$address', '$location', '$tel', '$destinationLogoPath')";

            $result = mysqli_query($conn, $sql);

            if (!$result) {
                unlink($destinationLogoPath);
                throw new Exception("Error Processing Query", 1);
            }
            else
                echo "company signed up successfully";
        } else {
            $photo = $_FILES['photo'];
            $passport = $_FILES['passport'];

            $uploadDirectoryPhoto = './assets/images/profilePics/';
            $destinationPhotoPath = $uploadDirectoryPhoto . basename($photo['name']);

            $uploadDirectoryPassport = './assets/images/passportImgs/';
            $destinationPassportPath = $uploadDirectoryPassport . basename($passport['name']);

            if (!move_uploaded_file($photo['tmp_name'], $destinationPhotoPath) || !move_uploaded_file($passport['tmp_name'], $destinationPassportPath)) {
                throw new Exception("Failed to move photo or passport file. Error: " . json_encode($_FILES), 1);
            }
            $tmpRes = mysqli_query($conn, "SELECT * FROM company");
            if($tmpRes){
                while($row=mysqli_fetch_assoc($tmpRes)){
                    if($row["email"] == $email){
                        unlink($destinationPhotoPath);
                        unlink($destinationPassportPath);
                        throw new Exception("Email already Exists", 1);
                    }
                }
            }
            $sql = "INSERT INTO passenger (Name, Email, password, tel, photo, passportImg) 
                    VALUES ('$name', '$email', '$password', '$tel', '$destinationPhotoPath', '$destinationPassportPath')";

            $result = mysqli_query($conn, $sql);

            if (!$result) {
                unlink($destinationPhotoPath);
                unlink($destinationPassportPath);
                throw new Exception("Error Processing Query", 1);
            }
            else
                echo "passenger signed up successfully";
        }
        $context->disconnect();
    } catch (\Throwable $th) {
        // Handle the error as needed, e.g., redirect the user
        // header("Location: ./registration.html");
        $context->disconnect();
        echo $th->getMessage();
        exit(); // Make sure to exit to prevent further script execution
    }
}
?>
