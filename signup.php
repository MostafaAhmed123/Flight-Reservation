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
        // exit();
        $password = $_POST['password'];
        $tel = $_POST['tel'];

        if ($type == "company") {
            $bio = $_POST['bio'];
            $address = $_POST['address'];
            $username = $_POST['username'];
            $logo = $_FILES['logo'];
            $uploadDirectory = './assets/images/Logos/';
            $destinationLogoPath = $uploadDirectory . basename($logo['name']);
            if (!move_uploaded_file($logo['tmp_name'], $destinationLogoPath)) {
                throw new Exception("Failed to move logo file. Error: " . json_encode($_FILES['logo']), 1);
            }
            $tmpRes = mysqli_query($conn, "SELECT * FROM passenger");
            if ($tmpRes) {
                while ($row = mysqli_fetch_assoc($tmpRes)) {
                    if ($row["email"] == $email) {
                        unlink($destinationLogoPath);
                        throw new Exception("Email already Exists", 1);
                    }
                }
            }
            $logo_path = "../../assets/images/Logos/".basename($logo['name']);
            $sql = "INSERT INTO company (name, email, username, password, bio, address, tel, logoImg) 
                    VALUES ('$name', '$email', '$username', '$password', '$bio', '$address', '$tel', '$logo_path')";

            $result = mysqli_query($conn, $sql);

            if (!$result) {
                unlink($destinationLogoPath);
                throw new Exception("Error Processing Query", 1);
            } else {
                echo "company signed up successfully";
                sleep(3);
                header("Location: ./index.html");
                exit();
            }
        } else {
            $photo = $_FILES['photo'];
            $passport = $_FILES['passport'];
            // echo "passenger";
            $uploadDirectoryPhoto = './assets/images/profilePics/';
            $destinationPhotoPath = $uploadDirectoryPhoto . basename($photo['name']);
            
            $uploadDirectoryPassport = './assets/images/passportImgs/';
            $destinationPassportPath = $uploadDirectoryPassport . basename($passport['name']);
            
            if (!move_uploaded_file($photo['tmp_name'], $destinationPhotoPath) || !move_uploaded_file($passport['tmp_name'], $destinationPassportPath)) {
                echo "engineering";
                exit();
                throw new Exception("Failed to move photo or passport file. Error: " . json_encode($_FILES), 1);
            }
            $tmpRes = mysqli_query($conn, "SELECT * FROM company");
            if ($tmpRes) {
                while ($row = mysqli_fetch_assoc($tmpRes)) {
                    if ($row["email"] == $email) {
                        unlink($destinationPhotoPath);
                        unlink($destinationPassportPath);
                        throw new Exception("Email already Exists", 1);
                    }
                }
            }
            //../../assets/images/2.png
            $photo_path = "../../assets/images/profilePics/".basename($photo['name']);
            $passport_path = "../../assets/images/passportImgs/".basename($passport['name']);
            $sql = "INSERT INTO passenger (Name, Email, password, tel, photo, passportImg) 
                    VALUES ('$name', '$email', '$password', '$tel', '$photo_path', '$passport_path')";

            $result = mysqli_query($conn, $sql);

            if (!$result) {
                unlink($destinationPhotoPath);
                unlink($destinationPassportPath);
                throw new Exception("Error Processing Query", 1);
            } else {
                echo "passenger signed up successfully";
                sleep(3);
                header("Location: ./index.html");
            }
        }
        $context->disconnect();
    } catch (\Throwable $th) {
        // Handle the error as needed, e.g., redirect the user
        $context->disconnect();
        echo $th->getMessage();
        header("Location: ./signup.html");
    }
} else {
    header("Location: ./signup.html");
}

?>