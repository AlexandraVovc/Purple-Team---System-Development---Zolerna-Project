<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="shortcut icon" type="x-icon" href="z.png">
    <title>Zolerna</title>
    <link rel="stylesheet" href="style.css">
	<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>

</head>
<body>

    <div class="main">
	<?php
	$package_name;
	$package_price;
	$purchase_button;
	$database;
	if ((include 'main.php') == TRUE) {
				$database = new DatabaseLink();
				session_start();
	}
		if(isset($_GET['purchase'])){
			
				$response=$database->isPackagePurchased($_SESSION["username"]);
				if($response->num_rows==0){
					$clientResponse=$database->getLoginData($_SESSION["username"]);
					$clientResponseArray= mysqli_fetch_array($clientResponse);
					$packageResponse=$database->getPackageDataByName($_GET['package_name']);
					$packageResponseArray= mysqli_fetch_array($packageResponse);
					echo "Package Id: ".$packageResponseArray[0];
					$database->saveCartData($clientResponseArray[0],$packageResponseArray[3],$packageResponseArray[0]);
					echo '<script type="text/javascript">toastr.success("Package purchased")</script>';
				}else{
					$responseArray= mysqli_fetch_array($response);
					$packageResponse=$database->getPackageDataByName($_GET['package_name']);
					$packageResponseArray= mysqli_fetch_array($packageResponse);
					if($responseArray[4]==$packageResponseArray[0]){
						echo '<script type="text/javascript">toastr.error("Package already purchased")</script>';
					}else{
						$database->updateCartData($responseArray[3],$packageResponseArray[3],$packageResponseArray[0]);
						echo '<script type="text/javascript">toastr.success("Package upgraded")</script>';
					}
				}
		}
		if(isset($_GET['package_name'])){
			$package_name=$_GET['package_name'];
					if(isset($_SESSION["username"])){
						$response=$database->isPackagePurchased($_SESSION["username"]);
						if($response->num_rows==0){
							$purchase_button="Purchase";
							$packageResponse=$database->getPackageDataByName($package_name);
							$packageResponseArray= mysqli_fetch_array($packageResponse);
							$package_price=$packageResponseArray[3];
						}else{
							$responseArray= mysqli_fetch_array($response);
							if(!empty($responseArray[4])){
								$packageResponse=$database->getPackageDataByName($package_name);
								$packageResponseArray= mysqli_fetch_array($packageResponse);
								if($responseArray[4]==$packageResponseArray[0]){
									$purchase_button="Owned";
									$package_price=$packageResponseArray[3];
								}else{
									$purchase_button="Purchase";
									$package_price=$packageResponseArray[3];
								}
							}
						}
					}else{
						echo '<script type="text/javascript">toastr.error("Please login first")</script>';
					}
		}
	?>
        <div class="navbar">
            <div class="icon">
                <h2 class="logo">Zolerna</h2>

            </div>

            <div class="menu">
                <ul class = "nav-links">
              <li><a href="index.php">Home</a></li>
                    <li><a href="about.php">About us</a></li>
                    <li><a href="packages.html">HR Packages</a></li>
                    <li><a href="appointment.php">Appointment</a></li>
                    <li><a href="contact.php">Contact us</a></li>
                    <li><a href="faq.html">FAQ</a></li>
                    <li><a href="login.php">Login</a></li>  
                   
                </ul>
            </div>
     </div>
<body>
    <div  class="container" style="background-color: grey; width: 50%; height: 82%; margin-top: 70px; margin-left: 500px; margin-right: 500px; margin-bottom: 900px; padding: 15px;  border-radius: 25px;     opacity: 0.7;background-attachment: fixed;  ">
        <h1 style="color: white; text-align: center; padding-top: 35px; padding-bottom: 35px;" >Checkout</h1>
                <div class="container10"> 
             
                <div class = "package-row"> 
         
                 <div class = "package-col" style="width: 900px; margin-top: 100px; margin-left:30px;  margin-right:30px; margin-bottom: 100px; font-size: 25px; padding-top: 10px;">
                     
                     <pre class="tab4" name="package_name"><?php echo "Package Name:    ".$package_name; ?></pre><br>
					 <pre class="tab4" name="package_price"><?php echo "Net Price:     ".$package_price; ?></pre><br>
					 <pre class="tab4" name="total_price"><?php echo "Total Price:     ".$package_price; ?></pre>
           </div>                
          <div>
            
      </div> 
      
      </div>
	  <form method="post" action="cart.php?purchase=true&package_name=<?php echo $package_name; ?>">    
      <Button type="submit" name="purchase" style="margin-left: 40%; color: white; background-color: green; height:50px; width:200px;border-radius: 15px; font-size: medium; border: 0px;"><?php echo $purchase_button; ?></Button>
		</form>
</body>