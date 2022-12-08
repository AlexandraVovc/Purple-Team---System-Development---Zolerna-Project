<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="shortcut icon" type="x-icon" href="z.png">
    <title>Zolerna</title>
    <link rel="stylesheet" href="style.css">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
	<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
</head>

<body>
    <div class="main">
	<?php
			$package_description;
			if(isset($_POST['updateDescription'])){
				if ((include 'main.php') == TRUE) {
				$database = new DatabaseLink();
				$database->updatePackageDescription($_POST['packageDescriptionText'],"Leadership");
				echo '<script type="text/javascript">toastr.success("Description Updated")</script>';
				$packageResponse=$database->getPackageDataByName("Leadership");
				$packageResponseArray= mysqli_fetch_array($packageResponse);
				$package_description=$packageResponseArray[2];
				}
			}else{
				if ((include 'main.php') == TRUE) {
					$database = new DatabaseLink();
					$packageResponse=$database->getPackageDataByName("Leadership");
					$packageResponseArray= mysqli_fetch_array($packageResponse);
					$package_description=$packageResponseArray[2];
				}
			}
			session_start();
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
                    <li><a href="Login.php">Login</a></li>  
                    
                </ul>
            </div>
     </div>
  

 <div  class="container" style="background-color: grey; width: 50%; height: 82%; margin-top: 70px; margin-left: 500px; margin-right: 500px; border-radius: 15px;     opacity: 0.7; margin-bottom: 900px; padding: 10px; background-attachment: fixed;  ">
    <h1 style="color: white; text-align: center; padding-top: 35px; padding-bottom: 35px">Packages</h1>
            <div class="container10"> 
         
            <div class = "package-row"> 
     
             <div class = "package-col" style="width: 900px; margin-top: 80px; margin-left:30px;  margin-right:30px; margin-bottom: 100px; font-size: 25px; padding-top: 10px;">
                <h3> Leadership Coaching </h3>
				<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" id="description" style="display: none;">
					<div class="container4">
						<div class="contact-box">
						<div class="left"></div>
						<div class="right">
						<textarea name="packageDescriptionText" rows="4" cols="50" class="field"><?php echo $package_description; ?></textarea>
						<button class="btn" type="submit" name="updateDescription">Update</button>
						</div>
						</div>
					</div>
			</form> 
				<div>
					<?php if ($_SESSION["username"]=="admin") { ?>
						<button type="button" id="btn2"  style=" border: none;
                          font-size: 28px;
                          margin-top: 15px;
                          cursor: pointer;">Edit</button>
					<?php }?>
				</div>
                 <br>
                 <p><?php echo $package_description; ?>
                </p>       
                <br>
                <i class="fas fa-cart-plus" >
                    <br>
                    <br>
                    <br>
                    <a href="cart.php?package_name=Leadership" style="text-decoration: none ; color: white ;border-radius: 20px; padding: 10px; background: #119656;  font-size: 30px;">Purchase</a>
                </i>
       </div>                
      <div>
  </div> 
  </div>      
  <script>
    const btn = document.getElementById('btn2');

    btn.addEventListener('click', () => {
      const form = document.getElementById('description');
    
      if (form.style.display === 'none') {
        // 👇️ this SHOWS the form
        form.style.display = 'block';
      } else {
        // 👇️ this HIDES the form
        form.style.display = 'none';
      }
    });
	</script>
</body>
</html>