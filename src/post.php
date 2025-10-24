<?php
	require '_header.php';
	if (!isset($_SESSION['username'])) {
		header('Location: /');
		exit;
	}
	if (isset($_POST['title']) && isset($_POST['text'])) {
		print_r($_POST);
		print_r($_SESSION);
		$db = new SQLite3('../forum.db');
		$db->exec('CREATE TABLE IF NOT EXISTS posts (id INTEGER PRIMARY KEY, authorID INTEGER NOT NULL, title TEXT NOT NULL, text TEXT NOT NULL, created INTEGER NOT NULL, deleted BOOLEAN DEFAULT FALSE)');
		
		$stmt = $db->prepare('INSERT INTO posts (authorID, title, text, created) VALUES (:authorID, :title, :text, :created)');
		$stmt->bindValue(':authorID', $_SESSION['id'], SQLITE3_INTEGER);
		$stmt->bindValue(':title', $_POST['title'], SQLITE3_TEXT);
		$stmt->bindValue(':text', $_POST['text'], SQLITE3_TEXT);
		$stmt->bindValue(':created', time(), SQLITE3_INTEGER);
		$stmt->execute();

		$db->close();
		header('Location: /');
		exit;
	}
?>
<h2>Make a post</h2>
<form action="/post.php" method="post">
	<label for="title">Title:</label><br>
	<input type="text" id="title" name="title" required><br><br>

	<label for="text">Text:</label><br>
	<textarea id="text" name="text" rows="4" cols="50"></textarea><br><br>

	<input type="submit" value="Post">
</form>
<?php
	require '_footer.php';
?>