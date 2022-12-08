<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="shortcut icon" type="x-icon" href="z.png">
    <title>Zolerna</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>

    <div class="main">
	<?php
			$about_description;
			if(isset($_POST['updateDescription'])){
				if ((include 'main.php') == TRUE) {
				$database = new DatabaseLink();
				$database->updateGeneralDescription("about",$_POST['aboutDescriptionText']);
				echo '<script type="text/javascript">toastr.success("Description Updated")</script>';
				$aboutResponse=$database->getGeneralData("about");
				$aboutResponseArray= mysqli_fetch_array($aboutResponse);
				$about_description=$aboutResponseArray[1];
				}
			}else{
				if ((include 'main.php') == TRUE) {
					$database = new DatabaseLink();
					$aboutResponse=$database->getGeneralData("about");
					$aboutResponseArray= mysqli_fetch_array($aboutResponse);
					$about_description=$aboutResponseArray[1];
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
        <div class="about">
            <!-- <h1>About us</h1> -->
            <h2>HR Consulting</h2>
<div>
					<?php if ($_SESSION["username"]=="admin") { ?>
						<button type="button" id="btn2"  style=" border: none;
                          font-size: 28px;
                          margin-top: 15px;
                          border-radius: 15px;
						  background-color:orange;
                          padding: 3px;
                          cursor: pointer;">Update about us Description</button>
					<?php }?>
				</div>
				<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" id="description" style="display: none;">
					<div class="container4">
						<div class="contact-box">
						<div class="left"></div>
						<div class="right">
						<textarea name="aboutDescriptionText" rows="4" cols="50" class="field"><?php echo $about_description; ?></textarea>
						<button class="btn" type="submit" name="updateDescription">Update</button>
						</div>
						</div>
					</div>
			</form> 
            <p><?php echo $about_description; ?></p>
          
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