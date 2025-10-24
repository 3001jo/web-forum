<?php session_start(); ?>
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
		echo "<h3>Welcome, ";
		if (isset($_SESSION['username'])) {
			echo htmlspecialchars($_SESSION['username']) . "</h3>";
			echo '<a href="/logout.php">Logout</a>';
		} else {
			echo "Guest</h3>";
			echo '<a href="/login.php">Login</a>';
		}
		if ($_SESSION['is_admin'] == true) {
			echo '<a href="/admin.php">Admin Panel</a>';
		}
	?>
</body>
</html>