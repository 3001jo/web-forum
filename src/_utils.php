<?php
	// if not imported
	if (basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])) {
		header('Location: /');
		exit;
	}
	require_once '_header.php';
	function timeAgo($created = 0) {
		$timeElapsed = time() - $created;
		if ($timeElapsed < 60) {
			return $timeElapsed . ' seconds ago';
		} elseif ($timeElapsed < 3600) {
			$minutes = floor($timeElapsed / 60);
			return $minutes . ' minute' . ($minutes > 1 ? 's' : '') . ' ago';
		} elseif ($timeElapsed < 86400) {
			$hours = floor($timeElapsed / 3600);
			return $hours . ' hour' . ($hours > 1 ? 's' : '') . ' ago';
		} else {
			$days = floor($timeElapsed / 86400);
			return $days . ' day' . ($days > 1 ? 's' : '') . ' ago';
		}
	}
	function render_posts($username = "") {
		global $isAdmin;
		$allPosts = false;
		if ($username == "") {
			$allPosts = true;
		}
		$db = new SQLite3('../forum.db');
		$stmtPosts = $db->prepare('
			SELECT posts.*, users.username, users.admin
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
			echo '<div class="post" id="post_' . $row['id'] . '"><h4>';
			if (isset($_SESSION['username'])) {
				if ($isAdmin || $row['username'] == $_SESSION['username']) {
					echo '<button onclick="delete_post(' . $row['id'] . ')">Delete</button> ';
				}
			}
			echo '<a href="/profile.php?u=' . htmlspecialchars($row['username']);
			if ($row['admin'] == true) {
				echo '" class="admin_name">';
			} else {
				echo '">';
			}
			echo '@' . htmlspecialchars($row['username']) . '</a> > ' . timeAgo($row['created']) . ' > <button>^</button><button>v</button> 0-0  > ' . htmlspecialchars($row['title']) . '</h4><p>' . nl2br(htmlspecialchars($row['text'])) . '</p></div>';
		}
		$db->close();
	}
?>