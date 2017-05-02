<?php
  require('connect.php');
  session_start();
  
  # Check if user is logged in or not
  if(!isset($_SESSION['user'])) {
    echo "User is not signed in";
    session_unset();
    session_destroy();
    header("refresh:2; url=main.php");
  }
  
  echo "<span style='font-size: 18px;'> Current signed in as ".$_SESSION['user']." </span>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <link type="text/css" rel="stylesheet" href="main.css">
</head>
<body>
  <div class="_error">
    <?php 
      if(isset($error)) {
        echo 'ERROR: '.$error.'<br>';
        echo "<a href='meetindex.php'> Click here to go back </a>";
      }
    ?> 
  </div>

  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6">
        <form class="insMem" method="POST" action="insMem.php">
          <h2> Insert members to group </h2>
          <div class="_gID">
            <?php
              $selgID = "SELECT group_id FROM groups where username = '".$_SESSION['user']."'";
              if($qry = mysqli_query($conn, $selgID)) {
                if($qry && mysqli_num_rows($qry) > 0) {
                  echo "<label for='gID'> Group ID: &nbsp</label>";
                  echo "<select name='selgroupID'>";
                  while($row = mysqli_fetch_assoc($qry)) {
                    #echo $row["group_id"].' ';
                    echo "<option value=".$row["group_id"]."> ".$row["group_id"]." </option>";
                  }
                  echo "</select>";
                }
                else {
                  echo "<script> alert('You are not the creator of the group. Please create a group first.') </script>";
                  header("refresh: 0.1; url=makegroup.php"); 
                }
              }
            else
              echo 'ERROR: '.mysqli_error($conn); 
            ?>
          </div>
          <div class="_username">
            <?php
              $selUser = "SELECT username FROM member WHERE NOT username = '".$_SESSION['user']."'";
              if($qry = mysqli_query($conn, $selUser)) {
                if($qry && mysqli_num_rows($qry) > 0) {
                  echo "<label for='user'> All users: &nbsp</label>";
                  echo "<select name='selUser'>";
                  while($row = mysqli_fetch_assoc($qry)) {
                    echo "<option value=".$row["username"]."> ".$row["username"]." </option>";
                  }
                  echo "</select>";
                }
                else {
                  echo "There are no users currently except yourself.";
                  header("refresh: 0.1; url=meetindex.php");
                }
              }
            else
              echo 'ERROR: '.mysqli_error($conn);
            ?>
          </div>
          <div class="_memAuth">
            <label for="authority"> Member authority: </label>
            <select name="authorize">
              <option value="0">0</option>
              <option value="1">1</option>
            </select>
          </div>
          <div> 
            <input type="submit" name="submit" value="Insert member to group">
          </div>
        </form>
      </div>
      <div class="col-md-6">
        <form class="editAuth" method="POST" action="editAuth.php">
          <h2>Edit Member Authority</h2>
          <div class="_auth">
            <?php
              $selUser = "select username,group_id from belongs_to where group_id IN (select group_id from 
                  groups where username ='".$_SESSION['user']."')";
              if($qry = mysqli_query($conn, $selUser)) {
                if($qry && mysqli_num_rows($qry) > 0) {
                  echo "<label for='user'> All users: &nbsp</label>";
                  echo "<select name='selUser'>";
                  $count = 0;
                  while($row = mysqli_fetch_assoc($qry)) {
                    if($row["username"] != $_SESSION['user']) { # Show only members in group other than creator of group
                      echo "<option value=".$row["username"]."|".$row["group_id"]."> Username: ".$row["username"]." of Group ID: ".$row["group_id"]." </option>";
                      $count += 1;
                    }
                  }
                  if($count === 0) {
                    ?>
                    <script type="text/javascript"> var nomem = 1; </script>
                    <?php
                  }
                  echo "</select>";
                }
                else {
                  echo "There are no members currently except yourself.";
                  ?>
                  <script type="text/javascript"> var nomem = 1; </script>
                  <?php
                }
              }
            else
              echo 'ERROR: '.mysqli_error($conn);
            ?>
            <label for="authority"> &nbsp Member authority: </label>
            <select name="authorize">
              <option value="0">0</option>
              <option value="1">1</option>
            </select>
          </div>
          <div > 
            <input id="authMem" type="submit" name="submit" value="Edit member permission">
          </div>
        </form>
      </div>
    </div>
    <input type="button" value="Go Back" class="button_active" onclick="location.href='meetindex.php';">
  </div>
</body>
</html>
<script type="text/javascript"> 
  if(nomem == 1) {
    document.getElementById('authMem').style.display = 'none';
  }
</script>