<?php
	require '_header.php';
	echo '<h3>Welcome, ';
	if (isset($_SESSION['username'])) {
		echo htmlspecialchars($_SESSION['username']) . '.</h3>';
		echo '<a href="/logout.php">Logout</a>';
		echo '<br><a href="/post.php">Post</a>';
	} else {
		echo 'Guest.</h3>';
		echo '<a href="/login.php">Login</a>';
	}
	if ($_SESSION['admin'] == true) {
		echo '<br><a href="/admin.php">Admin Panel</a>';
	}
	$db = new SQLite3('../forum.db');
	$result = $db->query('SELECT * FROM posts WHERE deleted = FALSE ORDER BY created desc');
	while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
		echo '<h4>';
		if ($_SESSION['admin'] == true) {
			echo '<a href="/admin.php?delete_post=' . $row['id'] . '">Delete</a> ';
		}
		echo '> ' . htmlspecialchars($row['title']) . '</h4>' . nl2br(htmlspecialchars($row['text']));
	}
	$db->close();
	require '_footer.php';
?>