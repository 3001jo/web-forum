<?php
	require '_header.php';
	if ($_SESSION['admin'] != true) {
		header('Location: /');
		exit;
	}
	if (isset($_GET['delete_post'])) {
		$db = new SQLite3('../forum.db');
		$stmt = $db->prepare('UPDATE posts SET deleted = TRUE WHERE id = :id');
		$stmt->bindValue(':id', $_GET['delete_post'], SQLITE3_INTEGER);
		$stmt->execute();
		header('Location: /');
		exit;
		echo '<script>alert("Post deleted.")</script>';
	}
?>
<h2>Admin Panel</h1>
<h3>Users</h2>
<?php
	if(!$db){
		$db = new SQLite3('../forum.db');
	}
	$result = $db->query('SELECT * FROM users');
	while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
		echo 'ID: ' . htmlspecialchars($row['id']) . ' Created: ' . date('Y-m-d H:i:s', $row['created']) . ' Username: ' . htmlspecialchars($row['username']);
		if ($row['admin'] == true) {
			echo ' <b>Admin</b>';
		}
		echo '<br>';
	}
	$db->close();
	require '_footer.php';
?>