<?include 'register.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="shortcut icon" type="x-icon" href="z.png">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
	<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>

</head>


<body>

    <div class="main">
	<?php
		function loginUserCall(){
			if (empty($_POST['Uname']) || empty($_POST['Pass'])) {
				echo '<script type="text/javascript">toastr.error("Please fill all fields")</script>';
			} else {
				if ((include 'main.php') == TRUE) {
					$database = new DatabaseLink();
					$response=$database->getLoginData($_POST['Uname']);
					if($response->num_rows==0){
						echo '<script type="text/javascript">toastr.error("Username not registered")</script>';
					}else{
						$responseArray= mysqli_fetch_array($response);
						if(!empty($responseArray[2]) && $responseArray[2]==$_POST['Pass']){
							echo '<script type="text/javascript">toastr.success("Logged in")</script>';
							session_start();
							$_SESSION["username"] = $_POST['Uname'];
							echo '<script type="text/javascript">location.href ="index.php";</script>';
						}else{
							echo '<script type="text/javascript">toastr.error("Failed to log in. Wrong uername or password")</script>';
						}
					}
				}
			}
	}
		if(isset($_POST['login'])){
			echo loginUserCall();
		} 
        
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



    
        <h2>LOGIN</h2><br><br>  
        <br>
        <br>
        <br>

        <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" id="loginn">    

            <div class="username">
            <input type="username" name="Uname" id="Uname" placeholder="Username">    
            <br><br> </div> 
            <div class="password">
            <input type="Password" name="Pass" id="Pass" placeholder="Password">    
            <br><br>    </div>  

            <div class="login">
            <input type="submit" value="Log In" name="login">		
            <br><br></div>  
            
            <div class="register">
            <input type="button" onClick = "parent.location='register.php'" value="Register">       
            <br><br>    </div>  

        </form>    
 




    </div>
</body>
</html>