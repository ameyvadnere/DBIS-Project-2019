<?php

session_start();
// If the user is not logged in redirect to the login page...
if ($_SESSION['loggedin'] == FALSE) {
header('Location: index.html');
exit();
}

if ($_SESSION['NEXT'] == FALSE) {
    header('Location: home.php');
    exit();
    }
    $_SESSION['NEXT'] = FALSE;
    $_SESSION['NEXT1'] = TRUE;
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';  
$DATABASE_NAME = 'dbisproject';
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
die ('Failed to connect to MySQL: ' . mysqli_connect_error());
}

$stmt = $con->prepare('SELECT * FROM item WHERE item_id = ?');

if (!$stmt) {
    echo "error in stmt";
    throw new Exception($con->error, $con->errno);
}
$stmt->bind_param('i', $_GET['item_for_borrowing']);
if (!$stmt->execute()) {
    echo "error in executed";
    throw new Exception($stmt->error, $stmt->errno);
}
else{

//echo "Executed";
//throw new Exception($stmt->error, $stmt->errno);

$stmt->execute();
$stmt->bind_result($itemid, $issuer_id, $item_name, $tag, $photo, $status, $interest,  $security_deposit, $max_lend_days, $image_name);
$stmt->fetch();
$stmt->close();
//echo $item_name;
//throw new Exception($stmt->error, $stmt->errno);
}


$stmt1 = $con->prepare('SELECT name FROM user WHERE user_id = ?');

if (!$stmt1) {
    throw new Exception($con->error, $con->errno);
}

$stmt1->bind_param('s', $issuer_id);
if (!$stmt1->execute()) {
    throw new Exception($stmt1->error, $stmt1->errno);
}
else{
$stmt1->execute();
$stmt1->bind_result($issuer_name);
$stmt1->fetch();
$stmt1->close();
}

?>

<!DOCTYPE html>
    <head>
        <title>ItemDescription</title>
        <link rel="stylesheet" href="bootstrap-lumen.css">
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
						  <a class="nav-link" href="history.php">History</a>
						</li>
						
					</div>
                  </nav>
                  
        <br><br><br>

        <div class="card border-dark mb-3" style="max-width:40rem;margin:auto;">
  <h3 class="card-header" style="text-align: center;"><p class="text-primary"><strong>Borrow</strong></p></h3>
  <div class="card-body" style="margin:auto;">
  <p>Item Name: <?php echo $item_name; ?></p>
        <p>Issuer Name: <?php echo $issuer_name; ?></p>
        <p>Tag: <?php echo $tag; ?></p>
        <p>Fees: <?php echo $interest; ?></p>
        <p>Security Deposit: <?php echo $security_deposit; ?></p>
        <p>Maximum Days To Be Lent For: <?php echo $max_lend_days; ?></p>


        <form action="borrow.php" method="POST">
            <input type="hidden" name="itemid" value=<?php echo $_GET['item_for_borrowing'];?>>
            <button class="btn btn-primary"><input class="btn btn-success" type="hidden" name="borrow_button">Borrow</button>
        </form> 
    
  </div>
</div>

        
    </body>
</html>

