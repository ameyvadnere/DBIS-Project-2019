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

$stmt = $con->prepare('SELECT * FROM item WHERE item_id = ?');

if (!$stmt) {
    echo "error in stmt";
    throw new Exception($con->error, $con->errno);
}
$stmt->bind_param('i', $_GET['item_for_borrowing']);
if (!$stmt->execute()) {
    echo "error in executed";
    //throw new Exception($stmt->error, $stmt->errno);
}
else{

//echo "Executed";
//throw new Exception($stmt->error, $stmt->errno);

$stmt->execute();
$stmt->bind_result($itemid, $issuer_id, $item_name, $tag, $photo, $status, $interest,  $security_deposit, $max_lend_days);
$stmt->fetch();
$stmt->close();
//echo $item_name;
//throw new Exception($stmt->error, $stmt->errno);
}


$stmt1 = $con->prepare('SELECT name FROM user WHERE user_id = ?');

if (!$stmt1) {
    echo "kfjldsk";
    throw new Exception($con->error, $con->errno);
}

$stmt1->bind_param('s', $issuer_id);
if (!$stmt1->execute()) {
echo "dfkslfa";
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

    </head>
    <body>
        <p>Item Id: <?php echo $itemid; ?></p>
        <p>Item Name: <?php echo $item_name; ?></p>
        <p>Issuer Name: <?php echo $issuer_name; ?></p>
        <p>Tag: <?php echo $tag; ?></p>

        <form action="borrow.php" method="POST">
        <input type="hidden" name="itemid" value=<?php echo $_GET['item_for_borrowing'];?>>
            <button><input type="hidden" name="borrow_button">Borrow</button>
            
        </form> 
    </body>
</html>

