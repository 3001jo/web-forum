<?php
	require '_header.php';
	require '_utils.php';
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
		render_posts($user['username']);
	}
	$db->close();
	require '_footer.php';
?>