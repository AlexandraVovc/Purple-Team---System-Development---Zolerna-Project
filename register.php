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
		function registerUserCall(){
			if (empty($_POST['firstname']) || empty($_POST['lastname']) || empty($_POST['Uuname']) || empty($_POST['newpass']) || empty($_POST['confirm'])) {
				echo '<script type="text/javascript">toastr.error("Please fill all fields")</script>';
			} else {
				if ((include 'main.php') == TRUE) {
					$database = new DatabaseLink();
					if($database->isUserExist($_POST['Uuname'])==0){
						$database->registerUser($_POST['firstname'],$_POST['lastname'],$_POST['Uuname'],$_POST['confirm']);
						echo '<script type="text/javascript">toastr.success("Successfully Registered")</script>';
					}else{
						echo '<script type="text/javascript">toastr.error("Username already registered")</script>';
					}
				}
			}
	}
		if(isset($_POST['submit'])){
			echo registerUserCall();
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
                    <li><a href="Login.php">Login</a></li>  
                    
                </ul>
                </div>
         </div> 


<div class="register" style=" width:870px; margin-top:80px; height:600px;    border-radius: 25px; background: gray;">
    <br>
         <h2 style="color:white;">REGISTER</h2><br><br>  
        
 
         <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" id="register">    
 <table>
    <tr>
        <td>
             <div class="Fname" style="background:gray; ">
             <label style="font-size:30px; color:white"><center>Enter first name</center></label> 
             <br> 
             <input type="name" name="firstname" id="name" placeholder=" " style="height:50px; width:350px; box-shadow: 0px 13px 10px  -7px rgba(0, 0, 0, 1);  ">    
             </div>  
</td>
<td>
             <div class="Lname"  style="background:gray; ">
             <label   style="font-size:30px;"><center>Enter last name</center></label>  
             <br>
             <input type="lastname" name="lastname" id="lastname" placeholder=""  style="height:50px; width:350px; box-shadow: 0px 13px 10px  -7px rgba(0, 0, 0, 1); ">    
             </div>  
</td>
<tr>
    <td>
             <div class="newUsername"  style="background:gray; ">
             <label style="font-size:30px;"><center>Enter username</center></label> 
             <br> 
             <input type="newuser" name="Uuname" id="Uuname" placeholder=""  style="height:50px; width:350px; box-shadow: 0px 13px 10px  -7px rgba(0, 0, 0, 1);">    
             </div> 
</td>
<td>
             <div class="newPassword" style="background:gray; ">
             <label  style="font-size:30px;"><center>Enter password</center></label>  
             <br>
             <input type="newpass" name="newpass" id="newpass" placeholder=""  style="height:50px; width:350px; box-shadow: 0px 13px 10px  -7px rgba(0, 0, 0, 1);">    
              </div> 
</td> 
</tr>
<tr> 
<td>
            
             <div class="submit" style="background:gray; ">
             <input type="submit" value="SUBMIT" name="submit" style=" height:50px; background:orange; border:0px;box-shadow: 0px 13px 10px  -7px rgba(0, 0, 0, 1);">
             <br><br> </div>  
</td>
 <td>
             <div class="confirm" style="background:gray;">
             <label style="font-size:30px;"><center>Confirm password</center></label>  
             <br>
             <input type="confirm" name="confirm" id="confirm" placeholder=""   style="height:50px; width:350px; box-shadow: 0px 13px 10px  -7px rgba(0, 0, 0, 1);">    
              </div>  
</td>
</tr>
             </table >
         </form>   


</div>  
</body>

</html>