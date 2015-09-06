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
  <title>Welcome to Your Personal Cookbook - Edit Meal Types</title>
<link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
  <br>
  <div align="center">
    <form class="database-form" method="POST" action="action.php" enctype="multipart/form-data">
      <label><input type="text" name="meal_type_add"></label>
      <input type="submit" value="Add Meal Type" name="addMealType">
    </form>
  </div>
  <br><br>
<table class="main-table">
    <tr>
      <td><h3>Meal Type</h3></td><td><h3>Update Type?</h3></td><td><h3>Remove</h3></td>
    </tr>
  <?php
    $mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if (!$mysqli || $mysqli->connect_errno) {
      echo "Error connection to MySQLi Session(".$mysqli->connect_errno."): ".$mysqli->connect_error;
    }

  $filtering = "SELECT M.mid, M.type FROM meal_type M WHERE M.username = '".$username."' ORDER BY M.type ASC";
  $dbTable = $mysqli->query($filtering);

  if ($dbTable->num_rows > 0) {
      while ($row = $dbTable->fetch_row()) {
        $idNum = $row[0];
        echo "<tr><td>".$row[1]."</td>";
        echo "<form action='action.php' method='POST'><input type='hidden' name='id' value='$idNum'><td><input type='text' name='edit' value='".$row[1]."'><input type='submit' name='editMealType' value='Edit'></form></td>";
        echo "<form action='action.php' method='POST'><input type='hidden' name='id' value='$idNum'><td><input type='submit' name='removeMealType' value='✖'></form></td></tr>";
      }
    }
  ?>
</table>
<br><br>
   <div align="center">
   <button onClick="window.close()">Close Meal Types</button>
 </div>
<br>
</body>
</html>
