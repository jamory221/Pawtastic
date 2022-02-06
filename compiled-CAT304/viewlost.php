<?php

include ("lost.php");

extract ($_REQUEST);

if(Isset($id))
{
$petid= $id;
}

$query=mysqli_query($conn,"select * from petlost where id=$petid ");
//$row=mysqli_fetch_array($query);
$row=mysqli_fetch_array($query);
//echo $row['id'];

$petimage= "image/lost/"."/".$row['petimage'];



?>


<!DOCTYPE html>
<html lang="en">

<head>
  <title>Lost Pet Details</title>
  <link rel="icon" href="images/favicon.png">

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
	
	 <!-- Mobile Specific Metas -->
   <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<!-- Font-->
	

	<!-- Main Style Css -->
  <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css" integrity="sha256-3sPp8BkKUE7QyPSl6VfBByBroQbKxKG7tsusY2mhbVY=" crossorigin="anonymous" />
    <link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.0.7/css/all.css">
    <link rel="stylesheet" href="viewlost.css" />
    <link rel="stylesheet" href="style.css" />
   
    
</head>
<header>
        
        <div id="menu" class="fas fa-bars"></div>

        <a href="#" class="logo"> <i class="fas fa-paw"></i> PAWTASTIC</a>
        <nav class="navbar">
            <a href="displaylost.php">Back</a>
            <a href="lost.html">Report Lost Pet</a>
            <a href="map.html">Search Nearby</a>
        </nav>

        <div class="icons">
            <a href="#" class="fas fa-user"></a>
        </div>
    </header>
<body >
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" integrity="sha256-mmgLkCYLUQbXn0B1SRqzHar6dCnv9oZFPEC1g1cwlkk=" crossorigin="anonymous" />
<div class="container">
    <div class="row">
        <div class="col-md-5">
      
            <div class="project-info-box mt-0">
                <h5 class="btn btn-lg btn-danger" style="float:right";>Lost</h5><br><br>
                <h5><?php echo $row['petname']; ?></h5><br>
                <p>Type :<?php echo $row['type']; ?></p>
                <p>Gender :<?php echo $row['gender']; ?></p>
            </div><!-- / project-info-box -->

            <div class="project-info-box">
                <p><b>Date lost:   </b><?php echo $row['date']; ?></p>
                <p><b>Description:  </b><?php echo $row['description']; ?></p>
                <p><b>State:  </b><?php echo $row['state']; ?></p>  
            </div><!-- / project-info-box -->

            <div class="project-info-box mt-0 mb-0">
                <p class="mb-0">
                    <span class="fw-bold mr-10 va-middle hide-mobile">Contact :  </span>
                    <a href="https://api.whatsapp.com/send?phone=60<?php echo $row['phone']; ?>" class="btn btn-lg btn-whatsapp btn-circle btn-icon mr-5 mb-0" style=color:green;><i class="fab fa-whatsapp"></i></a>
                    <?php echo $row['names']; ?>   |    <?php echo $row['phone']; ?> 
                </p>
            </div><!-- / project-info-box -->
        </div><!-- / column -->

        <div class="col-md-5">
            <img src="<?php echo $petimage; ?>" alt="Pet" class="rounded">
    </div>
 
        
        

    
    <div class="project-info-box" style="height:700px;width:1000px";> 
                <p><b>Location:  </b><?php echo $row['location']; ?></p>  
                <iframe width="100%" height="500" src="https://maps.google.com/maps?q=<?php echo $row['location']; ?>&output=embed"></iframe>         
    </div>

</body>

</html>
