<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>

<body>
	<div class="container-fluid">
		<form class="register" method="POST" action="register.php">
			<h2 class="register_txt"> New User Registration </h2>
			<input type='hidden' name='submitted' id='submitted' value='1'/>
			<div class="_fullname">
				<label for="fname" >First Name: </label>
				<input type="text" name="fname" id="fname" maxlength="50">
				<label for="lname" >Last Name: </label>
				<input type="text" name="lname" id="lname" maxlength="50">
			</div>
			<div class="_email">
				<label for="email" >Email Address:</label>
				<input type="text" name="email" id="email" maxlength="50" placeholder="jsmith123@gmail.com">
			</div>
			<div class="_user">
				<label for="username" >UserName:</label>
				<input type="text" name="username" id="username" maxlength="50">
			</div>
			<div class="_pass">
				<label for="password" >Password:</label>
				<input type="password" name="password" id="password" maxlength="50">
				<label for="pass_valid" >Retype Password:</label>
				<input type="password" name="pass_valid" id="pass_valid" maxlength="50">
			</div>
			<input type="submit" name="Submit" value="Submit">			
		</form>
	</div>

	<script type="text/javascript">

	</script>

</body>
</html>