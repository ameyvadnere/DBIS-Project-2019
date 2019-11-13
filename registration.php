<?php
session_start();
$nameErr = $emailErr = $useridErr = $pswdErr = $phoneErr = "";
$userid = $pswd = $name = $phone = $email = $address = $accno = $bnknm = $ifsc = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["userid"])) {
    $useridErr = "Field is required";
   } else {
     $userid = test_input($_POST["userid"]);
   }

  if (empty($_POST["password"])) {
    $pswdErr = "Field is required";
  } else {
    $pswd = test_input($_POST["password"]);
  }

   if (empty($_POST["name"])) {
    $nameErr = "Field is required";
  } else {
    $name = test_input($_POST["name"]);
  }

  if (empty($_POST["phoneno"])) {
    $phoneErr = "Field is required";
  } else {
  	if(is_numeric($_POST["phoneno"]) && strlen($_POST["phoneno"]) == 10)
  	{
    $phone = test_input($_POST["phoneno"]);
	}
	else
	{
		$phoneErr = "Please enter valid 10-digit phone number";
	}
  }


  if (empty($_POST["email"])) {
    $emailErr = "Field is required";
  } else {
    $email = test_input($_POST["email"]);
  }

  if (empty($_POST["address"])) {
    $address = "";
    $address1 = "NULL";
  } else {
    $address = test_input($_POST["address"]);
    $address1 = $address;
  }

  if (empty($_POST["accno"])) {
    $accno = "";
    $accno1 = "NULL";
  } else {
    $accno = test_input($_POST["accno"]);
    $accno1 = $accno;
  }

  if (empty($_POST["bnknm"])) {
    $bnknm = "";
    $bnknm1 = "NULL";
  } else {
    $bnknm = test_input($_POST["bnknm"]);
    $bnknm1 = $bnknm;
  }

  if (empty($_POST["ifsc"])) {
    $ifsc = "";
    $ifsc1 = "NULL";
  } else {
    $ifsc = test_input($_POST["ifsc"]);
    $ifsc1 = $ifsc;
  }

  if(!empty($_POST["userid"]) && !empty($_POST["password"]) && !empty($_POST["name"]) && !empty($_POST["phoneno"]) && !empty($_POST["email"]))
  {
  	$servername = "localhost";
	$username = "root";
	$password = "oblivion";
	$conn = mysqli_connect($servername, $username, $password,"dbisproject");
	if (!$conn)
	{
		echo "Connection failed<br>";
	}
	else
	{
		$select_user = "SELECT * FROM user WHERE user_id='$userid'";
	    $result=mysqli_query($conn,$select_user);
		if($result->num_rows > 0)
		{
			$useridErr = "Sorry ".$userid." user id already exists";
			$userid = "";	
		}
		else
		{
			$insertion_of_user = "INSERT INTO user(user_id,user_password,name,phone_number,email_id,address,account_num,bank_name,IFSC_code) VALUES('$userid','$pswd','$name','$phone','$email','$address1','$accno1','$bnknm1','$ifsc1')";
		mysqli_query($conn,$insertion_of_user);
		$_SESSION['loggedin'] = TRUE;
		$_SESSION['id'] = $userid;
		//echo "error description".mysqli_error($conn);
  	header("Location: home.php");
	}
  }
  }
}


function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
		<link href="style.css" rel="stylesheet" type="text/css">
		<link href="bootstrap-lumen.css" rel="stylesheet" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
<title>Registration Page</title>
</head>
<body>
<!--<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

User ID: <input type="text" name="userid" value="<?php echo htmlspecialchars($userid);?>">
<span class="error">* <?php echo $useridErr;?></span>
<br><br>
Password: <input type="password" name="password" value="<?php echo htmlspecialchars($pswd);?>">
<span class="error">* <?php echo $pswdErr;?></span>
<br><br>
Name: <input type="text" name="name" value="<?php echo htmlspecialchars($name);?>">
<span class="error">* <?php echo $nameErr;?></span>
<br><br>
Phone No.: <input type="text" name="phoneno" value="<?php echo htmlspecialchars($phone);?>">
<span class="error">* <?php echo $phoneErr;?></span>
<br><br>
E-mail:
<input type="text" name="email" value="<?php echo htmlspecialchars($email);?>">
<span class="error">* <?php echo $emailErr;?></span>
<br><br>
Address:
<input type="text" name="address" value="<?php echo htmlspecialchars($address);?>">
<span class="error"><?php echo $addrErr;?></span>
<br><br>
<p>Account Details :-</p>
Account Number:
<input type="text" name="accno" value="<?php echo htmlspecialchars($accno);?>">
<span class="error"><?php echo $accnoErr;?></span>
<br><br>
Bank Name:
<input type="text" name="bnknm" value="<?php echo htmlspecialchars($bnknm);?>">
<span class="error"><?php echo $bnknmErr;?></span>
<br><br>
IFSC Code:
<input type="text" name="ifsc" value="<?php echo htmlspecialchars($ifsc);?>">
<span class="error"><?php echo $ifscErr;?></span>
<br><br>
<input type="submit" name="reg" value="Register">
</form>-->

<!--
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  <fieldset>
    <div class="form-group ">
    <label for="userid" class="col-sm-1 col-form-label">User Id</label>
    <div class="col-sm-10">
      <input type="text" class="form-control col-sm-5" id="userid" name="userid" value="<?php echo htmlspecialchars($userid);?>">
    </div>
    </div>

    <div class="form-group ">
      <label for="password" class="col-sm-1 col-form-label">Password</label>
      <div class="col-sm-10">
        <input type="password" class="form-control col-sm-5" id="password" name="password" value="">
      </div>
    </div>

    <div class="form-group ">
      <label for="name" class="col-sm-1 col-form-label" >Name</label>
      <div class="col-sm-10">
        <input type="text" class="form-control col-sm-5" id="name" name="name" value="">
      </div>
    </div>

    <div class="form-group">
      <label for="phoneno" class="col-sm-1 col-form-label" >Phone No</label>
      <div class="col-sm-10">
        <input type="text" class="form-control col-sm-5" id="phoneno" name="phoneno" value="">
      </div>
    </div>

    <div class="form-group">
      <label for="email" class="col-sm-1 col-form-label" >Email</label>
      <div class="col-sm-10">
        <input type="text" class="form-control col-sm-5" id="email" name="email" value="">
      </div>
    </div>

    <div class="form-group">
      <label for="address" class="col-sm-1 col-form-label">Address</label>
      <div class="col-sm-10">
        <textarea class="form-control" type="text" class="form-control col-sm-5" id="address" name="address" value="" rows="2"></textarea>
      </div>
    </div>

    <div class="form-group">
      <label for="accno" class="col-sm-2 col-form-label" >Account Number</label>
      <div class="col-sm-10">
        <input type="text" class="form-control col-sm-5" id="accno" name="accno" value="">
      </div>
    </div>

    <div class="form-group">
      <label for="bnknm" class="col-sm-2   col-form-label" >Bank Name</label>
      <div class="col-sm-10">
        <input type="text" class="form-control col-sm-5" id="bnknm" name="bnknm" value="">
      </div>
    </div>

    <div class="form-group">
      <label for="ifsc" class="col-sm-2  col-form-label" >Bank Name</label>
      <div class="col-sm-10">
        <input type="text" class="form-control col-sm-5" id="ifsc" name="ifsc" value="">
      </div>
    </div>

    <br><br>

    <input type="submit" class="btn btn-primary" name="reg">

  </fieldset>
</form>  -->  


<nav class="navbar navbar-expand-lg navbar-light bg-light">
					<a class="navbar-brand" href="#">Navbar</a>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor03" aria-controls="navbarColor03" aria-expanded="false" aria-label="Toggle navigation">
					  <span class="navbar-toggler-icon"></span>
					</button>
				  
					<div class="collapse navbar-collapse" id="navbarColor03">
					  <ul class="navbar-nav mr-auto">
						<li class="nav-item active">
						  <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
						</li>
						<li class="nav-item">
						  <a class="nav-link" href="#">Features</a>
						</li>
						<li class="nav-item">
						  <a class="nav-link" href="#">Pricing</a>
						</li>
						<li class="nav-item">
						  <a class="nav-link" href="#">About</a>
						</li>
					  </ul>
					  <form class="form-inline my-2 my-lg-0">
						<input class="form-control mr-sm-2" type="text" placeholder="Search">
						<button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
					  </form>
					</div>
          </nav>
          
          <br><br>

<div class="card border-dark mb-3" style="max-width: 40rem;margin-left:20%;">
  
  <div class="card-body">
    <h4 class="card-title">Register</h4>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  <fieldset>
    <div class="form-group" style="margin-left:20%;">
    <label for="userid" class="col-sm-4 col-form-label">User Id</label>
    <div class="col-sm-10">
      <input type="text" class="form-control col-sm-7" id="userid" name="userid" value="<?php echo htmlspecialchars($userid);?>">
    </div>
    </div>

    <div class="form-group" style="margin-left:20%;>
      <label for="password" class="col-sm-4 col-form-label">Password</label>
      <div class="col-sm-10">
        <input type="password" class="form-control col-sm-7" id="password" name="password" value="">
      </div>
    </div>

    <div class="form-group" style="margin-left:20%;>
      <label for="name" class="col-sm-4 col-form-label" >Name</label>
      <div class="col-sm-10">
        <input type="text" class="form-control col-sm-7" id="name" name="name" value="">
      </div>
    </div>

    <div class="form-group" style="margin-left:20%;>
      <label for="phoneno" class="col-sm-2 col-form-label" >Phone No</label>
      <div class="col-sm-10">
        <input type="text" class="form-control col-sm-7" id="phoneno" name="phoneno" value="">
      </div>
    </div>

    <div class="form-group" style="margin-left:20%;>
      <label for="email" class="col-sm-4 col-form-label" >Email</label>
      <div class="col-sm-10">
        <input type="text" class="form-control col-sm-7" id="email" name="email" value="">
      </div>
    </div>

    <div class="form-group" style="margin-left:20%;>
      <label for="address" class="col-sm-4 col-form-label">Address</label>
      <div class="col-sm-10">
        <textarea class="form-control" type="text" class="form-control" id="address" name="address" value="" rows="2"></textarea>
      </div>
    </div>

    <div class="form-group" style="margin-left:20%;>
      <label for="accno" class="col-sm-4 col-form-label" >Account Number</label>
      <div class="col-sm-10">
        <input type="text" class="form-control col-sm-7" id="accno" name="accno" value="">
      </div>
    </div>

    <div class="form-group" style="margin-left:20%;>
      <label for="bnknm" class="col-sm-4   col-form-label" >Bank Name</label>
      <div class="col-sm-10">
        <input type="text" class="form-control col-sm-7" id="bnknm" name="bnknm" value="">
      </div>
    </div>

    <div class="form-group" style="margin-left:20%;>
      <label for="ifsc" class="col-sm-4  col-form-label" >IFSC Code</label>
      <div class="col-sm-10">
        <input type="text" class="form-control col-sm-7" id="ifsc" name="ifsc" value="">
      </div>
    </div>

    <br><br>

    <input style="margin-left:20%" type="submit" class="btn btn-primary" name="reg">

  </fieldset>
</form>
  </div>

</div>


</body>
</html>