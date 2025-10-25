<?php
	require '_header.php';
	if (!$isAdmin) {
		header('Location: /');
		exit;
	}
?>
<h2>Admin Panel</h1>
<h3>Users</h2>
<?php
	$db = new SQLite3('../forum.db');
	$result = $db->query('SELECT * FROM users');
	while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
		echo '<p>ID: ' . htmlspecialchars($row['id']) . ' Created: ' . date('Y-m-d H:i:s', $row['created']) . ' Username: ' . htmlspecialchars($row['username']);
		if ($row['admin'] == true) {
			echo ' <b>Admin</b>';
		}
		echo '</p><br>';
	}
	$db->close();
	require '_footer.php';
?>