<?php
session_start();
session_start();
// If the user is not logged in redirect to the login page...
if ($_SESSION['loggedin'] == FALSE) {
header('Location: index.html');
exit();
}
if ($_SESSION['NEXT2'] == FALSE) {
    header('Location: home.php');
    exit();
    }
    
// Change this to your connection info.
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'dbisproject';
//Try and connect using the info above.
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
	// If there is an error with the connection, stop the script and display the error.
	die ('Failed to connect to MySQL: ' . mysqli_connect_error());
}


if (isset($_POST['paybutton'])) {

    $_SESSION['NEXT2'] = FALSE;

$stmt = $con->prepare("SELECT item_name, issuer_id, interest, security_deposit, max_lend_days FROM item WHERE item_id = ?");

if (!stmt)
{   echo "s";
    throw new Exception ($stmt->error, $stmt->errno);
}

$stmt->bind_param('i', $_POST["itemid"]);

if(!$stmt->execute())
{   echo "stmt";
    throw new Exception($stmt->error, $stmt->errno);
}

else{
    $stmt->execute();
    $stmt->bind_result($itemname, $issuerid, $interest, $secdepo, $mld);
    $stmt->fetch();
    $stmt->close();

    
}





$stmt2 = $con->prepare("SELECT wallet FROM user WHERE user_id = ?");

if (!stmt2)
{   
    throw new Exception ($stmt2->error, $stmt2->errno);
}

$stmt2->bind_param('s', $_SESSION["id"]);

if(!$stmt2->execute())
{       throw new Exception($stmt2->error, $stmt2->errno);
}

else
{
    $stmt2->execute();
    $stmt2->bind_result($walletamt);
    $stmt2->fetch();
    $stmt2->close();
}

if ((int)$_POST["deliveryfees"] + $interest + $secdepo <= $walletamt)
{ 
    $stmt1 = $con->prepare("UPDATE item SET status = 'Borrowed' WHERE item_id = ?");

if (!stmt1)
{   
    throw new Exception ($stmt1->error, $stmt1->errno);
}

$stmt1->bind_param('i', $_POST['itemid']);

if(!$stmt1->execute())
{       throw new Exception($stmt1->error, $stmt1->errno);
}

else
{
    $stmt1->execute();
    $stmt1->close();
}  
    $stmt3 = $con->prepare("UPDATE user SET wallet = ? WHERE user_id = ?");

    

    if (!stmt3)
    {   
        throw new Exception ($stmt3->error, $stmt3->errno);
    }

    $finalamt = $walletamt - $interest - $secdepo - $_POST["deliveryfees"];
    
    $stmt3->bind_param('is',$finalamt , $_SESSION["id"]);

    if(!$stmt3->execute())
    {   
        throw new Exception($stmt3->error, $stmt3->errno);
    }

    else
    {
        $stmt3->execute();
        $stmt3->bind_result($walletamt);
        $stmt3->fetch();
        $stmt3->close();
         
    }
    $stmt5 = $con->prepare("UPDATE user SET wallet = wallet + ? WHERE user_id = ?");

    

    if (!stmt5)
    {   
        throw new Exception ($stmt5->error, $stmt5->errno);
    }
    
    $stmt5->bind_param('is',$interest , $issuerid);

    if(!$stmt5->execute())
    {   
        throw new Exception($stmt5->error, $stmt5->errno);
    }

    else
    {
        //$stmt5->execute();
        //$stmt5->bind_result($walletamt);
        $stmt5->fetch();
        $stmt5->close();
         
    }
    $stmt6 = $con->prepare("UPDATE admin SET admin_wallet = admin_wallet + ? WHERE admin_id = 'admin'");

    

    if (!stmt6)
    {   
        throw new Exception ($stmt6->error, $stmt6->errno);
    }
    
    $stmt6->bind_param('i',$secdepo);

    if(!$stmt6->execute())
    {   
        throw new Exception($stmt6->error, $stmt6->errno);
    }

    else
    {
        //$stmt5->execute();
        //$stmt5->bind_result($walletamt);
        $stmt6->fetch();
        $stmt6->close();
         
    }
    $itemid = $_POST['itemid'];
    $borrowerid = $_SESSION["id"];
    $stmt4 = $con->prepare("INSERT INTO transaction(item_id, borrower_id, borrowing_date,packaging1_id,packaging2_id,ongoing_status) VALUES(?,?,CURDATE(), '1234', '1234','ongoing')");
    //mysqli_query($con,$stmt4);
    //echo mysqli_error($con);
    if (!stmt4)
    {   
        throw new Exception ($stmt4->error, $stmt4->errno);
    }

     $stmt4->bind_param('is',$_POST['itemid'], $_SESSION["id"]);

    if(!$stmt4->execute())
    {       throw new Exception($stmt4->error, $stmt4->errno);
    }

    else
    {
     //$stmt4->execute();
     $stmt4->fetch();
     $stmt4->close();
     echo "<h2 align='center'>Payment Done. Redirecting to Home page....</h2>";
     header( "refresh:10; url=home.php" );
    }
    
}
else
{
    echo "<h2>Insufficient Funds.Kindly add funds to your wallet. Redirecting to profile page....</h2>";
    header( "refresh:10; url=profile.php" );
}



}
else
{
 $stmt = $con->prepare("SELECT item_name, issuer_id, interest, security_deposit, max_lend_days FROM item WHERE item_id = ?");

if (!stmt)
{   echo "s";
    throw new Exception ($stmt->error, $stmt->errno);
}

$stmt->bind_param('i', $_POST["itemid"]);

if(!$stmt->execute())
{   echo "stmt";
    throw new Exception($stmt->error, $stmt->errno);
}

else{
    $stmt->execute();
    $stmt->bind_result($itemname, $issuerid, $interest, $secdepo, $mld);
    $stmt->fetch();
    $stmt->close();

    
}   
?>
<!DOCTYPE html>
    <head>
        <title>Payment Summary</title>
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

    <div class="card border-dark mb-3" style="max-width:30rem;margin:auto;">
    <br>
  <h3 style="margin-left:10%;"><p class="text-primary"><strong>Payment Summary</strong></p></h3>
  <div class="card-body" style="margin:auto;">

  
        
        <p>Itemname: <?php echo $itemname; ?></p>
        <p>Max Days Lent: <?php echo $mld ; ?></p>
        <p>Interest: <?php echo $interest ; ?></p>
        <p>Security Deposit: <?php echo $secdepo ; ?></p>
        <p>Delivery Fees: <?php echo $_POST["deliveryfees"]; ?></p>

        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <input type="hidden" name="itemid" value=<?php echo $_POST['itemid'];?>>
            <input type="hidden" name="deliveryfees" value=<?php echo $_POST['deliveryfees'];?>>
        <input class="btn btn-primary" type="submit" name="paybutton" value="Confirm Payment">
    
  </div>
</div>




        

</form>


        
    </body>
</html>
<?php
}
?>