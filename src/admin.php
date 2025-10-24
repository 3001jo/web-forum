<?php
	session_start();
	if ($_SESSION['is_admin'] != true) {
		header('Location: /');
		exit;
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>AdminPanel</title>
</head>
<body>
	<h1>Admin Panel</h1>
	<h2>Users</h2>
	<?php
		$db = new SQLite3('../forum.db');
		$result = $db->query("SELECT * FROM users");
		while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
			echo "ID: " . htmlspecialchars($row['id']) . " Username: " . htmlspecialchars($row['username']) . " Admin: " . htmlspecialchars($row['admin']) . "<br>";
		}
		$db->close();
	?>
</body>
</html>