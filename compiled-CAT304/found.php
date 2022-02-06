<?php

// Create connection
$conn = mysqli_connect("localhost", "root", "", "pawtastic");

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['submit'])) {
    // receive all input values from the form
    $names = mysqli_real_escape_string($conn, $_POST['names']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
	$petname= mysqli_real_escape_string($conn, $_POST['petname']);
	$type = mysqli_real_escape_string($conn, $_POST['type']);
    $breed  = mysqli_real_escape_string($conn, $_POST['breed']);
	$gender  = mysqli_real_escape_string($conn, $_POST['gender']);
	$date  = mysqli_real_escape_string($conn, $_POST['date']);
	$description= mysqli_real_escape_string($conn, $_POST['description']);
    $state= mysqli_real_escape_string($conn, $_POST['state']);
    $location= mysqli_real_escape_string($conn, $_POST['location']);
    //$location = str_replace(" ", "+", $location);
	
		$petimage=$_FILES['petimage']['name'];
        $sql = "INSERT INTO petfound values (NULL,'$names','$phone','$petname','$type','$breed','$gender','$date','$description','$state','$location','$petimage');";
	
		if($sql)
		{
		mkdir("image/found");
		
		
		move_uploaded_file($_FILES['petimage']['tmp_name'],"image/found/".$_FILES['petimage']['name']);
		
		}
		

       if (mysqli_query($conn, $sql)) {
         ?>
			<script type="text/javascript">
				alert("Reported successfully");
				window.location = "foundmap.php";	
			</script>
		<?php
       
      } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      } 
    
}
?>
 

