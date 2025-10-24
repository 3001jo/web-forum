<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login</title>
</head>
<body>
	<?php
		if (isset($_SESSION['username'])) {
			header('Location: /');
			exit;
		}
		if (isset($_POST['username']) && isset($_POST['password'])) {
			$db = new SQLite3('../forum.db');
			$db->exec("CREATE TABLE IF NOT EXISTS users (id INTEGER PRIMARY KEY, username TEXT NOT NULL, password TEXT NOT NULL, admin BOOLEAN DEFAULT FALSE)");
			// default admin user
			$stmtCheckAdmin = $db->prepare("SELECT COUNT(*) FROM users WHERE username = :username");
			$stmtCheckAdmin->bindValue(':username', 'admin', SQLITE3_TEXT);
			$resultAdmin = $stmtCheckAdmin->execute();
			$rowAdmin = $resultAdmin->fetchArray(SQLITE3_NUM);
			if ($rowAdmin[0] == 0) {
				$defaultPassword = '<password>';
				$stmtInsertAdmin = $db->prepare("INSERT INTO users (username, password, admin) VALUES (:username, :password, :admin)");
				$stmtInsertAdmin->bindValue(':username', 'admin', SQLITE3_TEXT);
				$stmtInsertAdmin->bindValue(':password', password_hash($defaultPassword, PASSWORD_BCRYPT), SQLITE3_TEXT);
				$stmtInsertAdmin->bindValue(':admin', true, SQLITE3_INTEGER);
				$stmtInsertAdmin->execute();
			}
			// login/signup
			if ($_POST['signup_flag'] == 1) {
				$stmtCheck = $db->prepare("SELECT COUNT(*) FROM users WHERE username = :username");
				$stmtCheck->bindValue(':username', $_POST['username'], SQLITE3_TEXT);
				$result = $stmtCheck->execute();
				$row = $result->fetchArray(SQLITE3_NUM);
				if ($row[0] == 0) {
					$stmt = $db->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
					$stmt->bindValue(':username', $_POST['username'], SQLITE3_TEXT);
					$stmt->bindValue(':password', password_hash($_POST['password'], PASSWORD_BCRYPT), SQLITE3_TEXT);
					$stmt->execute();
					$_SESSION['username'] = $_POST['username'];
					header('Location: /');
					exit;
				} else {
					echo 'Username already exists!';
				}
			} else {
				$stmtFind = $db->prepare("SELECT * FROM users WHERE username = :username");
				$stmtFind->bindValue(':username', $_POST['username'], SQLITE3_TEXT);
				$result = $stmtFind->execute();
				$user = $result->fetchArray(SQLITE3_ASSOC);
				if ($user) {
					if (password_verify($_POST['password'], $user['password'])) {
						$_SESSION['username'] = $_POST['username'];
						if ($user['admin'] == true) {
							$_SESSION['is_admin'] = true;
						}
						header('Location: /');
						exit;
					}
				}
				echo "Could not log-in.";
			}
		}
	?>
	<form action="/login.php" method="post">
		<label for="username">Username:</label><br>
		<input type="text" id="username" name="username"><br><br>

		<label for="password">Password:</label><br>
		<input type="password" id="password" name="password"><br><br>

		<input type="hidden" name="signup_flag" value="0">
		<input type="submit" value="Login">
		<input type="submit" value="Sign Up" onclick="document.querySelector('input[name=\'signup_flag\']').value='1';">
	</form> 
</body>
</html>