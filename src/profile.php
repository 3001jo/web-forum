<?php
	require '_header.php';
	$thisUsername = 'admin';
	if ($loggedIn) {
		$thisUsername = $_SESSION['username'];
	}
	if (isset($_GET['u'])) {
		$thisUsername = $_GET['u'];
	}

	$db = new SQLite3('../forum.db');
	$stmtFind = $db->prepare('SELECT * FROM users WHERE username = :username');
	$stmtFind->bindValue(':username', $thisUsername, SQLITE3_TEXT);
	$result = $stmtFind->execute();
	$user = $result->fetchArray(SQLITE3_ASSOC);
	if (!$user) {
		http_response_code(404);
		echo '<h2>404 - User not found.</h2>';
	} else {
		echo '<h2>@' . $user['username'] . '</h2>';
		$stmtUserPosts = $db->prepare('
			SELECT posts.*, users.username, users.created
			FROM posts
			JOIN users ON posts.authorID = users.id
			WHERE posts.deleted = FALSE
			AND posts.authorID = :authorID
			ORDER BY posts.created DESC
		');
		$stmtUserPosts->bindValue(':authorID', $user['id'], SQLITE3_INTEGER);
		$result = $stmtUserPosts->execute();
		while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
			echo '<h4>';
			if ($isAdmin || $thisUsername == $_SESSION['username']) {
				echo '<a href="/delete_post.php?postID=' . $row['id'] . '">Delete</a> ';
			}
			if ($row['admin'] == true) {
				echo '@';
			}
			echo '@' . htmlspecialchars($row['username']) . ' > ' . htmlspecialchars($row['title']) . '</h4><p>' . nl2br(htmlspecialchars($row['text'])) . '</p>';
		}
	}
	$db->close();
	require '_footer.php';
?>