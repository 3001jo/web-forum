<?php
	session_start();
	$loggedIn = isset($_SESSION['username']);
	$isAdmin = $_SESSION['admin'] == true;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Forum</title>
	<link rel="stylesheet" href="_style.css">
	<!-- https://github.com/3001jo/web-forum -->
</head>
<body>
	<div id="container">
	<div id="header">
		<h1 id="header_title" onclick="location.href='/';">Forum</h1>
		<div id="top_right">
			<?php
				if ($loggedIn) {
					echo '<a href="/post.php">Post</a>';
					if ($isAdmin) {
						echo '<a href="/admin.php">Admin Panel</a>';
					}
					echo '<a href="/logout.php">Logout</a>';
					echo '<a href="/profile.php">@' . htmlspecialchars($_SESSION['username']) . '</a>';
				} else {
					echo '<a href="/login.php">Login</a>';
				}
			?>
		</div>
	</div>