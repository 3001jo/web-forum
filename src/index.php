<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Homepage</title>
</head>
<body>
	<h1>Forum</h1>
	<?php
		if (isset($_SESSION['account_loggedin'])) {
			echo '<a href="/logout.php">Logout</a>';
		} else {
			echo '<a href="/login.php">Login</a>';
		}
	?>
</body>
</html>