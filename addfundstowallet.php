<!DOCTYPE html>
    <head>
    <title>Add Funds To Wallet</title>
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
						
					</div>
				  </nav>

        <br><br><br><br>

                  <div class="card border-dark mb-3" style="max-width:50rem;margin:auto;">
                  <br>
  <h3 style="margin-left:20%;"><p class="text-primary"><strong>Add Funds</strong></p></h3>
  <div class="card-body" style="margin:auto;">
    <form action="bankpage.php" method="POST">
  <fieldset>
            <div class="form-group col-sm-25">
                Enter Name on the Card <input type="text" name="cardname" class="form-control "><br>
                Card Number <input type="text" name="cardno" class="form-control form-control-md"><br>
                Expiry Date <input type="text" name="expirydate" class="form-control"><br>
                CVV <input type="text" name="cvv" class="form-control"><br>
                Amount to be added <input type="number" name="amt" class="form-control">
            </div>

            <input class="btn btn-primary" type="submit" name="taketobankpage" value="Add Funds">

        </fieldset>


            
        </form>
    
  </div>
</div>



        
    </body>
</html>