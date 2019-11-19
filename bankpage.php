





<!DOCTYPE html>
    <head>
       <title> Bank Page </title>
       <link rel="stylesheet" href="bootstrap-lumen.css">
    </head>
    <body>
        <p>
            <center>
            <form method="POST" action="fundsadded.php">

                <h3 class="text-primary">Enter High Security Password:</h3> <input class="form-control-lg" type="password" name="ehsp"><br>
                <input type="hidden" name="taketofundsadded" value=<?php echo $_POST["amt"]?> >
                <br>
                <input class="btn btn-success btn-lg" type="submit" name="confirm" value="Confirm" >
                
            </form>
</center>
        </p>
    </body>
</html>