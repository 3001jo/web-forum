<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<body>
	<?php
		$db = new SQLite3('../forum.db');

		$db->exec("CREATE TABLE IF NOT EXISTS users (id INTEGER PRIMARY KEY, username TEXT NOT NULL, password TEXT NOT NULL, admin BOOLEAN DEFAULT FALSE)");

		$stmt = $db->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
		$stmt->bindValue(':username', 'John Doe', SQLITE3_TEXT);
		$stmt->bindValue(':password', 'john@example.com', SQLITE3_TEXT);
		$stmt->execute();

		$result = $db->query("SELECT * FROM users");
		while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
			echo "ID: " . $row['id'] . " Username: " . $row['username'] . " Password: " . $row['password'] . " Admin: " . $row['admin'] . "<br>";
		}

		$db->close();
	?>
</body>
</html>