<?php
	// We need to use sessions, so you should always start sessions using the below code.
	session_start();
	// If the user is not logged in redirect to the login page...
	if ($_SESSION['loggedin'] == FALSE)  {
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
	$stmt_borr = $con->prepare('SELECT * FROM user as u1, user as u2,transaction, item WHERE u1.user_id = ? AND 
    u1.user_id = transaction.borrower_id AND ongoing_status = "Completed" AND 
    transaction.item_id = item.item_id AND item.issuer_id = u2.user_id;');
	// In this case we can use the account ID to get the account info.

    if (!$stmt_borr) {
		throw new Exception($con->error, $con->errno);
	}
	
	$stmt_borr->bind_param('s', $_SESSION['id']);
	
	
	if (!$stmt_borr->execute()) {
	//echo "dfkslfa";
		throw new Exception($stmt_borr->error, $stmt_borr->errno);
	}
	//else{$stmt_borr->execute();}

	$result_borr = $stmt_borr->get_result();
	$num_of_rows_borr = $result_borr->num_rows;
	$stmt_borr->close();



    $stmt_lend = $con->prepare('SELECT * FROM user as u1, user as u2,transaction, item WHERE u1.user_id = ? AND 
    u1.user_id = item.issuer_id AND ongoing_status = "Completed" AND 
    transaction.item_id = item.item_id AND transaction.borrower_id = u2.user_id;');
	// In this case we can use the account ID to get the account info.

    if (!$stmt_lend) {
		throw new Exception($con->error, $con->errno);
	}
	
	$stmt_lend->bind_param('s', $_SESSION['id']);
	
	
	if (!$stmt_lend->execute()) {
	//echo "dfkslfa";
		throw new Exception($stmt_lend->error, $stmt_lend->errno);
	}
	//else{$stmt_borr->execute();}

	$result_lend = $stmt_lend->get_result();
	$num_of_rows_lend = $result_lend->num_rows;
	$stmt_lend->close();


    
    /*
        echo 'Borrowed item details:<br>';
        echo 'Item ID: '. $row['item_id'].'<br>';
		echo 'Item Name: '. $row['item_name'].'<br>';
		echo 'Tag: '. $row['tag'].'<br>';
		echo 'Status: '. $row['status'].'<br>';
		echo 'Interest:'. $row['interest'].'<br>';
		echo 'Security Deposit:' .$row['security_deposit'].'<br>';
        echo 'Max Lend Days:' .$row['max_lend_days'].'<br>';
        echo 'Borrowing Date: '. $row['borrowing_date'].'<br>';
        echo 'Returning Date: '. $row['returning_date'].'<br>';
        echo 'Lendor Details:<br>';

        echo "Lendor Id: " . $row['user_id'] . '<br>'; 
        echo "Lendor Name: " . $row['name'] . '<br>';
        echo "Phone No.: " . $row['phone_number'] . '<br>';
        echo "Email ID: " . $row['email_id'] . '<br>';
        echo "Address: " . $row['address'] . '<br>';

            
    */



?>

<html>
	<head>
		<title>Borrowing History</title>
		<link rel="stylesheet" href="bootstrap-lumen.css">
<style>
		.container {
    width: 1000px;
}
.flex {
    display: flex;
}
.sameRow {
    border: 0px solid black;
   /* height: 100px;*/
    width: 100%;
}

</style>

	</head>

	<body>

	<nav class="navbar navbar-expand-lg navbar-light bg-light">
					<a class="navbar-brand" href="#">Navbar</a>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor03" aria-controls="navbarColor03" aria-expanded="false" aria-label="Toggle navigation">
					  <span class="navbar-toggler-icon"></span>
					</button>
				  
					<div class="collapse navbar-collapse" id="navbarColor03">
					  <ul class="navbar-nav mr-auto">
						<li class="nav-item active">
						  <a class="nav-link" href="home.php">Home <span class="sr-only">(current)</span></a>
						</li>
						<li class="nav-item">
						  <a class="nav-link" href="profile.php">Profile</a>
						</li>
						<li class="nav-item">
						  <a class="nav-link" href="itemadd.php">Keep New Item for Lease</a>
						</li>
					  </ul>
					</div>
				  </nav>

		<?php 
		while ($row = $result_borr->fetch_assoc())
		{ ?>


		


		<div class="card border-light mb-3" style="max-width:50rem;margin:auto;">
                  <br>
  <h3 style="margin-left:20%;"><p class="text-primary"><strong>History</strong></p></h3>
  <div class="card-body" style="margin:auto;">
		<div class="container">
			<div class="flex">
				<div class="samerow">
				<h3>Item Details</h3>
				<p>Tag: <?php echo $row['tag']; ?></p>
				<p>Item Name:<?php echo $row['item_name']; ?></p>
				<p>Status:<?php echo $row['status']; ?></p>
				<p>Fees:<?php echo $row['interest']; ?></p>
				<p>Security Deposit:<?php echo $row['security_deposit']; ?></p>
				<p>Max Lend Days<?php echo $row['max_lend_days']; ?></p>
				<p>Borrowing Date<?php echo $row['borrowing_date']; ?></p>
		</div>
			<div class="samerow">
				<h3>Lender Details</h3>
				<p>Lender Id: <?php echo $row['user_id']; ?></p>
				<p>Lender Name:<?php echo $row['name']; ?></p>
				<p>Phone No: <?php echo $row['phone_number']; ?></p>
				<p>Email Id: <?php echo $row['email_id']; ?></p>
				<p>Address: <?php echo $row['address']; ?></p>
		</div>
		</div>
  </div>
</div>
<br>

		<?php } ?>
	</body>
</html>