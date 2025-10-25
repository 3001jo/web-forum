<?php
	require '_header.php';
	$db = new SQLite3('../forum.db');
	$result = $db->query('
		SELECT posts.*, users.username, users.created
		FROM posts 
		JOIN users ON posts.authorID = users.id 
		WHERE posts.deleted = FALSE 
		ORDER BY posts.created DESC
	');
	while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
		echo '<h4>';
		if ($isAdmin || $row['username'] == $_SESSION['username']) {
			echo '<a href="/delete_post.php?postID=' . $row['id'] . '">Delete</a> ';
		}
		if ($row['admin'] == true) {
			echo '@';
		}
		echo '@' . htmlspecialchars($row['username']) . ' > ' . htmlspecialchars($row['title']) . '</h4><p>' . nl2br(htmlspecialchars($row['text'])) . '</p>';
	}
	$db->close();
	require '_footer.php';
?>