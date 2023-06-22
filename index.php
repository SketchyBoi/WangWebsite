<?php
	session_start();

	if (isset($_SESSION["user_id"]))
	{
		$mysqli = require __DIR__ . "/database.php";

		$sql = "SELECT * FROM user
				WHERE id = {$_SESSION["user_id"]}";

		$result = $mysqli->query($sql);

		$user = $result->fetch_assoc();
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>

<body>

	<h1>Home</h1>

	<?php if (isset($user)): ?>
		<p>Welcome <?=htmlspecialchars($user["email"]) ?></p>

		<p>Upload your GPS data file.</p>
		<form method="post" enctype="multipart/form-data" action="process_data.php">
  			<input type="file" id="data" name="data">
  			<input type="submit">
		</form>

		<p><a href="logout.php">Log out</a></p>
	<?php else: ?>
		<p><a href="login.php">Log in</a> or <a href="register.html">Create Account</a></p>
	<?php endif; ?>


</body>
</html>