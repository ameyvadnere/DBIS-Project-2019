<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if ($_SESSION['loggedin'] == FALSE) {
header('Location: index.html');
exit();
}
$_SESSION['NEXT'] = TRUE;
$_SESSION['prev'] = FALSE;
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';  
$DATABASE_NAME = 'dbisproject';
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
die ('Failed to connect to MySQL: ' . mysqli_connect_error());
}

$stmt = $con->prepare('SELECT item_id, item_name, tag, interest, security_deposit, status, image_name FROM item where issuer_id <> ?');

if (!$stmt) {
    throw new Exception($con->error, $con->errno);
}
$stmt->bind_param('s', $_SESSION['id']);
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

<style> 
@import url('https://fonts.googleapis.com/css?family=Merriweather&display=swap');
</style>

<link href="bootstrap-lumen.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
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
            <li class="nav-item">
              <form action="authenticate.php" method="POST">
                <button class="nav-link btn btn-primary-outline"><input type="hidden" name="logout">Logout</button>
              </form>
            </li> 
            
						
					</div>
				  </nav>

<br>
<div class="container">
  <h1 display="mb-2 md-2" style="text-align: center; font-family: 'Merriweather', serif;
">Items For Sale</h1>
  <br>
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
          $imagepath = $row['image_name'];?>
          
        <div class="col-sm-4">

                <div class="card mb-3" style="">
                  <div class="card-body">
                    <h5 class="card-title"><?php echo $row['item_name'] ?></h5>
                    <h6 class="card-subtitle text-muted"><?php echo $row['tag'] ?> </h6>
                  </div>
                  <img style="height: 200px; width: 100%; display: block;" src="images/<?php echo $row['image_name']; ?>"  alt="Card image">
                  
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item"><?php echo 'Fees: '. $row['interest'] ?></li>
                    <li class="list-group-item"><?php echo 'Sec Deposit: '.$row['security_deposit'] ?></li>
                    <li class="list-group-item"><?php echo 'Status: ' .$row['status'] ?></li>
                  </ul>
                  
                        <?php 
                          if (strcmp("Borrowed", $row['status']) && strcmp("Not Available", $row['status'])){ ?>
                            <div class="card-body">
                              <form method="GET" action="itemdescription.php?item_id=$itemid">
                                <button class="btn btn-outline-primary"><input type="hidden" name="item_for_borrowing" value=<?php echo $row['item_id']; ?>>Borrow</button>
                              </form>
                            </div>
                        <?php } ?>
                  
                </div>
        </div>
      <?php } ?>
      
    </div>
</div>





</body>
</html>