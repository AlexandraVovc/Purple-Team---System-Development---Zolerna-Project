<?php 
class DatabaseLink {

    private $password = ""; 
    private $dbase = "zolerna";
    private $host = "localhost";
    private $user = "root";
    private $connection;

    function __construct () {    
        // mysql_connect($host,$user,$password);
        
        // Connection to DBase 
        $this->connection = mysqli_connect($this->host,$this->user,$this->password,$this->dbase);

        if (! $this->connection) {
			echo '<script>console.log("Database connection failed.  ");</script>';
        }
        else {
			echo '<script>console.log("Database connection sucessful.");</script>';
        }
    }

    function getLink() {
        return $this->connection;
    }
	
	function registerUser ($firstName,$lastName,$userName,$password) {
		//					insert into Person Table
        $insertIntoPersonTableQuery = mysqli_query($this->connection, "INSERT INTO Person (person_firstName, person_lastName) VALUES ('$firstName', '$lastName');");
		$personId = mysqli_insert_id($this->connection);
        if ($insertIntoPersonTableQuery) {
			echo '<script>console.log("Person data inserted.");</script>';
			//					insert into Client Table
			$insertIntoClientTableQuery = mysqli_query($this->connection, "INSERT INTO Client (client_userName, client_userPass,Person_id) VALUES ('$userName', '$password','$personId');");
			$clientId = mysqli_insert_id($this->connection);
        }
	}
	
	function getLoginData($userName){
		return mysqli_query($this->connection, "select * from Client where client_userName='$userName';");
	}
	function saveCartData($clientId,$price,$packageId){
		mysqli_query($this->connection, "INSERT INTO Cart (cart_netPrice, cart_totalPrice,Client_id,package_id) VALUES ('$price', '$price','$clientId','$packageId');");
	}
	function updateCartData($clientId,$price,$packageId){
		return mysqli_query($this->connection, "update Cart set cart_netPrice='$price',cart_totalPrice='$price',package_id='$packageId' where Client_id='$clientId';");
	}
	function updatePackageDescription($packageDescription,$packageName){
		return mysqli_query($this->connection, "update `HR Package` set package_desc='$packageDescription' where package_name='$packageName';");
	}
	function getPackageData($packageID){
		return mysqli_query($this->connection, "select * from `HR Package` where package_id='$packageID' ;");
	}
	function updateGeneralDescription($value,$description){
		return mysqli_query($this->connection, "update general set description='$description' where value_name='$value';");
	}
	function getGeneralData($value){
		return mysqli_query($this->connection, "select * from general where value_name='$value' ;");
	}
	function getPackageDataByName($packageName){
		return mysqli_query($this->connection, "select * from `HR Package` where package_name='$packageName' ;");
	}
	
	
	function isPackagePurchased($userName){
		$clientIdQuery=mysqli_query($this->connection, "select * from Client where client_userName='$userName' ;");
		$clientId =mysqli_fetch_column($clientIdQuery, 0);
		return mysqli_query($this->connection, "select * from Cart where Client_id='$clientId';");
	}
	
	function isUserExist($userName){
		$isUserExistQuery = mysqli_query($this->connection, "select Client_id from Client where client_userName='$userName' ;");
		return $isUserExistQuery->num_rows;
	}
	
	function isAppointmentExist($userName){
		$personIdQuery=mysqli_query($this->connection, "select * from Client where client_userName='$userName' ;");
		$personId =mysqli_fetch_column($personIdQuery, 3);
		return mysqli_query($this->connection, "select * from Appointment where Person_id='$personId' ;");
	}
	
	function cancelAppointment($appointmentId){
		mysqli_query($this->connection, "delete from Appointment where app_id='$appointmentId' ;");
	}
	
	function saveAppointment($username,$name,$email,$phone,$date,$confirmationtype){
		$personIdQuery=mysqli_query($this->connection, "select * from Client where client_userName='$username' ;");
		$personId =mysqli_fetch_column($personIdQuery, 3);
		//					insert into Person Table
        $updatePersonTableQuery = mysqli_query($this->connection, "update Person set person_firstName='$name',person_email='$email',person_phone='$phone' where Person_id='$personId' ;");
		if ($updatePersonTableQuery) {
				
			//					insert into Appointment Table
			$insertIntoAppointmentTableQuery = mysqli_query($this->connection, "INSERT INTO Appointment (app_date, app_confirmation,Person_id) VALUES ('$date', '$confirmationtype','$personId');");
		}
	}

	function saveInquiry ($firstName,$lastName,$email,$message) {
		//					insert into inquiries Table
        return mysqli_query($this->connection, "INSERT INTO inquiries (firstName, lastName,email,message) VALUES ('$firstName', '$lastName', '$email', '$message');");
	}

    function createTables () {
		
		//					Creating inquiries Table
        $createInquiryTable = mysqli_query($this->connection, "CREATE TABLE if not exists inquiries
        ( ".
        "Inquiry_id INT AUTO_INCREMENT, ".
        "firstName VARCHAR(50) NOT NULL, ".
        "lastName VARCHAR(50), ".
		"email VARCHAR(100), ".
		"message VARCHAR(1000), ".
        "PRIMARY KEY (Inquiry_id)
        );
        ");
        if ($createInquiryTable) {
			echo '<script>console.log("Inquiry table created.");</script>';
        } else {
            die ("Failed to create inquiry table");
        }
		
		//					Creating Person Table
        $createPersonTable = mysqli_query($this->connection, "CREATE TABLE if not exists Person
        ( ".
        "Person_id INT AUTO_INCREMENT, ".
        "person_firstName VARCHAR(50) NOT NULL, ".
        "person_lastName VARCHAR(50), ".
		"person_email VARCHAR(100), ".
		"person_phone VARCHAR(100), ".
        "PRIMARY KEY (Person_id)
        );
        ");
        if ($createPersonTable) {
			echo '<script>console.log("Person table created.");</script>';
        } else {
            die ("Failed to create person table");
        }
		
		//					Creating Appointment Table
        $createAppointmentTable = mysqli_query($this->connection, "CREATE TABLE if not exists Appointment
        ( ".
        "app_id INT NOT NULL AUTO_INCREMENT, ".
        "app_date VARCHAR(50) NOT NULL, ".
        "app_confirmation VARCHAR(50) NOT NULL, ".
		"Person_id INT, ".
        "PRIMARY KEY (app_id), ".
		"INDEX person_id (Person_id),
		FOREIGN KEY (Person_id)
        REFERENCES Person(Person_id)
        ON UPDATE CASCADE
        ON DELETE CASCADE
        );
        ");
        if ($createAppointmentTable) {
			echo '<script>console.log("Appointment table created.");</script>';
        } else {
            die ("Failed to create Appointment table");
        }
		
		//					Creating HR Package Table
        $createHRPackageTable = mysqli_query($this->connection, "CREATE TABLE if not exists `HR Package`
        ( ".
        "package_id INT NOT NULL AUTO_INCREMENT, ".
		"package_name VARCHAR(100) NOT NULL, ".
        "package_desc VARCHAR(1000) NOT NULL, ".
		"package_price INT NOT NULL, ".
        "PRIMARY KEY (package_id)
        );
        ");
        if ($createHRPackageTable) {
			echo '<script>console.log("HR Package table created.");</script>';
        } else {
            die ("Failed to create HR Package table");
        }
		//					Inserting in HR Package Table
		
		$isIndividualPackageExistQuery = mysqli_query($this->connection, "select package_id from `HR Package` where package_name='Individualized' ;");
		if(empty($isIndividualPackageExistQuery) || $isIndividualPackageExistQuery->num_rows==0){
			mysqli_query($this->connection, "INSERT INTO `HR Package`(package_name,package_desc,package_price) VALUES ('Individualized',
		'Our coaches assist employees at all levels to better understand the requirements for their jobs and the necessary competencies to meet those requirements, any gaps in their performance. Our coaches also help to develop plans for further professional development.',200
		);");
		}
        $isCorporatePackageExistQuery = mysqli_query($this->connection, "select package_id from `HR Package` where package_name='Corporate' ;");
		if(empty($isCorporatePackageExistQuery) || $isCorporatePackageExistQuery->num_rows==0){
			mysqli_query($this->connection, "INSERT INTO `HR Package`(package_name,package_desc,package_price) VALUES ('Corporate',
		'Our Team provides support to leader and members of a team to establish their team mission, vision, strategy and ways of working with one another. Through the corporate coaching process, our coachers are able to build team effectiveness and enable to resolve issues and overcome corporate barriers.',500
		);");
		}
		$isCorporatePackageExistQuery = mysqli_query($this->connection, "select package_id from `HR Package` where package_name='Leadership' ;");
		if(empty($isCorporatePackageExistQuery) || $isCorporatePackageExistQuery->num_rows==0){
			mysqli_query($this->connection, "INSERT INTO `HR Package`(package_name,package_desc,package_price) VALUES ('Leadership',
		'Our coaches help with the on going process of new assigned leaders which includes identifying key reposibilites, deliverables in the first few months and integrate the team. As well, leadership coaching encompassed developing managment skills, including communication, ability to influence, performance measurement, change managment etc.',1000
		);");
		}
		
		//					Creating General Table
        $createGeneralTable = mysqli_query($this->connection, "CREATE TABLE if not exists general
			( ".
			"value_name VARCHAR(100) NOT NULL, ".
			"description VARCHAR(1000) NOT NULL, ".
			"PRIMARY KEY (value_name)
			);
			");
        if ($createGeneralTable) {
			echo '<script>console.log("General table created.");</script>';
        } else {
            die ("Failed to create General table");
        }
		
		//					Inserting in General Table
		
		$isHomeDescExistQuery = mysqli_query($this->connection, "select description from general where value_name='home' ;");
		if(empty($isHomeDescExistQuery) || $isHomeDescExistQuery->num_rows==0){
			mysqli_query($this->connection, "INSERT INTO general(value_name,description) VALUES ('home',
		'Strategic and Flexible HR Solutions Tailored Meet Your Company - Specific Requirements'
		);");
		}
		$isAboutDescExistQuery = mysqli_query($this->connection, "select description from general where value_name='about' ;");
		if(empty($isAboutDescExistQuery) || $isAboutDescExistQuery->num_rows==0){
			mysqli_query($this->connection, "INSERT INTO general(value_name,description) VALUES ('about',
		'Zolerna is a professional Quebec-based human resources management consulting firm that provides a wide range of specialized HR services to companies across Canada. 
         At Zolerna, we are well-positioned to tackle complex HR situations with simple solutions during such times. We are committed to helping employers improve their workplace to differentiate themselves as an employer of choice by offering a well-balanced workplace.
         Our team has the know-how and expertise to successfully undertake any outsourced HR service your organization needs. 
        If you are looking to create and maintain a thriving team and organization, we’ve got you covered.'
		);");
		}
		
		//					Creating Client Table
        $createClientTable = mysqli_query($this->connection, "CREATE TABLE if not exists Client
        ( ".
        "Client_id INT NOT NULL AUTO_INCREMENT, ".
        "client_userName VARCHAR(50) NOT NULL, ".
		"client_userPass VARCHAR(50) NOT NULL, ".
		"Person_id INT, ".
        "PRIMARY KEY (Client_id), ".
		"INDEX person_id (Person_id),
		FOREIGN KEY (Person_id)
        REFERENCES Person(Person_id)
        ON UPDATE CASCADE
        ON DELETE CASCADE
        );
        ");
        if ($createClientTable) {
			echo '<script>console.log("Client table created.");</script>';
        } else {
            die ("Failed to create Client table");
        }
		
		//					Creating Cart Table
        $createCartTable = mysqli_query($this->connection, "CREATE TABLE if not exists Cart
        ( ".
        "Cart_id INT NOT NULL AUTO_INCREMENT, ".
        "cart_netPrice VARCHAR(50) NOT NULL, ".
		"cart_totalPrice VARCHAR(50) NOT NULL, ".
		"Client_id INT, ".
		"package_id INT, ".
        "PRIMARY KEY (Cart_id), ".
		"INDEX client_id (Client_id),
		FOREIGN KEY (Client_id)
        REFERENCES Client(Client_id)
        ON UPDATE CASCADE
        ON DELETE CASCADE, ".
		"INDEX package_id (package_id),
		FOREIGN KEY (package_id)
        REFERENCES `HR Package`(package_id)
        ON UPDATE CASCADE
        ON DELETE CASCADE
        );
        ");
        if ($createCartTable) {
			echo '<script>console.log("Cart table created.");</script>';
        } else {
            die ("Failed to create Cart table");
        }
    }

}
?>
