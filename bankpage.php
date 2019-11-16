





<!DOCTYPE html>
    <head>
       <title> Bank Page </title>
    </head>
    <body>
        <p>
            <form method="POST" action="fundsadded.php">
                Enter High Security Password: <input type="text" name="ehsp"><br>
                <input type="hidden" name="taketofundsadded" value=<?php echo $_POST["amt"]?> >
                <input type="submit" name="confirm" value="Confirm" >
                
            </form>

        </p>
    </body>
</html>