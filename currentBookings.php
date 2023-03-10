<!DOCTYPE html> <!--no errors, navbar done-->
<?php 
session_start();
if(!isset($_SESSION['parentID'])){
  if(isset($_SESSION['babysitterID']))
  header('Location: babysitterHome.php?error=1');
  else
  header('Location: index.php?error=1');
}
?>

<html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <link rel='stylesheet' href='css/styleProject.css'>
        <link rel ='stylesheet' href='css/viewOffers.css'>
        <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js' integrity='sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8' crossorigin='anonymous'></script>
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT' crossorigin='anonymous'>
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>


        <title>Jalees</title>

    </head>

      <body>
 <!-- expand يعني اختفاء البار متى ما صغرت الشاشه -->
 <div class='navbar navbar-expand-lg navbar-light text-light ' style='background-color: rgb(227, 217, 175);'>
  <div class='container-fluid'>
    <!-- making the brand name as a heading -->
    <a class='navbar-brand mb-0 h1' href='parentHome.php'><img src='css/images/logo.png' style='width: 35%;' alt='Logo'></a>
        <!--عرض زر عند تصغير الشاشه ومنها يتم عرض عناصر البار -->
        <button class='navbar-toggler' data-bs-toggle='collapse' data-bs-target='#cNav' aria-controls='cNav' aria-expanded='false' aria-label='Toggle navigation'>
          <span class='navbar-toggler-icon'></span>
      </button>
      
  
      <!-- justify-content-end to make left allignment -->
    <div class='collapse navbar-collapse' id='cNav'>
        <!-- list of itms in the navbar -->
        <ul class='navbar-nav' style='margin-left: -200px;'>
          <li class='nav-item'><a href='parentHome.php' class='nav-link'>Home</a></li>
            <li class='nav-item dropdown'>
              <a class='nav-link dropdown-toggle active' data-bs-toggle='dropdown' href='#' role='button' aria-expanded='false'>My Bookings</a>
              <ul class='dropdown-menu'>
                <li><a class='dropdown-item active' href='currentBookings.php'>Current Bookings</a></li>
                <li><a class='dropdown-item' href='previousBookings.php'>Previous Bookings</a></li>
              </ul>
            </li>
            <li class='nav-item dropdown'>
              <a class='nav-link dropdown-toggle' data-bs-toggle='dropdown' href='#' role='button' aria-expanded='false'>My Profile</a>
              <ul class='dropdown-menu'>
                <li><a class='dropdown-item' href='viewProfileParent.php'>View Profile</a></li>
                <li><a class='dropdown-item' href='EditParentProfile.php'>Manage Profile</a></li>
                <li><a class='dropdown-item' href='php/signout.php'>Log Out</a></li>
              </ul>
            </li>
          <li class='nav-item ' ><a href='mailto:Jalees:gmail.com' class='nav-link '>Ask Us</a></li>
      </ul>
    </div>
  </div>
  </div>


            <h1 style=' text-align: center; margin-top: 3%;'>My Current Bookings</h1>
            <div class = 'bookings'>
            <?php
              include 'PHP/connection.php';
              $query = "SELECT * FROM jobRequests WHERE parentID = ".$_SESSION['parentID']." AND babysitterID IS NOT NULL AND ((CAST(CURRENT_TIMESTAMP AS DATE) < endDate) OR (CAST(CURRENT_TIMESTAMP AS DATE) = endDate AND endTime > CAST(CURRENT_TIMESTAMP AS TIME)))";
              $result = mysqli_query($connection, $query);
              if(mysqli_num_rows($result)>0){
                while($row = mysqli_fetch_array($result)){
                  $queryBabysitters = "SELECT * FROM Babysitters WHERE ID = ".$row['babysitterID']."";
                  $resultBabysitters = mysqli_query($connection, $queryBabysitters);
                 while($babysitter = mysqli_fetch_array($resultBabysitters)){
                  $offerQuery = "SELECT * FROM Offers WHERE offerStatus = 'Accepted' AND requestID =".$row['ID']." AND babysitterOfferID = ".$row['babysitterID'].";";
                  $offer = mysqli_fetch_array(mysqli_query($connection, $offerQuery));
                  echo "<article>
                  <img class='requestPicture' src = '".$babysitter['photo']."' alt='Profile Picture'> 
                  <div class = 'info'>
                  <h4 ><strong>Babysitter's name: </strong> ".$babysitter['firstName']." ".$babysitter['lastName']." </h4> 
                  <h5>Price: ".$offer['price']." SR/hour</h5>
                  <p><strong>Kid's name: </strong> ".$row['kidsNames']."<br>
                    <strong>Kid's age:</strong> ".$row['kidsAges']." years old <br>
                    <strong>Type of service:</strong> ".$row['serviceType']."<br>
                    <strong>Start date - End date:</strong> ".$row['startDate']." - ".$row['endDate']." <br>
                    <strong>Duration:</strong> ".$row['startTime']." - ".$row['endTime']."</p>
                  </div>
              </article>";
                 }
                }
              }
            
    
              ?>
            </div>

            <p class='footer'>Jalees &copy;
              <a href='mailto:Jalees@gmail.com'>Contact Us</a>
              </p>
      </body>
</html>