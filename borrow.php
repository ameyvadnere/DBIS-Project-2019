<?php

session_start();
// If the user is not logged in redirect to the login page...
if ($_SESSION['loggedin'] == FALSE) {
header('Location: index.html');
exit();
}
if ($_SESSION['NEXT1'] == FALSE) {
    header('Location: home.php');
    exit();
    }
    $_SESSION['NEXT1'] = FALSE;
    $_SESSION['NEXT2'] = TRUE;
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';  
$DATABASE_NAME = 'dbisproject';
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
die ('Failed to connect to MySQL: ' . mysqli_connect_error());
}

$stmt = $con->prepare('SELECT address FROM user WHERE user_id = ?');

if (!$stmt) {
    echo "error in stmt";
    throw new Exception($con->error, $con->errno);
}
$stmt->bind_param('s',$_SESSION['id']);
if (!$stmt->execute()) {
    echo "error in executed";
    //throw new Exception($stmt->error, $stmt->errno);
}
else{

//echo "Executed";
//throw new Exception($stmt->error, $stmt->errno);

$stmt->execute();
$stmt->bind_result($address);
$stmt->fetch();
$stmt->close();
//echo $item_name;
//throw new Exception($stmt->error, $stmt->errno);
}
?>

<!DOCTYPE html>
    <head>
        <title>Delivery Method</title>
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
    
  <h3  class="card-header" style="text-align: center;><p class="text-primary"><strong>Select Delivery Mode</strong></p></h3>
  <div class="card-body" style="margin:auto;">
  <div class="container">
            <div class="row justify-content-center" style="margin-left:-50%;">
                    <div class="col-md-6 col-lg-6 col-xs-6 col-sm-6">
                            <h3 display ="md-4">Select mode of delivery: </h3>
                        <br>
                    <form action="payment.php" method="POST">
                    
                        
                        

                    <input type="radio" id="customRadio1" name="deliveryfees" value="0" required>Pickup yourself<br></label>
                    <input  id="customRadio2" type="radio" name="deliveryfees" value="60">Indian Post<br>
                    <input  type="radio" id="customRadio3" name="deliveryfees" value="80">Delhivery<br>
                    <input  type="radio" id="customRadio4" name="deliveryfees" value="100">FedEx<br><br>
                    <input type="hidden" name="itemid" value=<?php echo $_POST['itemid']; ?>                            >
                        <input class="btn btn-primary" type="submit" name="deliverymode" value="Pay">
                    </form>
                </div>
            </div>
        </div>
    
  </div>
</div>

        

    </body>
</html>