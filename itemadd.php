<?php 
    session_start();
    // If the user is not logged in redirect to the login page...
    if ($_SESSION['loggedin'] == FALSE) {
        header('Location: index.html');
        exit();
    }

    $itemnameErr = $tagErr = $interestErr = $securitydepositErr = $maxlenddaysErr = "";
    $itemname = $tag = $interest = $sec_dept = $maxlenddays = "";
    $status = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if (empty($_POST["itemname"]))
        {
            $itemnameErr = "Field is required!";
        }
        else
        {
            $itemname = test_input($_POST["itemname"]);
        }

        if (empty($_POST["status"]))
        {
            $statusErr = "Field is required";
        }
        else
        {
            $status = test_input($_POST["status"]);
        }

        if (empty($_POST["interest"]))
        {
            $interestErr = "Field is required";
        }
        else
        {
            $interest = test_input($_POST["interest"]);
        }

        if (empty($_POST["securitydeposit"]))
        {
            $securitydepositErr = "Field is required";
        }
        else
        {
            $sec_dept = test_input($_POST["securitydeposit"]);
        }

        if (empty($_POST["maxlenddays"]))
        {
            $maxlenddaysErr = "Field is required";
        }
        else
        {
            $maxlenddays = test_input($_POST["maxlenddays"]);
        }
    }

    if (!empty($_POST["itemname"]) && !empty($_POST["status"]) && !empty($_POST["interest"]) && !empty($_POST["securitydeposit"]) && !empty($_POST["maxlenddays"]))
    {
        $DATABASE_HOST = 'localhost';
        $DATABASE_USER = 'root';
        $DATABASE_PASS = '';
        $DATABASE_NAME = 'dbisproject';
        // Try and connect using the info above.
        $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
        if ( mysqli_connect_errno() ) {
            // If there is an error with the connection, stop the script and display the error.
            die ('Failed to connect to MySQL: ' . mysqli_connect_error());
        }

       

        /*$stmt = $con->prepare('INSERT INTO item(item_id, issuer_id, item_name, status, interest, security_deposit, max_lend_days) VALUES (41, "amefdsyiitdh", "Pfdsorsche", "Available", 34,34,23)');

        if (!$stmt) {
            throw new Exception($con->error, $con->errno);
        }

        if (!$stmt->execute()) {
            //echo "dfkslfa";
            throw new Exception($stmt->error, $stmt->errno);
        }
        else{
        $stmt->execute();
        echo "Executed";
        throw new Exception($stmt->error, $stmt->errno);
        }*/


        else
        {  
            //echo "I am in".$interest; 
            
            if (empty($_POST["tag"]))
            {
                $tag = NULL;
            }
            else
            {
                $tag = test_input($_POST['tag']);
            }
            $userid = $_SESSION['id'];
            $stmt = "INSERT INTO item(issuer_id, tag, item_name, status, interest, security_deposit, max_lend_days) VALUES ('$userid', '$tag', '$itemname', '$status', '$interest', '$sec_dept', '$maxlenddays')";
            mysqli_query($con, $stmt);
            echo "error description".mysqli_error($con);
            header('Location: home.php');
        }
    }
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>



<html>
    <head>
    <title>Add Item</title>
    <link href="bootstrap-lumen.css" rel="stylesheet" type="text/css">
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
						
					  </ul>
					  
					</div>
				  </nav>

<br><br><br><br>

                  <div class="card border-dark mb-3" style="max-width:50rem;margin:auto;">
  <h3 style="margin-left:10%;"><p class="text-primary"><strong>Add Item</strong></p></h3>
  <div class="card-body" style="align:center;">
  <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">

  

Item Name*: <input class="form-control col-sm-10" type="text" name="itemname" value="<?php echo htmlspecialchars($itemname);?>">
<span class="error"><?php echo $itemnameErr; ?></span>
<br>        <br>
Tag: <input class="form-control col-sm-10" type="text" name="tag" value="<?php echo htmlspecialchars($tag);?>">
<br><br>
Status: <span class="error"><?php echo $statusErr; ?></span>
<br><input type="radio" name="status" value="Available"> Available<br>
<input type="radio" name="status" value="Not Available"> Not Available<br>
<br><br>
Fees*: <input class="form-control col-sm-10" type="number" name="interest" min="0" value="<?php echo htmlspecialchars($interest);?>">
<span class="error"><?php echo $interestErr?></span>
<br><br>
Security Deposit*: <input class="form-control col-sm-10" type="number" name="securitydeposit" value="<?php echo htmlspecialchars($sec_dept);?>">
<span class="error"><?php echo $securitydepositErr ?></span>
<br><br>
No. of days to be lent*: <input class="form-control col-sm-10" type="number" name="maxlenddays" value="<?php echo htmlspecialchars($maxlenddays);?>">
<span class="error"><?php echo $maxlenddaysErr ?></span>
<br><br>
<input class="btn btn-primary" type="submit" name="additem" value="Add Item!">

</form>
    
  </div>
</div>


  
</body>
</html>