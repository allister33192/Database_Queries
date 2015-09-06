<?php
error_reporting(E_ALL);
ob_start();
session_start();

include_once 'connect.php';

if(!isset($_SESSION['user'])) {
 header("Location: index.php");
}

$username = $mysqli->real_escape_string($_SESSION['user']);

if (!isset($_POST["categories"])) {
  $filter = 'All Recipes';
}
else {
  $filter = $_POST["categories"];
}
if (!isset($_POST["search"])) {
  $search = 'No Search';
}
else {
  $search = $_POST["search"];
}
if (!isset($_POST["searchByPantryItem"])) {
  $pantrySearch = 'Not Pantry';
}
else {
  $pantrySearch = $_POST["searchByPantryItem"];
}
if (!isset($_POST["cooking_time"])) {
  $cookingTime = 'Not Time';
}
else {
  $cookingTime = $_POST["cooking_time"];
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Welcome to Your Personal Cookbook</title>
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
          &nbsp; <img src="http://web.engr.oregonstate.edu/~hahnl/final_project/images/bullet.png">&nbsp; <button onclick="javascript:void window.open('http://web.engr.oregonstate.edu/~hahnl/final_project/addRecipe.php','1438815497534','width=700,height=375,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');return false;">Add Recipe to Cookbook</button><br><br>
          &nbsp; <img src="http://web.engr.oregonstate.edu/~hahnl/final_project/images/bullet.png">&nbsp; <button onclick="javascript:void window.open('http://web.engr.oregonstate.edu/~hahnl/final_project/pantry.php','1438815497534','width=500,height=375,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');return false;">Go to <?php echo $username ?>'s Pantry</button><br><br>
          &nbsp; <img src="http://web.engr.oregonstate.edu/~hahnl/final_project/images/bullet.png">&nbsp; <button onclick="javascript:void window.open('http://web.engr.oregonstate.edu/~hahnl/final_project/favorites.php','1438815497534','width=950,height=450,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');return false;"><?php echo $username ?>'s Favorite Recipes</button>
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
    <form class="database-form" method="POST" action="main.php">
      <label>Search by Star Ingredients: <input type="text" name="search"> <input type="submit" name="searchByIngredient" value="Search"></label>
    </form><br>
    <form class="database-form" method="POST" action="main.php">
        <div align="left">
          <label>Search by What's In Your Pantry: <select name="searchByPantryItem">
            <?php
              $mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

              if (!$mysqli || $mysqli->connect_errno) {
                echo "Error connection to MySQLi Session(".$mysqli->connect_errno."): ".$mysqli->connect_error;
              }

              $display_pantry_ingredients = "SELECT DISTINCT P.p_ingredient FROM pantry P WHERE P.username = '".$username."' ORDER BY P.p_ingredient ASC";

              if ($all = $mysqli->query($display_pantry_ingredients)) {
                while ($row = $all->fetch_row()) {
                  echo '<option name="searchByPantryItem" value="'.$row[0].'">'.$row[0].'</option>';
                }
              }
              $all->close();
            ?>
      </select> <input type="submit" name="pantrySearch" value="Search"></label>
      </div>
  </form>
  </td>
  <td>
    <div align="right">
    </div>
  </td>
  <td width="385px">
    <div align="right">
      <form class="database-form" method="POST" action="main.php">
        <label>Search by Max Cooking Time: <input type="number" min="1" max="400" name="cooking_time"> <input type="submit" name="filterTime" value="Search"></label>
      </form><br>
      <form class="database-form" method="POST" action="main.php">
        <label><div align="right">Search by Meal Type: <select name="categories">
          <option value="All Recipes">All Recipes</option>
          <?php
          $mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

          if (!$mysqli || $mysqli->connect_errno) {
              echo "Error connection to MySQLi Session(".$mysqli->connect_errno."): ".$mysqli->connect_error;
          }

          $display_categories = "SELECT DISTINCT M.type FROM meal_type M INNER JOIN recipes R ON R.meal_type = M.mid WHERE R.username = '".$username."' ORDER BY M.type ASC";

          if ($all = $mysqli->query($display_categories)) {
            while ($row = $all->fetch_row()) {
              echo '<option name="categories" value="'.$row[0].'">'.$row[0].'</option>';
            }
          }
          $all->close();
          ?>
        </select> <input type="submit" value="Search"></form></label>
    </div></td>
 </table>
<table class="main-table">
  <tr>
    <td><h3>Recipe Name</h3></td><td><h3>Meal Type</h3></td><td><h3>Cooking Time</h3></td><td><h3>Recipe Instructions</h3></td><td><h3>Favorite Recipe</h3></td><td><h3>Remove</h3></td>
  </tr>
  <?php
    $mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if (!$mysqli || $mysqli->connect_errno) {
      echo "Error connection to MySQLi Session(".$mysqli->connect_errno."): ".$mysqli->connect_error;
    }

    if ($filter != 'All Recipes') {
        $filtering = "SELECT R.id, R.name, M.type, R.cooking_time, R.main_ingredient_1, R.main_ingredient_2, R.recipe, R.favorite FROM recipes R INNER JOIN meal_type M ON R.meal_type = M.mid WHERE M.type = '".$filter."' && R.username = '".$username."' ORDER BY R.name ASC";
    }
    else {
        $filtering = "SELECT R.id, R.name, M.type, R.cooking_time, R.main_ingredient_1, R.main_ingredient_2, R.recipe, R.favorite FROM recipes R INNER JOIN meal_type M ON R.meal_type = M.mid WHERE R.username = '".$username."' ORDER BY R.name ASC";
    }

    if ($search != 'No Search') {
        $filtering = "SELECT R.id, R.name, M.type, R.cooking_time, R.main_ingredient_1, R.main_ingredient_2, R.recipe, R.favorite FROM recipes R INNER JOIN meal_type M ON R.meal_type = M.mid WHERE R.username = '".$username."' && (R.main_ingredient_1 = '".$search."' || R.main_ingredient_2 = '".$search."') ORDER BY R.name ASC";
    }

    if ($pantrySearch != 'Not Pantry') {
        $filtering = "SELECT R.id, R.name, M.type, R.cooking_time, R.main_ingredient_1, R.main_ingredient_2, R.recipe, R.favorite FROM recipes R INNER JOIN meal_type M ON R.meal_type = M.mid WHERE R.username = '".$username."' && (R.main_ingredient_1 = '".$pantrySearch."' || R.main_ingredient_2 = '".$pantrySearch."') ORDER BY R.name ASC";
    }

    if ($cookingTime != 'Not Time') {
        $filtering = "SELECT R.id, R.name, M.type, R.cooking_time, R.main_ingredient_1, R.main_ingredient_2, R.recipe, R.favorite FROM recipes R INNER JOIN meal_type M ON R.meal_type = M.mid WHERE R.username = '".$username."' && R.cooking_time <= '".$cookingTime."' ORDER BY R.cooking_time ASC";
    }

    $dbTable = $mysqli->query($filtering);
    if ($dbTable->num_rows > 0) {
      while ($row = $dbTable->fetch_row()) {
        if ($row[7] === '1') {
          $status = "  $username's Favorite";
        }
        elseif ($row[7] === '0') {
          $status = ' ';
        }
        $idNum = $row[0];
        echo "<tr><td>".$row[1]."</td><td>".$row[2]."</td><td>".$row[3]." minutes</td><td><b>★ Main Ingredient:</b> ".$row[4]."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Secondary Ingredient:</b> ".$row[5]."<br>";
        $thing = $row[6];
        $output = str_replace(array("\r\n", "\n", "\r", "\\r\\n", "\\n"), '<br>', $thing);
        $new_output = str_replace("\\", '', $output);
        echo "<table class=\"recipe\"><tr><td>".$new_output."</td></tr></table>";
        echo "</td>";
        if ($row[7] === '0') {
          echo "<td>".$status."<form action='action.php' method='POST'><input type='hidden' name='id' value='$idNum'><input type='submit' name='favorite' value='Make Favorite ✔'></form></td>";
        }
        elseif ($row[7] === '1'){
          echo "<td><form action='action.php' method='POST'><img src='http://web.engr.oregonstate.edu/~hahnl/final_project/images/bullet-main.png'>".$status." <input type='hidden' name='id' value='$idNum'><input type='submit' name='unfav' value='Undo'></form></td>";
        }
        echo "<form action='action.php' method='POST'><input type='hidden' name='id' value='$idNum'><td><input type='submit' name='remove' value='✖'></form></td>";
      }
    }
  ?>
  </table>
  <br><br>
</div>
</body>
</html>
