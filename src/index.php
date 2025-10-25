<?php
	require '_header.php';
	$db = new SQLite3('../forum.db');
	$result = $db->query('
		SELECT posts.*, users.*
		FROM posts 
		JOIN users ON posts.authorID = users.id 
		WHERE posts.deleted = FALSE 
		ORDER BY posts.created DESC
	');
	while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
		echo '<h4>';
		if ($isAdmin) {
			echo '<a href="/admin.php?delete_post=' . $row['id'] . '">Delete</a> ';
		}
		if ($row['admin'] == true) {
			echo '@';
		}
		echo '@' . htmlspecialchars($row['username']) . ' > ' . htmlspecialchars($row['title']) . '</h4>' . nl2br(htmlspecialchars($row['text']));
	}
	$db->close();
	require '_footer.php';
?>