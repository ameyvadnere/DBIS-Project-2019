<?php
session_start();
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






$stmt = $con->prepare("SELECT item_name, interest, security_deposit, max_lend_days FROM item WHERE item_id = ?");

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
    $stmt->bind_result($itemname, $interest, $secdepo, $mld);
    $stmt->fetch();
    $stmt->close();

    
}


$stmt1 = $con->prepare("UPDATE item SET status = 'Borrowed' WHERE item_id = ?");

if (!stmt1)
{   echo "s1";
    throw new Exception ($stmt1->error, $stmt1->errno);
}

$stmt1->bind_param('i', $_POST['itemid']);

if(!$stmt1->execute())
{   echo "stmt1";
    throw new Exception($stmt1->error, $stmt1->errno);
}

else
{
    $stmt1->execute();
    $stmt1->close();
}


$stmt2 = $con->prepare("SELECT wallet FROM user WHERE user_id = ?");

if (!stmt2)
{   echo "s2";
    throw new Exception ($stmt2->error, $stmt2->errno);
}

$stmt2->bind_param('s', $_SESSION["id"]);

if(!$stmt2->execute())
{   echo "stmt2";
    throw new Exception($stmt2->error, $stmt2->errno);
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
    $stmt3 = $con->prepare("UPDATE user SET wallet = ? WHERE user_id = ?");

    

    if (!stmt3)
    {   echo "s3";
        throw new Exception ($stmt3->error, $stmt3->errno);
    }

    $finalamt = $walletamt - $interest - $secdepo - $_POST["deliveryfees"];
    echo $walletamt - $interest - $secdepo - $_POST["deliveryfees"];
    echo "------";

    $stmt3->bind_param('is',$finalamt , $_SESSION["id"]);

    if(!$stmt3->execute())
    {   echo "stmt3";
        throw new Exception($stmt3->error, $stmt3->errno);
    }

    else
    {
        $stmt3->execute();
        $stmt3->bind_result($walletamt);
        $stmt3->fetch();
        $stmt3->close();
        header( "refresh:10; url=profile.php" ); 
    }
}

else
{
    echo "Insufficient Funds";
}




?>

<!DOCTYPE html>
    <head>
        <title>Payment Summary</title>
    </head>
    <body>
        <h4>Payment Summary</h4>
        
        <p>Itemname: <?php echo $itemname; ?></p>
        <p>Max Days Lent: <?php echo $mld ; ?></p>
        <p>Interest: <?php echo $interest ; ?></p>
        <p>Security Deposit: <?php echo $secdepo ; ?></p>
        <p>Delivery Fees: <?php echo $_POST["deliveryfees"]; ?></p>

        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

        <input type="submit" name="paybutton" value="Confirm Payment">

</form>


        
    </body>
</html>