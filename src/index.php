<?php
	require '_header.php';
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
	require '_footer.php';
?>