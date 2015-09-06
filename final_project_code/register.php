<?php

session_start();

include_once 'connect.php';

if (isset($_POST['register_button'])) {
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];

  if (!($stmt = $mysqli->prepare("INSERT INTO users (username, email, password) VALUES (?,?,?)"))) {
    echo "Prepare failed: (".$mysqli->errno.")".$mysqli->error;
  }

  if (!$stmt->bind_param('sss', $username, $email, $password)) {
    echo "Binding paramaters failed".$stmt->errno.")".$stmt->error;
  }

  if (!$stmt->execute()) {
    ?>
        <script>
          alert('Sorry, that username is already taken. Please try again.');
        </script>
    <?php
  } else {
    ?>
        <script>
          alert('Registration successful.');
        </script>
    <?php

    $populate = "INSERT INTO meal_type (type, username) VALUES ('Breakfast', '".$username."')";
    $meal_type_default = $mysqli->query($populate);
    $populate = "INSERT INTO meal_type (type, username) VALUES ('Lunch', '".$username."')";
    $meal_type_default = $mysqli->query($populate);
    $populate = "INSERT INTO meal_type (type, username) VALUES ('Dinner', '".$username."')";
    $meal_type_default = $mysqli->query($populate);

    echo "<meta http-equiv=\"refresh\" content=\"0;URL=index.php\">";
  }
}

$mysqli->close();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Your Personal Cookbook - Registration Page</title>
  <link rel="stylesheet" href="index_style.css" type="text/css">
</head>
<body>
  <center>
    <br>
    <img src="http://web.engr.oregonstate.edu/~hahnl/final_project/images/logo_image.png">
    <?php #Logo_image is a free stock image from freepik.com ?>
  <div id="login-form">
    <form method="post" action="register.php">
    <table class="login-table" align="center" width="269px">
      <tr>
        <td>
          <b>Username:</b> <br><input type="text" name="username" required>
        </td>
      </tr>
      <tr>
        <td>
          <b>Email:</b> <br><input type="email" name="email" required>
        </td>
      </tr>
      <tr>
        <td>
          <b>Password:</b> <br><input type="password" name="password" required>
        </td>
      </tr>
      <tr>
        <td>
          <center>
            <input type="submit" value="Register Now" name="register_button">
          </center>
        </td>
      </tr>
    </table>
  </form>
    <center>
      <td>
        <br>
        <a href="index.php">Sign In</a>
      </td>
    </center>
  </div>
</center>
</body>
</html>
