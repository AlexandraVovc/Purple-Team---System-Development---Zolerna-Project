<?php 
    include 'main.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="shortcut icon" type="x-icon" href="z.png">
    <title>Zolerna</title>
    <link rel="stylesheet" href="style.css">
    <script src="jquery-3.6.1.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
	<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>

</head>
<body>

    <div class="main">
	
	<?php
	$database;
  if(empty($database)){
    $database = new DatabaseLink();
  }
  session_start();
	function cancelAppointmentCall(){
			if(isset($_SESSION["username"])){
			if(empty($database)){
			$database = new DatabaseLink();
			}
				$response=$database->isAppointmentExist($_SESSION["username"]);
						if($response->num_rows==0){
							echo '<script type="text/javascript">toastr.error("Appointment not exists. You can add new one")</script>';
						}else{
						$responseArray= mysqli_fetch_array($response);
							$database->cancelAppointment($responseArray[0]);
							echo '<script type="text/javascript">toastr.success("Appointment canceled")</script>';
						}
			}else{
				echo '<script type="text/javascript">toastr.error("Please login first")</script>';
			}
	}
		function bookAppointmentCall(){
			if(isset($_SESSION["username"])){
			if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['phone']) || empty($_POST['appointmentDate']) || empty($_POST['radio'])) {
				echo '<script type="text/javascript">toastr.error("Please fill all fields")</script>';
			} else {
				$radioValue=$_POST['radio'];
				$appointmentDate=$_POST['appointmentDate'];
			if(!empty($_POST['morning_desired']) && $_POST['morning_desired']=="yes"){
				$appointmentDate=$appointmentDate." AM";
			}else if(!empty($_POST['afternoon_desired']) && $_POST['afternoon_desired']=="yes"){
				$appointmentDate=$appointmentDate." PM";
			}
					if(empty($database)){
			      $database = new DatabaseLink();
			    }
					if($database->isUserExist($_SESSION["username"])==0){
						echo '<script type="text/javascript">toastr.success("User not registered")</script>';
					}else{
						$reponse=$database->isAppointmentExist($_SESSION["username"]);
						if($reponse->num_rows==0){
							$database->saveAppointment($_SESSION["username"],$_POST['name'],$_POST['email'],$_POST['phone'],$appointmentDate,$radioValue);
							echo '<script type="text/javascript">toastr.success("Appointment submitted")</script>';
						}else{
							echo '<script type="text/javascript">toastr.error("Your appointment already exists")</script>';
						}
					}
			}
			}else{
				echo '<script type="text/javascript">toastr.error("Please login first")</script>';
			}
		}
		if(isset($_POST["appointmentRequest"])) {
			echo bookAppointmentCall();
		}
		if(isset($_POST["cancelAppointmentRequest"])) {
			echo cancelAppointmentCall();
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
if($_SESSION["username"]=="admin"){

outputMySQLToHTMLTable($database->getLink(), 'appointment');
}

			?>
              
              
              <div  class="container" style="background-color: grey; width: 50%; height: 82%; margin-top: 70px; margin-left: 500px; margin-right: 500px;     opacity: 0.9;
   border-radius: 20px; margin-bottom: 900px; padding: 15px; background-attachment: fixed;  ">
                <h1 style="color: white; text-align: center; padding-top: 35px; padding-bottom: 35px;" >Appointment</h1>
                        <div class="container10"> 
                     
                        <div class = "package-row"> 
                 
                         <div class = "package-col" style="width: 900px; margin-top: 100px; margin-left:30px;  margin-right:30px; margin-bottom: 100px; font-size: 25px; padding-top: 10px;">
                         <br>

                          <button type="button" id="btn1"  style=" border: none;
                          text-align: center;
                           font-size: 28px;
                          margin-top: 15px;
                          color:white;
                          border-radius: 15px;
                          text-align: center;
                          background: #636867;  
                          opacity: 0.7;
                          padding: 15px;
                          cursor: pointer;">Add an appointment</button>
                          <br>
                          <br>
                          <br>
                          <br>

                          <div class="already">
                          <button type="button" id="btn2"  style=" border: none;
                           text-align: center;
                           font-size: 28px;
                          margin-top: 15px;
                          color:white;
                          border-radius: 15px;
                          text-align: center;
                          background: #636867;  
                          opacity: 0.7;
                          padding: 15px;
                          cursor: pointer;">Already have appointment</button> </div>

<form action="<?php echo $_SERVER['PHP_SELF'];?>" id="form" method="POST" accept-charset="UTF-8"  style="display: none;">
    <fieldset>
      <legend>For person</legend>
      <label>
        Name
        <input type="text" name="name">
      </label><br>
        <label>
          Email address
          <input type="email" name="email">
        </label><br>
        <label>
          Phone number
          <input type="tel" name="phone">
        </label>
    </fieldset>

     <br>
    <fieldset>
      <legend>Appointment request</legend>
	  <label>Select Date and Time</label>
		 
      <div class="two-cols">
		<input type="date" name="appointmentDate">
        <div class="inline">
          <label>
            <input type="hidden" name="morning_desired" value="no">
            <input type="checkbox" name="morning_desired" value="yes">
            Morning
          </label>
          <label>
            <input type="hidden" name="afternoon_desired" value="no">
            <input type="checkbox" name="afternoon_desired" value="yes">
            Afternoon
          </label>
        </div>
      </div>
      <p>Confirmation requested by: </p>
        <label>
          <input type="radio" name="radio" value="Email" checked>
          Email
        </label>
        <label>
          <input type="radio" name="radio" value="Phone">
          Phone call
        </label>
    </fieldset>
    <div class="btns">
      <input type="text" name="_gotcha" value="" style="display:none;">
      <input type="submit" name="appointmentRequest" value="Confirm">
    </div>
  </form>
  <form action="<?php echo $_SERVER['PHP_SELF'];?>" id="cancelAppointmentForm" method="POST" accept-charset="UTF-8"  style="display: none;">
  <label name="appointmentDateView" value="Date: "><br>
  <label name="appointmentTimeView" value="Time: "><br>
  <input type="submit" name="cancelAppointmentRequest" value="Cancel">
  </form>
  </div>                
                  <div>
              </div> 
              </div>



  <script>
    const btn = document.getElementById('btn1');
	const btn2 = document.getElementById('btn2');

    btn.addEventListener('click', () => {
      const form = document.getElementById('form');
    
      if (form.style.display === 'none') {
        // 👇️ this SHOWS the form
        form.style.display = 'block';
      } else {
        // 👇️ this HIDES the form
        form.style.display = 'none';
      }
    });
	btn2.addEventListener('click', () => {
      const form = document.getElementById('cancelAppointmentForm');
    
      if (form.style.display === 'none') {
        // 👇️ this SHOWS the form
        form.style.display = 'block';
      } else {
        // 👇️ this HIDES the form
        form.style.display = 'none';
      }
    });
	
    function GenerateTable() {
        //Build an array containing Customer records.
        var customers = new Array();
        customers.push(["Customer Id", "Name", "Country"]);
        customers.push([1, "John Hammond", "United States"]);
        customers.push([2, "Mudassar Khan", "India"]);
        customers.push([3, "Suzanne Mathews", "France"]);
        customers.push([4, "Robert Schidner", "Russia"]);
 
        //Create a HTML Table element.
        var table = document.createElement("TABLE");
        table.border = "1";
 
        //Get the count of columns.
        var columnCount = customers[0].length;
 
        //Add the header row.
        var row = table.insertRow(-1);
        for (var i = 0; i < columnCount; i++) {
            var headerCell = document.createElement("TH");
            headerCell.innerHTML = customers[0][i];
            row.appendChild(headerCell);
        }
 
        //Add the data rows.
        for (var i = 1; i < customers.length; i++) {
            row = table.insertRow(-1);
            for (var j = 0; j < columnCount; j++) {
                var cell = row.insertCell(-1);
                cell.innerHTML = customers[i][j];
            }
        }
 
        var dvTable = document.getElementById("dvTable");
        dvTable.innerHTML = "";
        dvTable.appendChild(table);
    }
  </script>
</body>
</html>