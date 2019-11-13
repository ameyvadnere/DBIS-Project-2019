<?php 
    session_start();
    // If the user is not logged in redirect to the login page...
    if (!isset($_SESSION['loggedin'])) {
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
        $DATABASE_PASS = 'oblivion';
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
    <title>Add Item</title>

  <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">

  <?php echo $_SESSION['id']; ?>

        Item Name: <input type = "text" name="itemname" value="<?php echo htmlspecialchars($itemname);?>">
        <span class="error">*<?php echo $itemnameErr; ?></span>
        <br>        <br>
        Tag: <input type="text" name="tag" value="<?php echo htmlspecialchars($tag);?>">
        <br><br>
        Status: <span class="error">*<?php echo $statusErr; ?></span>
        <br><input type="radio" name="status" value="Available"> Available<br>
        <input type="radio" name="status" value="Not Available"> Not Available<br>
        <br><br>
        Interest: <input type="number" name="interest" min="0" value="<?php echo htmlspecialchars($interest);?>">
        <span class="error">*<?php echo $interestErr?></span>
        <br><br>
        Security Deposit: <input type="number" name="securitydeposit" value="<?php echo htmlspecialchars($sec_dept);?>">
        <span class="error">*<?php echo $securitydepositErr ?></span>
        <br><br>
        No. of days to be lent: <input type="number" name="maxlenddays" value="<?php echo htmlspecialchars($maxlenddays);?>">
        <span class="error">*<?php echo $maxlenddaysErr ?></span>
        <br><br>
        <input type="submit" name="additem" value="Add Item!">

    </form>

</html>