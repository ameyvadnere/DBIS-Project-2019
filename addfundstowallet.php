<!DOCTYPE html>
    <head>
    <title>Add Funds To Wallet</title>
    </head>
    <body>
        <form method="POST" action="bankpage.php">
            <p> Enter Card Details </p>

            Enter Name on the Card <input type="text" name="cardname"> <br>
            Card Number <input type="text" name="cardno">
            Expiry Date <input type="text" name="expirydate">
            CVV <input type="text" name="cvv">
            Enter Amount: <input type="number" name="amt">

            <input type="submit" name="taketobankpage" value="Add Funds">
        </form>
    </body>
</html>