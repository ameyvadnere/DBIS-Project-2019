<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit();
}
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = 'oblivion';
$DATABASE_NAME = 'dbisproject';
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
	die ('Failed to connect to MySQL: ' . mysqli_connect_error());
}
// We don't have the password or email info stored in sessions so instead we can get the results from the database.
$stmt = $con->prepare('SELECT user_id, username, password FROM LoginTable WHERE user_id = ?');
// In this case we can use the account ID to get the account info.
$stmt->bind_param('s', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($user_id, $username, $password);
$stmt->fetch();
$stmt->close();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["EditCreds"]))
{
	$editstmt = $con->prepare('UPDATE LoginTable SET username = ?, password = ? WHERE user_id = ?');
	$editstmt->bind_param('sss', $_POST["updated_username"], $_POST["updated_password"], $_SESSION["id"]);
	$editstmt->execute();
	$editstmt->close();
	header('Location:profile.php');
}

?>


<html>
	<head>
		<title>My Profile</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
	</head>

	<body>

	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">Navbar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
	<span class="navbar-toggler-icon"></span>
	
	<div class="collapse navbar-collapse" id="navbarColor02">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="profile.php">Profile</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Pricing</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">About</a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="text" placeholder="Search">
      <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>


  </button>
		<p><?php echo "User Id: " . $user_id . '<br>'; ?><p>
		<p><?php echo "User Name: " . $username . '<br>'; ?><p>
		<p><?php echo "Password: " . $password . '<br>'; ?><p>

		<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Edit Information</button>

		<div class="modal fade" id="myModal" role="dialog">
		<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Modal Header</h4>
			</div>
			<div class="modal-body">
			<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
				Username: <input type="text" name="updated_username" value="<?php $username ?>"><br><br>
				Password: <input type="text" name="updated_password" value="<?php $password ?>"><br><br>
				<input type="submit" name="EditCreds" value="Edit Information">
			</form>
			</div>
			<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
      </div>
    </div>
  </div>
</div>

	</body>

</html>

