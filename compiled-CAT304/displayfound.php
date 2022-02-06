<?php

include ("found.php");
include ( 'DBController.php');
$db_handle = new DBController();
$stateResult = $db_handle->runQuery("SELECT DISTINCT state FROM petfound ORDER BY state ASC");


?>






<!DOCTYPE html>
<html lang="en">

<head>
    <title>Found Pet</title>
    <link rel="icon" href="images/favicon.png">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!-- Font-->


    <!-- Main Style Css -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css"
        integrity="sha256-3sPp8BkKUE7QyPSl6VfBByBroQbKxKG7tsusY2mhbVY=" crossorigin="anonymous" />
    <link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.0.7/css/all.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css"
        integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">

    <link rel="stylesheet" href="display.css" />
    <link rel="stylesheet" href="style.css" />





</head>
 <header>
        
        <div id="menu" class="fas fa-bars"></div>

        <a href="#" class="logo"> <i class="fas fa-paw"></i> PAWTASTIC</a>
        <nav class="navbar">
            <a href="index.html">Home</a>
            <a href="found.html">Report Found Pet</a>
            <a href="foundnearby.php">Search Nearby</a>
        </nav>

        <div class="icons">
            <a href="#" class="fas fa-user"></a>
        </div>
    </header>
<body>

    <div class="container">
        <br />
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8">
                <form method="POST" name="search" action="displayfound.php">
                    <div id="demo-grid">
                        <div class="search-box">
                            <select id="Place" name="state[]" style="width:700px; height:50px;font-size: 16px;border:2px solid" ;>
                                <option value="0" selected="selected">Search By State</option>
                                <?php
                        if (! empty($stateResult)) {
                            foreach ($stateResult as $key => $value) {
                                echo '<option value="' . $stateResult[$key]['state'] . '">' . $stateResult[$key]['state'] . '</option>';
                            }
                        }
                        ?>
                            </select><br> <br>
                            <button class="btn btn-warning" id="Filter" style="font-size: 16px;" ;>Search</button><br><br>
                            <!--<button id="Filter">Search</button> -->
                        </div>

                        <?php
                if (! empty($_POST['state'])) {
                    ?>


                        <?php
                
                    $query = "SELECT * from petfound";
                    $i = 0;
                    $selectedOptionCount = count($_POST['state']);
                    $selectedOption = "";
                    while ($i < $selectedOptionCount) {
                        $selectedOption = $selectedOption . "'" . $_POST['state'][$i] . "'";
                        if ($i < $selectedOptionCount - 1) {
                            $selectedOption = $selectedOption . ", ";
                        }
                        
                        $i ++;
                    }
                    $query = $query . " WHERE state in (" . $selectedOption . ")";
                    
                    $result = $db_handle->runQuery($query);
                } 
                
                if (! empty($result)) {
                    ?>
                        <div class="container" id="myDIV">
                            <div class="row">
                                <div class="col-12">
                                    <div class="section-title title-left text-center text-lg-left">
                                        <h3 class="top-sep">Result Found</h3>
                                        <p>Click on a Pet Profile to view its details.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center">

                                <?php
                    foreach ($result as $key => $value) {
                      
                        ?>
                            
                                <div class="col-md-6 col-lg-4 mb-30">
                                    <div class="team-item" style="height:500px; width :300px" ;>
                                        <div class="mb-30 align-items-center">
                                            <span class="socials d-inline-block">
                                                <a href="viewfound.php?id=<?php echo $result[$key]['id']; ?>"
                                                    class="zmdi zmdi-info-outline"></a>
                                                <a href="https://api.whatsapp.com/send?phone=60<?php echo $result[$key]['phone']; ?> "
                                                    class="zmdi zmdi-whatsapp"></a>

                                            </span>
                                            <span class="img-holder d-inline-block" style=" size:2641 x 3974" ;>
                                                <a href="viewfound.php?id=<?php echo $result[$key]['id']; ?>"><img
                                                        src="image/found/<?php echo $result[$key]['petimage']; ?>"
                                                        alt="Pet"></a?>
                                            </span>
                                        </div>
                                        <div class="team-content"style="font-size: 16px;" ;>
                                            <h5 class="mb-2"><?php echo  $result[$key]['petname']; ?></h5>
                                            <a style=color:black;>Found in
                                                <?php echo  $result[$key]['state']; ?></a><br>
                                            <a style=color:black;><?php echo  $result[$key]['gender']; ?></a>
                                            <p style=color:black;><?php echo  $result[$key]['names']; ?> |
                                                <?php echo $result[$key]['date']; ?></p>


                                        </div>
                                    </div>
                                </div>
                                <span><span>
                                        <?php
                    }
                    ?>
                                        <?php
                }
                ?>
                            </div>
                        </div>
                </form>
            </div>
            <!--end of col-->
        </div>
    </div>
    <br><br>
    <div class="container" id="myDIV">
        <div class="row">
            <div class="col-12">
                <div class="section-title title-left text-center text-lg-left">
                    <h3 class="top-sep">Found Pet</h3>
                    <p>Click on a Pet Profile to view its details.</p>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">

            <?php
          
          $query=mysqli_query($conn,"SELECT *from petfound  ");
      
          while($res=mysqli_fetch_assoc($query)) { 
              $petimage= "image/found/"."/".$res['petimage'];
                  ?>

            <div class="col-md-6 col-lg-4 mb-30">
                <div class="team-item" style="height:590px" ;>
                    <div class="mb-30 align-items-center">
                        <span class="socials d-inline-block">
                            <a href="viewfound.php?id=<?php echo $res['id']; ?>" class="zmdi zmdi-info-outline"></a>
                            <a href="https://api.whatsapp.com/send?phone=60<?php echo $res['phone']; ?> "
                                class="zmdi zmdi-whatsapp"></a>

                        </span>
                        <span class="img-holder d-inline-block" style=" size:2641 x 3974" ;>
                            <a href="viewfound.php?id=<?php echo $res['id']; ?>"><img src="<?php echo $petimage; ?>"
                                    alt="Pet"></a?>
                        </span>
                    </div>
                    <div class="team-content"style="font-size: 16px;" ;>
                        <h5 class="mb-2"><?php echo $res['petname']; ?></h5>
                        <a style=color:black;>Found in <?php echo $res['state']; ?></a><br>
                        <a style=color:black;><?php echo $res['gender']; ?></a>
                        <p style=color:black;><?php echo $res['names']; ?> | <?php echo $res['date']; ?></p>


                    </div>
                </div>
            </div>
            <?php
               }
                ?>
        </div>
    </div>

</body>

</html>