<?php
	$skipHeader = true;
	require '_header.php';
	if (!isset($_GET['action'])) {
		header('Location: /');
		exit;
	}
	$data = array('success' => false);
	$action = $_GET['action'];
	if ($action == "vote" && isset($_GET['type'])) {
		$type = $_GET['type'];
		if ($type === -1 || $type === 1) {
			//  todo
		}
	} elseif ($action == "delete_post" && isset($_GET['postID'])) { // /api.php?action=delete_post&postID=
		$db = new SQLite3('../forum.db');
		if ($isAdmin) {
			$stmt = $db->prepare('UPDATE posts SET deleted = TRUE WHERE id = :id');
		} else {
			$stmt = $db->prepare('UPDATE posts SET deleted = TRUE WHERE id = :id AND authorID = :authorID');
			$stmt->bindValue(':authorID', $_SESSION['id'], SQLITE3_INTEGER);
		}
		$stmt->bindValue(':id', $_GET['postID'], SQLITE3_INTEGER);
		if ($stmt->execute() == true) {
			$data['success'] = true;
		}
	}
	header('Content-Type: application/json; charset=utf-8');
	echo json_encode($data);
	exit;
?>