<?php
session_start();
    // If the user is not logged in redirect to the login page...
    if ($_SESSION['adminloggedin'] == FALSE) {
        header('Location: admin_index.html');
        exit();
    }
    $DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'dbisproject';
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
	// If there is an error with the connection, stop the script and display the error.
	die ('Failed to connect to MySQL: ' . mysqli_connect_error());
}
$stmt2 = $con->prepare("SELECT admin_wallet FROM admin WHERE admin_id = 'admin'");
$stmt2->execute();
    $stmt2->bind_result($walletamt);
    $stmt2->fetch();
    $stmt2->close();
    
    ?>

<!DOCTYPE html>
    <head>  
        <title>Admin Wallet Amount</title>
    </head>
    <body>
        <center><h2><?php echo "Admin Wallet Amount is $walletamt"; ?></h2></center>
    </body>
</html>
