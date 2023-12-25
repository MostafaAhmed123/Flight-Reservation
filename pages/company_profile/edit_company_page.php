<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="edit_company_page.css">
  <title>Company Profile</title>

</head>

<body>
  <?php
  session_start();
  require_once("../../context.php");
  $context = new context();
  $context->connect();
  $conn = $context->getConnection();
  $stmt = mysqli_prepare($conn, "SELECT * FROM company WHERE email = ?");
  mysqli_stmt_bind_param($stmt, "s", $_SESSION['email']);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  if ($result) {
    $row = mysqli_fetch_array($result);
    $logoImg = $row['logoImg'];
    $companyId = $row['id'];
  }
  ?>
  <header>
    <div class="header">
      <a href="" class="logo">Flight Booker</a>
      <div class="header-right">
        <a href="#">Home</a>
        <a href="#" class="active">Frontier Airlines</a>
      </div>
    </div>
  </header>

  <form action="edit_company_info.php" method="POST" id="form" enctype="multipart/form-data">
    <div id="profile-container">
      <img src="<?php echo $logoImg; ?>" alt="Company Logo" class="center imgr">
      <input class="center" type="file" name="filename">
      <div class="labeling">
        <label>Username</label>
        <input id="username" type="text" name="username" />
      </div>
      <div class="labeling">
        <label>Password</label>
        <input id="password" type="text" name="password" />
      </div>
      <label>Company Name</label>
      <input id="companyName" name="companyName" cols="50" rows="3">
      <label>Bio</label>
      <textarea id="bio" name="bio" cols="91" rows="6" style="resize: none;"></textarea>
      <label>Address</label>
      <input id="address" name="address" type="text" size="50">
      <button type="submit" id="update-btn" onclick="updateProfile()">Update Profile</button>
      <button type="button" id="cancel-btn" onclick="cancelProfile()">cancel</button>
  </form>
  </div>
  <script>
    function cancelProfile() {
      location.assign("company_page.php")
    }
  </script>
</body>

</html>