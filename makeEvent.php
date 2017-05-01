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
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <!-- timepicker -->
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
  <!-- Updated stylesheet url -->
  <link rel="stylesheet" href="//jonthornton.github.io/jquery-timepicker/jquery.timepicker.css">
  <!-- Updated JavaScript url -->
  <script src="//jonthornton.github.io/jquery-timepicker/jquery.timepicker.js"></script>
  <!-- datepicker -->
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  
  <script>
  $( function() {
    var dateFormat = "mm/dd/yy",
      from = $( "#from" )
        .datepicker({
          defaultDate: "+1w",
          changeMonth: true,
          numberOfMonths: 1
        })
        .on( "change", function() {
          to.datepicker( "option", "minDate", getDate( this ) );
        }),
      to = $( "#to" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 1
      })
      .on( "change", function() {
        from.datepicker( "option", "maxDate", getDate( this ) );
      });
 
    function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( dateFormat, element.value );
      } catch( error ) {
        date = null;
      }
      return date;
    }
  } );
  </script>
</head>
<body>
	<div class="container-fluid">
		<form class="makeNewEvent" method="POST" action="eventProcess.php">
			<h2> Create your event </h2>			
			<div class="_eID">
				<label for="eID"> Event ID: </label>
				<input type="number" name="eID" id="eID" max="99999999999999999999" min="1">
			</div>
			<div class="_eTitle">
				<label for="eTitle"> Event Title: </label>
				<input type="text" name="eTitle" id="eTitle" maxlength="100">
			</div>
			<div class="_desc">
				<label for="desc"> Description: </label>
				<textarea name="desc" id="desc" rows="10" cols="40"></textarea>
			</div>
			<div class="_dates">
			<h4> Select dates </h4>
				<label for="from"> From </label>
				<input type="text" id="from" name="from">
				<label for="to"> to </label>
				<input type="text" id="to" name="to">
			</div>
			<div class="_time">
				<label for="startTime"> Start time: </label>
				<input type="text" name="startTime" class="startTime"/>
				<label for="endTime"> End time: </label>
				<input type="text" name="endTime" class="endTime"/>

	            <script>
	                $(function() {
	                    $('.startTime').timepicker();
	                    $('.endTime').timepicker();
	                });
	            </script>
			</div>
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
							echo "<script> alert('You are not in a group! Please join or create a group.') </script>";
							header("refresh: 0.1; url=makegroup.php"); 
						}
					}
					else
						echo 'ERROR: '.mysqli_error($conn);	
				?>
			</div>
			<div class="_locaName">
				<?php
					$selLoc = "SELECT lname, zip FROM location";
					if($result = mysqli_query($conn, $selLoc)) {
						if($result && mysqli_num_rows($result) > 0) {
							echo "<label for='lname'> Location: &nbsp</label>";
							echo "<select name='selLoc'>";
							while($row = mysqli_fetch_assoc($result)) {
								echo "<option value='".$row["lname"]."|".$row["zip"]."'> ".$row["lname"]." and ".$row["zip"]."</option>";
							}
							echo "</select>";
						}
						else {
							echo "<script> alert('Locations not added yet. Please add locations.') </script>";
							header("refresh: 0.1; url=makeLoc.php"); # placeholder for addlocation.php
						}
					}
					else
						echo 'ERROR: '.mysqli_error($conn);	
				?>
			</div>
			<div>
				<input type="submit" name="submit" value="Make New Event">
				<input type="button" value="Go Back" class="button_active" onclick="location.href='meetindex.php';">
			</div>
		 </form>
	</div>
 
</body>
</html>