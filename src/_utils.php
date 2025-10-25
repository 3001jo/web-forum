<?php
	// if not imported
	if (basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])) {
		header('Location: /');
		exit;
	}
	function render_posts($username = "") {
		$allPosts = false;
		if ($username == "") {
			$allPosts = true;
		}
		$db = new SQLite3('../forum.db');
		$stmtPosts = $db->prepare('
			SELECT posts.*, users.username, users.created, users.admin
			FROM posts
			JOIN users ON posts.authorID = users.id
			WHERE posts.deleted = FALSE' . ($allPosts ? ' ' : ' AND users.username = :username ') .
			'ORDER BY posts.created DESC'
		);
		if (!$allPosts) {
			$stmtPosts->bindValue(':username', $username, SQLITE3_TEXT);
		}
		$result = $stmtPosts->execute();
		while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
			echo '<h4>';
			if (isset($_SESSION['admin']) || $row['author'] == $_SESSION['username']) {
				echo '<a href="/delete_post.php?postID=' . $row['id'] . '">Delete</a> ';
			}
			if ($row['admin'] == true) {
				echo '@';
			}
			echo '@' . htmlspecialchars($row['username']) . ' > ' . htmlspecialchars($row['title']) . '</h4><p>' . nl2br(htmlspecialchars($row['text'])) . '</p>';
		}
		$db->close();
	}
?>