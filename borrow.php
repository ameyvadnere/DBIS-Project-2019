<!DOCTYPE html>
    <head>

    </head>
    <body>
        <p>Select mode of delivery: </p>

        <form action="payment.php" method="POST">
            <input type="radio" name="mode_of_delivery" value="0">Pickup yourself<br>
            <input type="radio" name="mode_of_delivery" value="60">Indian Post<br>
            <input type="radio" name="mode_of_delivery" value="80">Delhivery<br>
            <input type="radio" name="mode_of_delivery" value="100">FedEx<br><br>
            <input type="submit" name="deliverymode" value="Pay">
        </form>

    </body>
</html>