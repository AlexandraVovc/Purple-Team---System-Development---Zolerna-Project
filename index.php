<?php 
    include 'main.php';
?>
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
		$database = new DatabaseLink();
		$database-> createTables();
		$database-> registerUser("admin","admin","admin","admin");
		$home_description;
			if(isset($_POST['updateDescription'])){
				$database->updateGeneralDescription("home",$_POST['homeDescriptionText']);
				echo '<script type="text/javascript">toastr.success("Description Updated")</script>';
				$homeResponse=$database->getGeneralData("home");
				$homeResponseArray= mysqli_fetch_array($homeResponse);
				$home_description=$homeResponseArray[1];
			}else{
				$homeResponse=$database->getGeneralData("home");
				$homeResponseArray= mysqli_fetch_array($homeResponse);
				$home_description=$homeResponseArray[1];
			}
			session_start();
    ?>
        <div class="navbar">
            <div class="icon">
                <h2 class="logo">Zolerna</h2>
            </div>

            <div class="menu">
                <ul>
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
        <div class="content">
			<div>
					<?php if ($_SESSION["username"]=="admin") { ?>
						<button type="button" id="btn2"  style=" border: none;
                            font-size: 28px;
                          margin-top: 15px;
                          border-radius: 15px;
						  background-color:orange;
                          padding: 3px;
                          cursor: pointer;">Update Home Description</button>
					<?php }?>
				</div>
				<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" id="description" style="display: none;">
					<div class="container4">
						<div class="contact-box">
						<div class="left"></div>
						<div class="right">
						<textarea name="homeDescriptionText" rows="4" cols="50" class="field"><?php echo $home_description; ?></textarea>
						<button class="btn" type="submit" name="updateDescription">Update</button>
						</div>
						</div>
					</div>
			</form> 
			<h1><br><span><?php echo $home_description; ?></span> <br></h1>
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