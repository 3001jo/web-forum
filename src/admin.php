<?php
	require '_header.php';
	if ($_SESSION['is_admin'] != true) {
		header('Location: /');
		exit;
	}
?>
<h2>Admin Panel</h1>
<h3>Users</h2>
<?php
	$db = new SQLite3('../forum.db');
	$result = $db->query("SELECT * FROM users");
	while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
		echo "ID: " . htmlspecialchars($row['id']) . " Username: " . htmlspecialchars($row['username']) . " Created: " . date("Y-m-d H:i:s", $row['created']);
		if ($row['admin'] == 1) {
			echo " <b>Admin</b>";
		}
		echo "<br>";
	}
	$db->close();
	require '_footer.php';
?>