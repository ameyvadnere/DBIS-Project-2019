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

$stmt = $con->prepare("UPDATE user SET wallet = ? WHERE user_id = ?");

if (!$stmt){
    echo "stmt error";
    //throw new Exception($stmt->error, $stmt->errno);
}

$stmt->bind_param("ds", $_POST["taketofundsadded"], $_SESSION["id"]);

if (!$stmt->execute()) {
    echo "dfkslfa";
        //throw new Exception($stmt->error, $stmt->errno);
    }

    else{
    $stmt->execute();
    //echo "Executed";
    //throw new Exception($stmt->error, $stmt->errno);
    $stmt->close();
    }


?>

<!DOCTYPE html>
    <head>
        <title>Funds Confirmation</title>
        <script type="text/javascript">
            window.setTimeout(function(){
                document.getElementById("waittime").style.display = 'none';
                document.getElementById("fundsadded").style.display = '';
            }, 5000)

        </script>

    </head>

    
<body>
    <?php echo $_POST["taketofundsadded"]; ?>
    <p id="waittime" style="display:">Please wait for confirmation....</p>

    <div id="fundsadded" style="display:none">
        <p>Funds Added!</p>
        <!--<button><a href="profile.php">Go back to Profile Page</a></button> -->
        <?php 
  header( "refresh:10; url=profile.php" ); 
?>
</div>
</body>

</html>