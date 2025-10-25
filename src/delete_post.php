<?php
	require '_header.php';
	if (!$loggedIn || !isset($_GET['postID'])) {
		header('Location: /');
		exit;
	}
	$db = new SQLite3('../forum.db');
	if ($isAdmin) {
		$stmt = $db->prepare('UPDATE posts SET deleted = TRUE WHERE id = :id');
	} else {
		$stmt = $db->prepare('UPDATE posts SET deleted = TRUE WHERE id = :id AND authorID = :authorID');
		$stmt->bindValue(':authorID', $_SESSION['id'], SQLITE3_INTEGER);
	}
	$stmt->bindValue(':id', $_GET['postID'], SQLITE3_INTEGER);
	$stmt->execute();
	header('Location: /');
	exit;
?>