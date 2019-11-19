<?php
	// We need to use sessions, so you should always start sessions using the below code.
	session_start();
	// If the user is not logged in redirect to the login page...
	if ($_SESSION['loggedin'] == FALSE)  {
		header('Location: index.html');
		exit();
	}
	$_SESSION['prev'] = TRUE;
	$DATABASE_HOST = 'localhost';
	$DATABASE_USER = 'root';
	$DATABASE_PASS = '';
	$DATABASE_NAME = 'dbisproject';
	$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
	if (mysqli_connect_errno()) {
		die ('Failed to connect to MySQL: ' . mysqli_connect_error());
	}
	// We don't have the password or email info stored in sessions so instead we can get the results from the database.
	$stmt = $con->prepare('SELECT user_id, user_password, name, phone_number, email_id, address, account_num, bank_name, IFSC_code, wallet FROM user WHERE user_id = ?');
	// In this case we can use the account ID to get the account info.
	$stmt->bind_param('s', $_SESSION['id']);
	$stmt->execute();
	$stmt->bind_result($user_id, $user_password, $name, $phone_number, $email_id, $address, $account_num, $bank_name, $IFSC_code, $wallet);
	$stmt->fetch();
	$stmt->close();


	//total items query
	$stmt = $con->prepare('SELECT item_id, item_name, tag, status, interest, security_deposit, max_lend_days FROM item WHERE issuer_id = ?');

	if (!$stmt) {
		
		throw new Exception($stmt->error, $stmt->errno);
	}
	$stmt->bind_param('s', $_SESSION['id']);
	if (!$stmt->execute()) {
	//
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


	//currently borrowed items
	$stmt_borr = $con->prepare('SELECT * FROM transaction, item, user WHERE ongoing_status="ongoing" AND transaction.borrower_id = ? AND item.item_id = transaction.item_id AND item.issuer_id = user.user_id;');
	
	if (!$stmt_borr) {
		
		throw new Exception($stmt_borr->error, $stmt_borr->errno);
	}
	
	$stmt_borr->bind_param('s', $_SESSION['id']);
	
	
	if (!$stmt_borr->execute()) {
	//echo "dfkslfa";
		throw new Exception($stmt_borr->error, $stmt_borr->errno);
	}
	else{$stmt_borr->execute();}

	$result_borr = $stmt_borr->get_result();
	$num_of_rows_borr = $result_borr->num_rows;
	$stmt_borr->close();


	if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["EditCreds"]))
	{
		$editstmt = $con->prepare('UPDATE user SET user_password = ?, name = ?, phone_number = ?, email_id = ?, address = ?, account_num = ?, bank_name = ?, IFSC_code = ? WHERE user_id = ?');
		$editstmt->bind_param('sssssssss', $_POST["update_password"], $_POST["update_name"], $_POST["update_phone"], $_POST["update_email"], $_POST["update_address"], $_POST["update_account"], $_POST["update_bank"], $_POST["update_ifsc"], $_SESSION["id"]);
		$editstmt->execute();
		$editstmt->close();
		header('Location:profile.php');
	}


	if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["UpdateItem"]))
	{
		$editstmt = $con->prepare('UPDATE item SET item_name = ?, tag = ?, status = ?, interest = ?, security_deposit = ?, max_lend_days = ? WHERE item_id = ?');
		$editstmt->bind_param('sssddii', $_POST["update_itemname"], $_POST["update_tag"], $_POST["updatestatus"], $_POST["updateinterest"], $_POST["updatesecuritydeposit"], $_POST["updatemaxlenddays"], $_POST["itemid"]);
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
		<link rel="stylesheet" href="bootstrap-lumen.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
		
	</head>

	<body>
	
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
					<a class="navbar-brand" href="#">Navbar</a>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor03" aria-controls="navbarColor03" aria-expanded="false" aria-label="Toggle navigation">
					  <span class="navbar-toggler-icon"></span>
					</button>
				  
					<div class="collapse navbar-collapse" id="navbarColor03">
					  <ul class="navbar-nav mr-auto">
						<li class="nav-item ">
						  <a class="nav-link" href="home.php">Home <span class="sr-only">(current)</span></a>
						</li>
						<li class="nav-item active">
						  <a class="nav-link" href="profile.php">Profile</a>
						</li>
						<li class="nav-item">
						  <a class="nav-link" href="itemadd.php">Keep for Lease</a>
						</li>
						<li class="nav-item">
						  <a class="nav-link" href="history.php">History</a>
						</li>
					  </ul>
					  
					</div>
				  </nav>

	
	



<?php  
echo '<script type="text/JavaScript">  
      
     </script>' 
; 
?> 

<div class="card border-dark mb-3" style="max-width:60rem;margin:auto;">
  <h3 style="margin-left:10%;"><p class="text-primary"><strong>Personal Information</strong></p></h3>
  <div class="card-body" style="margin:auto;">
    
    <h4><?php echo "User Id: " . $user_id . '<br>'; ?><h4>
		<h4><?php echo "Name: " . $name . '<br>'; ?><h4>
		<h4><?php echo "Phone No.: " . $phone_number . '<br>'; ?><h4>
		<h4><?php echo "Email ID: " . $email_id . '<br>'; ?><h4>
		<h4><?php echo "Address: " . $address . '<br>'; ?><h4>
		<h4><?php echo "Account Number: " . $account_num . '<br>'; ?><h4>
		<h4><?php echo "Bank Name: " . $bank_name . '<br>'; ?><h4>
		<h4><?php echo "IFSC Code: " . $IFSC_code . '<br>'; ?><h4>
		<h4><?php echo "Wallet Amount: " . $wallet . '<br>'; ?><h4><br>
		<button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Edit Personal Information</button><br>
		<br>
		<form action="addfundstowallet.php" method="POST">
	
		<input class="btn btn-success" style="margin-left:10%;" type="submit" value="Add Funds to Wallet">
		
		</form>
  </div>
</div>

		

		

		
		
		
<br><br><br>
<h3 style="margin-left:10%"><p class="text-primary"><strong>Your Items</strong></p></h3>
<br>

<table class="table-hover" width="90%" style="margin:auto;">
	<thead>			
<tr class="table-primary">
			

                <th>Item Name</th>
                <th>Tag</th>
                <th>Status</th>
                <th>Interest</th>
                <th>Security Deposit</th>
				<th>Max Lend Days</th>
				<th>
			</tr>
</thead>

        <?php
		while ($row = $result->fetch_assoc())
		{ ?>
		
		
			
			<tr class="table-light">
				
				<td><?php echo $row['item_name']; ?></td>
				<td><?php echo $row['tag']; ?></td>
				<td><?php echo $row['status']; ?></td>
				<td><?php echo $row['interest']; ?></td>
				<td><?php echo $row['security_deposit']; ?></td>
				<td><?php echo $row['max_lend_days']; ?></td>
				<td><?php 
		if($row['status']!='Borrowed')
		{
			echo '<button type="submit" id='.$row["item_id"].' name='.$row["item_id"].' class="btn btn-info btn-sm" 
					data-toggle="modal" data-target="#updateItem'.$row["item_id"].'">
					Edit Item Information
					</button><br>';

		}	
		?></td>
			</tr>
        


		

  
		<div class="modal fade" id="updateItem<?php echo $row["item_id"]?>" role="dialog">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 id="testpara" class="modal-title">Update Item<?php echo $row["item_id"]?>  Details</h4>
					<p ></p>
					</div>
					<div class="modal-body">
					<?php  //echo "<script type='text/javascript'>document.getElementById('testpara').innerHTML = document.getElementById(".$row['item_id'].").name</script>"; ?>
					<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
						

						Item Name:	<input type="text" 		name="update_itemname" 	value="<?php echo htmlspecialchars($row['item_name']);?>"><br><br>
						Tag:		<input type="text" 		name="update_tag" 		value="<?php echo htmlspecialchars($row['tag']);?>"><br><br>
						Status:		<input type="radio" 	name="updatestatus" 	value="Available"		<?php if($row['status']=='Available')		{echo 'checked="checked"';}?>> Available 				   
        							<input type="radio" 	name="updatestatus" 	value="Not Available" 	<?php if($row['status']=='Not Available')	{echo 'checked="checked"';}?> > Not Available<br> 	
						Interest:	<input type="number" 	name="updateinterest" min="0" value="<?php echo htmlspecialchars($row['interest']);?>"><br>
						Security Deposit: <input type="number" name="updatesecuritydeposit" value="<?php echo htmlspecialchars($row['security_deposit']);?>"><br>
						No. of days to be lent: <input type="number" name="updatemaxlenddays" value="<?php echo htmlspecialchars($row['max_lend_days']);?>"><br>

									<input type="hidden"	name="itemid"			value="<?php echo htmlspecialchars($row["item_id"]);?>">

						<input type="submit" name="UpdateItem" value="Edit Item Information">
					</form>
					</div>
					<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
      			</div>
    		</div>
 		</div>



		<?php		
		}
		?>

	</table><br><br>




<br><br>
<h3 style="margin-left:10%"><p class="text-primary"><strong>Currently Borrowed Items</strong></p></h3>
<br>

<table width="90%" style="margin:auto;">
            <tr class='table-primary'>
                
				

				<th width="20%">Item Name</th>
                <th width="10%">Borrowing Date</th>
                <th width="15%">Issuer Name</th>
                <th width="10%">Email Id</th>
                <th width="15%">Phone No.</th>
				<th width="15%">Max Lend Days</th>
                <th></th>
            </tr>
        


	<?php
		while ($row = $result_borr->fetch_assoc())
		{?>
			
		
			<tr class="table-light">
				<td><?php echo $row['item_name']; ?></td>
				<td><?php echo $row['borrowing_date']; ?></td>
				<td><?php echo $row['name']; ?></td>
				<td><?php echo $row['email_id']; ?></td>
				<td><?php echo $row['phone_number']; ?></td>
				<td><?php echo $row['max_lend_days']; ?></td>
				<td><form method="post" action="returnborrow.php">
				
				<input type ="hidden" name = "borrowerid" 					value = <?php echo $_SESSION['id']; ?> >
				<input type ="hidden" name = "borroweditemid" 				value = <?php echo $row['item_id'];?> >
				<input type ="hidden" name = "issuerid" 					value = <?php echo $row['user_id'];?> >
				<input type ="hidden" name = "borrowedtransactionid" 		value = <?php echo $row['transaction_id'];?> > 
				<input class="btn btn-info" type ="submit" name = "itemreturn" 	value = "Return the Item">
			</form></td>
			</tr>


		<?php } ?>

		</table>
			




	<?php
		
	?>

<!-- DONT USE THIS!-->
		<div class="modal fade" id="updateItem" role="dialog">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 id="testpara" class="modal-title">Update Item Details</h4>
					<p ></p>
					</div>
					<div class="modal-body">
					<?php  //echo "<script type='text/javascript'>document.getElementById('testpara').innerHTML = document.getElementById(".$row['item_id'].").name</script>"; ?>
					<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
						

						Item Name:	<input type="text" 		name="update_itemname" 	value="<?php echo htmlspecialchars($itemname);?>"><br><br>
						Tag:		<input type="text" 		name="update_tag" 		value="<?php echo htmlspecialchars($tag);?>"><br><br>
						Status:		<input type="radio" 	name="updatestatus" 	value="Available"> Available    
        							<input type="radio" 	name="updatestatus" 	value="Not Available"> Not Available<br>
						Interest:	<input type="number" 	name="updateinterest" min="0" value="<?php echo htmlspecialchars($interest);?>"><br>
						Security Deposit: <input type="number" name="updatesecuritydeposit" value="<?php echo htmlspecialchars($sec_dept);?>"><br>
						No. of days to be lent: <input type="number" name="updatemaxlenddays" value="<?php echo htmlspecialchars($maxlenddays);?>"><br>

									<input type="hidden"	name="itemid"			value="<?php echo htmlspecialchars($item_id);?>">

						<input type="submit" name="UpdateItem" value="Edit Item Information">
					</form>
					</div>
					<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
      			</div>
    		</div>
 		</div>
<!-- DONT USE THIS!--> 

		<div class="modal fade" id="myModal" role="dialog">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<!--<h4 id="testpara" class="modal-title">Modal Header</h4>-->
					<p ></p>
					</div>
					<div class="modal-body">
					<?php  echo "<script type='text/javascript'>document.getElementById('testpara').innerHTML = document.getElementById(".$row['item_id'].").id</script>"; ?>
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
	




		 

	</body>

</html>