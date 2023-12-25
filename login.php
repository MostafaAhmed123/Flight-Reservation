<?php
require_once("context.php");
$context = new context();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $context->connect();
    $conn = $context->getConnection();
    try {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Search for user in company table
        $stmt = mysqli_prepare($conn, "SELECT * FROM company WHERE email = ? AND password = ?");
        mysqli_stmt_bind_param($stmt, "ss", $email, $password);
        mysqli_stmt_execute($stmt);
        $tmpRes = mysqli_stmt_get_result($stmt);

        if ($tmpRes) {
            $row = mysqli_fetch_assoc($tmpRes);

            // Check if the user was found
            if ($row) {
                session_start();
                $_SESSION['type'] = "company";
                $_SESSION['email'] = $row['email'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['name'] = $row['name'];

                echo "company";
                $context->disconnect();
                header('Location: /flight-booker/pages/company_home/company_home.php');
                exit();
            } else {
                // Search for user in passenger table
                $stmt = mysqli_prepare($conn, "SELECT * FROM passenger WHERE email = ? AND password = ?");
                mysqli_stmt_bind_param($stmt, "ss", $email, $password);
                mysqli_stmt_execute($stmt);
                $res = mysqli_stmt_get_result($stmt);

                if ($res) {
                    $row = mysqli_fetch_assoc($res);
                    // Check if the user was found
                    if ($row) {
                        session_start();

                        $_SESSION['type'] = "passenger";
                        $_SESSION['email'] = $row['email'];
                        $_SESSION['id'] = $row['id'];
                        $_SESSION['name'] = $row['name'];
                        echo "passenger";
                        $context->disconnect();
                        header('Location: /flight-booker/pages/passenger_home/passenger_home.php');
                        exit();
                    } else
                        throw new Exception("Wrong Email or Password", 1);
                }
            }
        }
    } catch (\Throwable $th) {
        $context->disconnect();
        echo $th->getMessage();
        // sleep(5);
        // header("Location: ./index.html");
        exit();
    }
} else {
    echo "Invalid request method";
    // header("Location: ./index.html");
    exit();
}
?>