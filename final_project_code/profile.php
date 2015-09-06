<?php
error_reporting(E_ALL);
ob_start();
session_start();

include_once 'connect.php';

if(!isset($_SESSION['user'])) {
 header("Location: index.php");
}

$username = $mysqli->real_escape_string($_SESSION['user']);

?>
<!DOCTYPE html>
<html>
<head>
  <title>Welcome to Your Personal Cookbook - <?php echo $username; ?>'s Profile</title>
<link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
  <table class="menu">
    <tr>
      <td background="http://web.engr.oregonstate.edu/~hahnl/final_project/images/left-side-banner.png" width="163px">
        <div align="center">
          <br><br><br><br><br><br><br>
          <?php
             echo "Welcome back, <b>".$username."</b>!";
          ?>
        </div>
      </td>
      <td background="http://web.engr.oregonstate.edu/~hahnl/final_project/images/background_image.png">
        <div align="left">
          &nbsp; <img src="http://web.engr.oregonstate.edu/~hahnl/final_project/images/bullet.png">&nbsp; <button onclick="javascript:void window.open('http://web.engr.oregonstate.edu/~hahnl/final_project/mealtypes.php','1438815497534','width=450,height=350,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');return false;">Edit Meal Types</button><br><br>
          &nbsp; <img src="http://web.engr.oregonstate.edu/~hahnl/final_project/images/bullet.png">&nbsp; <button onclick="javascript:void window.open('http://web.engr.oregonstate.edu/~hahnl/final_project/addRecipe.php','1438815497534','width=900,height=300,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');return false;">Add Recipe to Cookbook</button><br><br>
          &nbsp; <img src="http://web.engr.oregonstate.edu/~hahnl/final_project/images/bullet.png">&nbsp; <button onclick="javascript:void window.open('http://web.engr.oregonstate.edu/~hahnl/final_project/pantry.php','1438815497534','width=900,height=350,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');return false;">Go to <?php echo $username ?>'s Pantry</button><br><br>
          &nbsp; <img src="http://web.engr.oregonstate.edu/~hahnl/final_project/images/bullet.png">&nbsp; <button onclick="javascript:void window.open('http://web.engr.oregonstate.edu/~hahnl/final_project/favorites.php','1438815497534','width=895,height=350,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');return false;"><?php echo $username ?>'s Favorite Recipes</button>
        </div>
      </td>
      <td background="http://web.engr.oregonstate.edu/~hahnl/final_project/images/right-side-banner.png" width="136px">
        <div align="center">
          <br><br><br>
          <button onclick="window.location.href='profile.php'">Edit Profile</button><br><br>
          <button onclick="window.location.href='logout.php?logout'">Log Out</button>
        </div>
      </td>
    </tr>
    </div>
  </table>
  <table class="header-table">
  <tr>
  <td>
    <div align="left">
      <button onclick="window.location.href='main.php'">Back to Cookbook</button>&nbsp;<b>≪&nbsp;<?php echo $username; ?>'s Profile</b>
    </div>
  </td>
  <td>
  </td>
 </table>
 <table class="main-table">
     <tr>
       <td width="165px"><h4>&nbsp;Username:</h4></td>
   <?php
     $mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

     if (!$mysqli || $mysqli->connect_errno) {
       echo "Error connection to MySQLi Session(".$mysqli->connect_errno."): ".$mysqli->connect_error;
     }

   $filtering = "SELECT U.username, U.email, U.password FROM users U WHERE U.username = '".$username."'";
   $dbTable = $mysqli->query($filtering);

   if ($dbTable->num_rows > 0) {
       while ($row = $dbTable->fetch_row()) {
         $userN = $row[0];
         echo "<td><h4>".$row[0]."</h4></td></tr>";
         echo "<tr><td width='165px'><h4>&nbsp;Current Email:</h4></td><td><br>".$row[1]."<br><form action='action.php' method='POST'><input type='hidden' name='userN' value='$userN'><input type='text' name='editEmail' value='".$row[1]."'><input type='submit' name='editUserEmail' value='Update'></form></td></tr>";
         echo "<tr><td width='165px'><h4>&nbsp;Current Password:</h4></td><td><br>".$row[2]."<br><form action='action.php' method='POST'><input type='hidden' name='userN' value='$userN'><input type='password' name='editPass'><input type='submit' name='editUserPass' value='Change'></form></td></tr>";
       }
     }
   ?>
 </table>
  <br><br>
</div>
</body>
</html>
