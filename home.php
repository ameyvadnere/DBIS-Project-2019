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

$stmt = $con->prepare('SELECT item_id, item_name, tag, interest, security_deposit, status FROM item');

if (!$stmt) {
    throw new Exception($con->error, $con->errno);
}

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


?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Home Page</title>

<link href="style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>

<div class="container">
  <div class="row">

<?php

while ($row = $result->fetch_assoc())
{ /*echo '<p>';
echo 'Item: '. $row['item_name'].'<br>';
echo 'Tag: '. $row['tag'].'<br>';
echo 'Interest:'. $row['interest'].'<br>';
echo 'Security Deposit:' .$row['security_deposit'].'<br>';
echo 'Status:' .$row['status'].'<br>----------------------------------';
echo '</p><br><br>';*/

  
$itemid = $_GET["item_for_borrowing"];


?>



<div class="col-sm-4>">
<div class="card-columns-fluid">
<div class="card mb-3" style=" width: 60%">
  <h3 class="card-header">Card header</h3>
  <div class="card-body">
    <h5 class="card-title"><?php echo $row['item_name'] ?></h5>
    <h6 class="card-subtitle text-muted"><?php echo $row['tag'] ?> </h6>
  </div>
  <img style="height: 200px; width: 100%; display: block;" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22318%22%20height%3D%22180%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20318%20180%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_158bd1d28ef%20text%20%7B%20fill%3Argba(255%2C255%2C255%2C.75)%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A16pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_158bd1d28ef%22%3E%3Crect%20width%3D%22318%22%20height%3D%22180%22%20fill%3D%22%23777%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%22129.359375%22%20y%3D%2297.35%22%3EImage%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" alt="Card image">
  <div class="card-body">
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
  </div>
  <ul class="list-group list-group-flush">
    <li class="list-group-item"><?php echo 'Interest: '. $row['interest'] ?></li>
    <li class="list-group-item"><?php echo 'Sec Deposit: '.$row['security_deposit'] ?></li>
    <li class="list-group-item"><?php echo 'Status: ' .$row['status'] ?></li>
  </ul>
  <div class="card-body">
    <form method="GET" action="itemdescription.php?item_id=$itemid">
      <button><input type="hidden" name="item_for_borrowing" value=<?php echo $row['item_id']; ?>>Borrow</button>
    </form>
  </div>
  <div class="card-footer text-muted">
    2 days ago
  </div>
</div>
</div>
<?php } ?>

</div>

</div>





</body>
</html>