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
$DATABASE_PASS = '';
$DATABASE_NAME = 'dbisproject';
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
	die ('Failed to connect to MySQL: ' . mysqli_connect_error());
}
// We don't have the password or email info stored in sessions so instead we can get the results from the database.
$stmt = $con->prepare('SELECT user_id, user_password, name, phone_number, email_id, address, account_num, bank_name, IFSC_code FROM user WHERE user_id = ?');
// In this case we can use the account ID to get the account info.
$stmt->bind_param('s', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($user_id, $user_password, $name, $phone_number, $email_id, $address, $account_num, $bank_name, $IFSC_code);
$stmt->fetch();
$stmt->close();

$stmt = $con->prepare('SELECT item_id, item_name, tag, status, interest, security_deposit, max_lend_days FROM item WHERE issuer_id = ?');

if (!$stmt) {
    throw new Exception($con->error, $con->errno);
}
$stmt->bind_param('s', $_SESSION['id']);
if (!$stmt->execute()) {
//echo "dfkslfa";
    throw new Exception($stmt->error, $stmt->errno);
}
else{
$stmt->execute();
//echo "Executed";
//throw new Exception($stmt->error, $stmt->errno);
}

$result = $stmt->get_result();
$num_of_rows = $result->num_rows;
$stmt->close();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["EditCreds"]))
{
	$editstmt = $con->prepare('UPDATE user SET user_password = ?, name = ?, phone_number = ?, email_id = ?, address = ?, account_num = ?, bank_name = ?, IFSC_code = ? WHERE user_id = ?');
	$editstmt->bind_param('sssssssss', $_POST["update_password"], $_POST["update_name"], $_POST["update_phone"], $_POST["update_email"], $_POST["update_address"], $_POST["update_account"], $_POST["update_bank"], $_POST["update_ifsc"], $_SESSION["id"]);
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
		<p><?php echo "Name: " . $name . '<br>'; ?><p>
		<p><?php echo "Phone No.: " . $phone_number . '<br>'; ?><p>
		<p><?php echo "Email ID: " . $email_id . '<br>'; ?><p>
		<p><?php echo "Address: " . $address . '<br>'; ?><p>
		<p><?php echo "Account Number: " . $account_num . '<br>'; ?><p>
		<p><?php echo "Bank Name: " . $bank_name . '<br>'; ?><p>
		<p><?php echo "IFSC Code: " . $IFSC_code . '<br>'; ?><p>
		
		<button type="submit" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Edit Personal Information</button>
		

        <?php
		while ($row = $result->fetch_assoc())
		{ echo '<p>';
		echo 'Item ID: '. $row['item_id'].'<br>';
		echo 'Item Name: '. $row['item_name'].'<br>';
		echo 'Tag: '. $row['tag'].'<br>';
		echo 'Status: '. $row['status'].'<br>';
		echo 'Interest:'. $row['interest'].'<br>';
		echo 'Security Deposit:' .$row['security_deposit'].'<br>';
		echo 'Max Lend Days:' .$row['max_lend_days'].'<br>----------------------------------';
		echo '</p>';
		echo '<button type="submit" id='.$row["item_id"].'"class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Edit Personal Information</button>';
		}
		?>

		<div class="modal fade" id="myModal" role="dialog">
		<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 id="testpara" class="modal-title">Modal Header</h4>
			<p ></p>
			</div>
			<div class="modal-body">
			<?php  echo "<script type='text/javascript'>document.getElementById('testpara').innerHTML = document.getElementById(".$row['item_id'].").id</script>" ?>;
			<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
				Password: <input type="text" name="update_password" value="<?php echo htmlspecialchars($user_password);?>"><br><br>
				Name: <input type="text" name="update_name" value="<?php echo htmlspecialchars($name);?>"><br><br>
				Phone No.: <input type="text" name="update_phone" value="<?php echo htmlspecialchars($phone_number);?>"><br><br>
				Email ID: <input type="text" name="update_email" value="<?php echo htmlspecialchars($email_id);?>"><br><br>
				Address: <input type="text" name="update_address" value="<?php echo htmlspecialchars($address);?>"><br><br>
				Account Number: <input type="text" name="update_account" value="<?php echo htmlspecialchars($account_num);?>"><br><br>
				Bank Name: <input type="text" name="update_bank" value="<?php echo htmlspecialchars($bank_name);?>"><br><br>
				IFSC Code: <input type="text" name="update_ifsc" value="<?php echo htmlspecialchars($IFSC_code);?>"><br><br>
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