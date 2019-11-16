<?php

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

    </head>
    <body>
        <p>Select mode of delivery: </p>

        <form action="payment.php" method="POST">
            <input type="radio" name="deliveryfees" value="0">Pickup yourself<br>
            <input type="radio" name="deliveryfees" value="60">Indian Post<br>
            <input type="radio" name="deliveryfees" value="80">Delhivery<br>
            <input type="radio" name="deliveryfees" value="100">FedEx<br><br>
            <input type="hidden" name="itemid" value=<?php echo $_POST['itemid'];?>>
            <input type="submit" name="deliverymode" value="Pay">
        </form>
        <?php echo $_POST['itemid']; ?>
    </body>
</html>