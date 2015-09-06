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
  <title>Welcome to Your Personal Cookbook - Add Recipe</title>
<link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
<table class="main-table">
  <tr><td>
  <form class="database-form" method="POST" action="action.php" enctype="multipart/form-data">
  <h3>Add Recipe to Your Cookbook: </h3>
  <label>(Required) Name of Your Recipe:&nbsp;&nbsp; <input type="text" name="name" maxlength="255"></label><br><br>
  <label>Meal Type: &nbsp;&nbsp; <select name="meal_type">
    <?php
    $display_types = "SELECT M.mid, M.type FROM meal_type M WHERE M.username = '".$username."'";
    if ($all = $mysqli->query($display_types)) {
      while ($row = $all->fetch_row()) {
        echo '<option name="meal_type" value="'.$row[0].'">'.$row[1].'</option>';
      }
    }
    $all->close();
    ?></select></label><br><br>
  <label>Time to Cook (In Minutes):&nbsp;&nbsp; <input type="number" min="1" max="400" name="cooking_time"></label><br><br>
  <label>Main Ingredient: <input type="text" name="main_ingredient_1"></label><br><br>
  <label>Secondary Ingredient: <input type="text" name="main_ingredient_2"></label><br><br>
  <label>(Required: .TXT FILE ONLY) Upload Recipe Instructions:&nbsp;&nbsp;
    <input type="file" name="uploaded_file"><br><br>
  <input type="submit" value="Add Recipe" name="add">
</form>
<br><br>
</td></tr>
</table>

</body>
</html>
