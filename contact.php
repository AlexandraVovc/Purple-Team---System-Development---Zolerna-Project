<?php 
    include 'main.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="shortcut icon" type="x-icon" href="z.png">
    <title>Zolerna</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Quicksand&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0">
	<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>

</head>
<body>

    <div class="main">
	<?php
	$database = new DatabaseLink();
		function saveInquiryCall(){
			if (empty($_POST['firstname']) || empty($_POST['lastname']) || empty($_POST['email']) || empty($_POST['message'])) {
				echo '<script type="text/javascript">toastr.error("Please fill all fields")</script>';
			} else {
					if(empty($database)){
					$database = new DatabaseLink();
					}
					if($database->saveInquiry($_POST['firstname'],$_POST['lastname'],$_POST['email'],$_POST['message'])){
						echo '<script type="text/javascript">toastr.success("Your query is submitted to admin")</script>';
					}else{
						echo '<script type="text/javascript">toastr.error("Failed to submit query")</script>';
					}
				}
		}
	if(isset($_POST["submit"])) { echo saveInquiryCall();}
        
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
			<?php
			function outputMySQLToHTMLTable(mysqli $mysqli, string $table){
    // Make sure that the table exists in the current database!
    $tableNames = array_column($mysqli->query('SHOW TABLES')->fetch_all(), 0);
    if (!in_array($table, $tableNames, true)) {
        throw new UnexpectedValueException('Unknown table name provided!');
    }
    $res = $mysqli->query('SELECT * FROM '.$table);
    $data = $res->fetch_all(MYSQLI_ASSOC);
    
    echo '<table style="width:100%; background-color:#FFFFFF; border: 1px solid black;
  border-collapse: collapse;">';
    // Display table header
    echo '<thead>';
    echo '<tr>';
    foreach ($res->fetch_fields() as $column) {
        echo '<th style="border: 1px solid black; border-collapse: collapse;">'.htmlspecialchars($column->name).'</th>';
    }
    echo '</tr>';
    echo '</thead>';
    // If there is data then display each row
    if ($data) {
        foreach ($data as $row) {
            echo '<tr>';
            foreach ($row as $cell) {
                echo '<th>'.htmlspecialchars($cell).'</th>';
            }
            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="'.$res->field_count.'">No records in the table!</td></tr>';
    }
    echo '</table>';
}
session_start();
if($_SESSION["username"]=="admin"){

outputMySQLToHTMLTable($database->getLink(), 'inquiries');
}

			?>
		<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" id="contact">
			<div class="container4">
			<div class="contact-box">
				<div class="left"></div>
				<div class="right">
					<h2>Contact Us</h2>
					<input type="text" name="firstname" class="field" placeholder="Your Name">
					<input type="text" name="lastname" class="field" placeholder="Last Name">
					<input type="text" name="email" class="field" placeholder="Email">
					<textarea name="message" placeholder="Message" class="field"></textarea>
					<button class="btn" type="submit" name="submit">Submit</button>
				</div>
			</div>
		</div>
		</form> 
</body>
</html>